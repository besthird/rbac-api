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
use App\Model\Group;

class GroupDao extends Dao
{
    /**
     * @param int $id
     * @param bool $throw
     * @return Group
     */
    public function first($id, $throw = true)
    {
        $model = Group::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::GROUP_NOT_EXIST);
        }

        return $model;
    }

    public function delete($id)
    {
        return Group::query()->where('id', $id)->delete();
    }

    /**
     * @param $input
     * @param array $with
     * @param $offset
     * @param $limit
     * @return array
     */
    public function find($input, $with = [], $offset, $limit): array
    {
        $query = Group::query();
        if ($with) {
            $query->with(...$with);
        }
        if (isset($input['id'])) {
            $query->where('id', $input['id']);
        }
        if (isset($input['name'])) {
            $query->where('name', $input['name']);
        }
        if (isset($input['project_id'])) {
            $query->where('project_id', $input['project_id']);
        }

        return ModelHelper::pagination($query, $offset, $limit);
    }

    /**
     * @param $input
     * @param int $id
     * @return bool
     */
    public function save($input, $id = 0): bool
    {
        $model = new Group();
        if ($id > 0) {
            $model = $this->first($id);
        }

        if (! empty($input['name'])) {
            $exist = $this->exist($input['name'], $id);
            if ($exist) {
                throw new BusinessException(ErrorCode::GROUP_EXIST);
            }
            $model->name = $input['name'];
        }

        $model->project_id = $input['project_id'];

        return $model->save();
    }

    /**
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function exist(string $name, $id = 0): bool
    {
        $query = Group::query()->where('name', $name);
        if ($id > 0) {
            $query->where('id', '<>', $id);
        }

        return $query->exists();
    }
}
