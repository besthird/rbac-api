<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service\Formatter;

use App\Model\Group;
use App\Model\Project;
use App\Model\Router;

class RouterFormatter extends Formatter
{
    public function small(Router $model)
    {
        return [
            'id' => $model->id,
            'project_id' => $model->project_id,
            'group_id' => $model->group_id,
            'type' => $model->type,
            'name' => $model->name,
            'route' => $model->route,
            'method' => $model->method,
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];
    }

    public function detail(Router $model, ?Project $project, ?Group $group)
    {
        $result = $this->small($model);
        $result['project'] = ProjectFormatter::instance()->small($project);
        $result['group'] = GroupFormatter::instance()->small($group);
        return $result;
    }
}
