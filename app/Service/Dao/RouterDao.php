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
use App\Kernel\Helper\ModelHelper;
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

    /**
     * @param $input
     * @param array $with
     * @param $offset
     * @param $limit
     * @return array
     */
    public function index($input, $with = [], $offset, $limit): array
    {
        $query = Router::query();
        if ($with) {
            $query->with(...$with);
        }
        if (! empty($input['name'])) {
            $query->where('route', $input['name']);
        }
        if (! empty($input['route'])) {
            $query->where('route', $input['route']);
        }
        if (! empty($input['project_id'])) {
            $query->where('project_id', $input['project_id']);
        }
        if (! empty($input['group_id'])) {
            $query->where('route', $input['group_id']);
        }

        return ModelHelper::pagination($query, $offset, $limit);
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function save($input, $id): bool
    {
        $model = new Router();
        if ($id > 0) {
            $model = $this->first($id);
        }
        $exist = $this->exist($input['name'], $id);
        if ($exist) {
            throw new BusinessException(ErrorCode::Router__EXIST);
        }
        $model->project_id = $input['project_id'];
        $model->group_id = $input['group_id'];
        $model->type = $input['type'];
        $model->name = $input['name'];
        $model->route = $input['route'];
        $model->method = $input['method'];
        return $model->save();
    }

    /**
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function exist(string $name, $id = 0): bool
    {
        $query = Router::query()->where('name', $name);
        if ($id > 0) {
            $query->where('id', '<>', $id);
        }

        return $query->exists();
    }

    /**
     * @param $id
     * @return int|mixed
     */
    public function delete($id)
    {
        return Router::query()->where('id', $id)->delete();
    }
}
