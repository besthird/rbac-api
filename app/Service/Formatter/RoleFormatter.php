<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service\Formatter;

use App\Model\Role;

/**
 * Class RoleFormatter.
 */
class RoleFormatter extends Formatter
{
    public function base(Role $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'comment' => $model->comment,
            'status' => $model->status,
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];
    }

    public function small(Role $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
        ];
    }
}
