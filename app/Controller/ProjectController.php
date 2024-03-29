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
use App\Service\Dao\ProjectDao;
use App\Service\Formatter\ProjectFormatter;
use App\Service\RouterService;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class ProjectController extends Controller
{
    /**
     * @Inject
     * @var ProjectDao
     */
    protected $dao;

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
            $result[] = ProjectFormatter::instance()->base($item);
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
            'id' => 'require',
            'key' => 'require',
            'name' => 'require',
            'comment' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->save($input, $input['id']);

        di()->get(RouterService::class)->resetRouters();

        return $this->response->success($result);
    }

    /**
     * 获取项目名称.
     * @return \App\Kernel\Http\Response|mixed
     */
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
        $id = $this->request->input('project_id', 0);

        $result = $this->dao->delete($id);

        di()->get(RouterService::class)->resetRouters();

        return $this->response->success($result);
    }

    public function projectRouterList()
    {
        $result = di()->get(RouterService::class)->getRouters();

        return $this->response->success($result);
    }
}
