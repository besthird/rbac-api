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
 * @property $name
 * @property $mobile
 * @property $password
 * @property $status
 * @property $created_at
 * @property $updated_at
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

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
    protected $fillable = ['id', 'name', 'mobile', 'password', 'status', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer'];

    public function role()
    {
        return $this->hasOne(Role::class, 'user_id', 'id')->orderBy('id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id', 'id');
    }

    public function isAdmin(): bool
    {
        if ($this->id === 1) {
            return true;
        }

        if ($this->role && $this->role->id === 1) {
            return true;
        }

        return false;
    }
}
