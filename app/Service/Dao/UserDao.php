<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service\Dao;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Kernel\Helper\ModelHelper;
use App\Model\User;

class UserDao extends Dao
{
    /**
     * @param $id
     * @param bool $throw
     * @return User
     */
    public function first($id, $throw = true)
    {
        $model = User::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::USRE_NOT_EXIST);
        }

        return $model;
    }

    /**
     * @param $key
     * @param bool $throw
     * @return User
     */
    public function firstByKey($key, $throw = true)
    {
        $model = User::query()->where('key', $key)->first();
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::USRE_NOT_EXIST);
        }
        return $model;
    }

    /**
     * @param $mobile
     * @return null|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object
     */
    public function firstMobile($mobile)
    {
        $model = User::query()->where(['mobile' => $mobile])->first();
        if (! $model) {
            throw new BusinessException(ErrorCode::USRE_NOT_EXIST);
        }

        return $model;
    }

    public function delete($id)
    {
        return User::query()->where('id', $id)->delete();
    }

    /**
     * @param $input
     * @param $offset
     * @param $limit
     * @return array
     */
    public function find($input, $offset, $limit): array
    {
        $query = User::query();
        if (isset($input['id']) && ! empty($input['id'])) {
            $query->where('id', $input['id']);
        }
        if (isset($input['name']) && ! empty($input['name'])) {
            $query->where('name', $input['name']);
        }
        if (isset($input['mobile']) && ! empty($input['mobile'])) {
            $query->where('mobile', $input['mobile']);
        }
        if (isset($input['status'])) {
            $query->where('status', $input['status']);
        }

        return ModelHelper::pagination($query, $offset, $limit);
    }

    /**
     * @param $input
     * @param int|string $id
     * @return object
     */
    public function save($input, $id = 0): object
    {
        if ($id === null) {
            $model = $this->firstByKey($input['key']);
        } elseif ($id > 0) {
            $model = $this->first($id);
        } else {
            $model = new User();
            $model->key = $input['key'];
        }

        if (! empty($input['name'])) {
            $exist = $this->exist($input['name'], $id);
            if ($exist) {
                throw new BusinessException(ErrorCode::USRE_EXIST);
            }
            $model->name = $input['name'];
        }

        if (! empty($input['mobile'])) {
            $model->mobile = $input['mobile'];
        }
        if (! empty($input['key'])) {
            $model->key = $input['key'];
        }
        if (! empty($input['password'])) {
            $cost = 12;
            $option = ['cost' => $cost];
            $model->password = password_hash($input['password'], PASSWORD_BCRYPT, $option);
        }
        if (! empty($input['status'])) {
            $model->status = $input['status'];
        }
        $model->save();
        return $model;
    }

    public function status($id)
    {
        $model = $this->first($id);
        $model->status = $model->status == 0 ? 1 : 0;

        return $model->save();
    }

    /**
     * 当前登录名是否已经存在.
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function exist(string $name, $id = 0): bool
    {
        $query = User::query()->where('name', $name);
        if ($id > 0) {
            $query->where('id', '<>', $id);
        }

        return $query->exists();
    }
}
