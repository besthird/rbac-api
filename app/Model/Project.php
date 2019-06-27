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
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project';

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
    protected $fillable = ['id', 'key', 'name', 'comment', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function group()
    {
        return $this->hasMany(Group::class, 'project_id', 'id');
    }
}
