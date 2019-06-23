<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-06-23
 * Time: 20:41
 */

namespace App\Service\Formatter;

use App\Model\Role;

/**
 * Class RoleFormatter
 * @package App\Service\Formatter
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
}