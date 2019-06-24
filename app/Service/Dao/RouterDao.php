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

namespace App\Service\Dao;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Router;

class RouterDao extends Dao
{
    /**
     * @param mixed $id
     * @param mixed $throw
     * @return Router
     */
    public function first($id, $throw = true)
    {
        $model = Router::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::ROUTER_NOT_EXIST);
        }

        return $model;
    }

    public function save($input, $id)
    {
        $model = new Router();
        if ($id > 0) {
            $model = $this->first($id);
        }
        $model->project_id = $input['project_id'];
        $model->group_id = $input['group_id'];
        $model->type = $input['type'];
        $model->name = $input['name'];
        $model->route = $input['route'];
        $model->method = $input['method'];
    }
}
