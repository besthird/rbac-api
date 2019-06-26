<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Dao\GroupDao;
use App\Service\Dao\ProjectDao;
use App\Service\Dao\RouterDao;
use App\Service\Formatter\RouterFormatter;
use App\Service\RouterService;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class RouterController extends Controller
{
    /**
     * @Inject
     * @var RouterDao
     */
    protected $dao;

    /**
     * @Inject
     * @var ProjectDao
     */
    protected $projectDao;

    /**
     * @Inject
     * @var GroupDao
     */
    protected $groupDao;

    /**
     * @return object
     */
    public function index(): object
    {
        $input = $this->request->all();
        $offset = $this->request->input('offset', 0);
        $limit = $this->request->input('limit', 5);

        $validator = Validate::make([
            'id' => 'integer|>=:0',
        ]);
        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::ROLE_NOT_EXIST, (string) $validator->getError());
        }

        [$count, $items] = $this->dao->index($input, ['project', 'group'], $offset, $limit);
        $result = [];
        foreach ($items as $item) {
            $result[] = RouterFormatter::instance()->detail($item, $item->project, $item->group);
        }

        return $this->response->success([
            'count' => $count,
            'items' => $result,
        ]);
    }

    /**
     * @return object
     */
    public function save(): object
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require|integer|>=:0',
            'project_id' => 'require|integer|>:0',
            'group_id' => 'require|integer|>:0',
            'type' => 'require',
            'name' => 'require',
            'route' => 'require',
            'method' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $this->projectDao->first($input['project_id']);

        $this->groupDao->first($input['group_id']);

        $result = $this->dao->save($input, $input['id']);

        di()->get(RouterService::class)->resetRouters();

        return $this->response->success($result);
    }

    /**
     * @return object
     */
    public function delete(): object
    {
        $id = $this->request->input('id');

        if (empty($id)) {
            throw new BusinessException(ErrorCode::ROLE_NOT_EXIST);
        }
        $result = $this->dao->delete($id);

        return $this->response->success($result);
    }

    /**
     * @return object
     */
    public function find(): object
    {
        $id = $this->request->input('id');

        if (empty($id)) {
            throw new BusinessException(ErrorCode::Router__NOT_EXIST);
        }
        $result = $this->dao->first($id);

        return $this->response->success($result);
    }
}
