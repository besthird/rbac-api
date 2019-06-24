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

use App\Model\RoleRouter;

class RoleRouterDao extends Dao
{
    public function save($router_id, $role_id)
    {
        $model = new RoleRouter();
        $model->router_id = $router_id;
        $model->role_id = $role_id;
        return $model->save();
    }

    public function delRoleIdAll($id)
    {
        $model = RoleRouter::query()->where(['role_id' => $id]);

        if ($model) {
            $model->delete();
        }

        return true;
    }
}
