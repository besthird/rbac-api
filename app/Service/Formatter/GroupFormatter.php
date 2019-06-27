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

class GroupFormatter extends Formatter
{
    public function base(Group $model)
    {
        return [
            'id' => $model->id,
            'project_id' => $model->project_id,
            'name' => $model->name,
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->created_at,
        ];
    }

    public function small(Group $model)
    {
        return [
            'id' => $model->id,
            'project_id' => $model->project_id,
            'name' => $model->name,
        ];
    }

    public function detail(Group $model, ?Project $project = null)
    {
        $result = $this->base($model);
        $result['project'] = ProjectFormatter::instance()->small($project);
        return $result;
    }
}
