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

    public function index()
    {
        return $this->response->success();
    }

    public function save()
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

        return $this->response->success($result);
    }
}
