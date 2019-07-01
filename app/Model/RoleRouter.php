<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Model;

/**
 * @property $id
 * @property $role_id
 * @property $router_id
 * @property $created_at
 * @property $updated_at
 */
class RoleRouter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_router';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'default';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'role_id', 'router_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'role_id' => 'integer', 'router_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
