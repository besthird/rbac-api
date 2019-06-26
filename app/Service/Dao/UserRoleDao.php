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

use App\Model\UserRole;

class UserRoleDao extends Dao
{
    /**
     * 添加userRole.
     * @param $role_id
     * @param $user_id
     * @return bool
     */
    public function save($role_id, $user_id): bool
    {
        $model = new UserRole();

        $model->role_id = $role_id;
        $model->user_id = $user_id;

        return $model->save();
    }

    public function all($userId)
    {
        return UserRole::query()->where('user_id', $userId)->get();
    }
}
