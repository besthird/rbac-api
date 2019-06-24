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
use App\Model\Role;

class RoleDao extends Dao
{
    /**
     * @param mixed $id
     * @param mixed $throw
     * @return Role
     */
    public function first($id, $throw = true)
    {
        $model = Role::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::ROLE_NOT_EXIST);
        }

        return $model;
    }

    public function find($input = [], $offset = 0, $limit = 10)
    {
        $query = Role::query();

        if (! empty($input['name'])) {
            $query->where('name', 'like', "%{$input['name']}%");
        }

        if (isset($input['status'])) {
            $query->where('status', $input['status']);
        }

        return ModelHelper::pagination($query, $offset, $limit);
    }

    public function save($input, $id)
    {
        $model = new Role();
        if ($id > 0) {
            $model = $this->first($id);
        }

        $model->name = $input['name'];
        $model->comment = $input['comment'];
        $model->status = $input['status'];
        return $model->save();
    }

    public function info($id)
    {
        if (! $id) {
            return [];
        }
        return $this->first($id);
    }

    public function delete($id)
    {
        $model = $this->first($id, false);

        if ($model) {
            $model->delete();
        }

        return true;
    }

    public function status($id)
    {
        $model = $this->first($id);
        $model->status = $model->status == 0 ? 1 : 0;
        return $model->save();
    }
}
