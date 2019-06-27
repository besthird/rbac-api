<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\RoleRouter;
use App\Service\Dao\RoleDao;
use App\Service\Dao\RoleRouterDao;
use App\Service\Formatter\RoleFormatter;
use App\Service\Formatter\RouterFormatter;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class RoleController extends Controller
{
    /**
     * @Inject
     * @var RoleDao
     */
    protected $dao;

    /**
     * @Inject
     * @var RoleRouterDao
     */
    protected $roleRouterDao;

    public function index()
    {
        $input = $this->request->all();
        $offset = $this->request->input('offset', 0);
        $limit = $this->request->input('limit', 10);

        $validator = Validate::make([
            'id' => 'integer|>:0',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID);
        }

        [$count, $items] = $this->dao->find($input, $offset, $limit);

        $result = [];
        foreach ($items as $item) {
            $result[] = RoleFormatter::instance()->base($item);
        }

        return $this->response->success([
            'count' => $count,
            'items' => $result,
        ]);
    }

    public function save()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require|>=:0',
            'name' => 'require',
            'comment' => 'require',
            'status' => 'require',
            'router_list' => 'array',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $model = $this->dao->save($input, $input['id']);

        // 先删除
        $rels = $this->roleRouterDao->all($model->id);

        $routers = $input['router_list'] ?? [];
        foreach ($routers as $router) {
            $rel = $rels->shift();
            if (empty($rel)) {
                $rel = new RoleRouter();
                $rel->role_id = $model->id;
            }
            $rel->router_id = $router;
            $rel->save();
        }

        // 删除多余的关联数据
        while ($rel = $rels->shift()) {
            $rel->delete();
        }

        return $this->response->success($model);
    }

    public function info()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->info($input['id']);

        return $this->response->success($result);
    }

    public function delete()
    {
        $id = $this->request->input('id', 0);

        $result = $this->dao->delete($id);

        return $this->response->success($result);
    }

    public function status()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->status($input['id']);

        return $this->response->success($result);
    }

    public function roleRouterAll()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $model = $this->dao->first($input['id']);

        $routers = $model->router()->get();
        $result = [];

        if ($routers) {
            foreach ($routers as $item) {
                $result[] = RouterFormatter::instance()->small($item);
            }
        }

        return $this->response->success($result);
    }
}
