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
 * @property int $project_id
 * @property int $group_id
 * @property int $type
 * @property string $name
 * @property string $route
 * @property string $method
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Router extends Model
{
    const TYPE_VIEW = 0;

    const TYPE_API = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'router';

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
    protected $fillable = ['id', 'project_id', 'group_id', 'type', 'name', 'route', 'method', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'project_id' => 'integer', 'group_id' => 'integer', 'type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
