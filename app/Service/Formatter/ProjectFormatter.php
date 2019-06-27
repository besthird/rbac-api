<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service\Formatter;

use App\Model\Project;

class ProjectFormatter extends Formatter
{
    public function base(Project $model)
    {
        return [
            'id' => $model->id,
            'key' => $model->key,
            'name' => $model->name,
            'comment' => $model->comment,
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];
    }

    public function small(Project $model)
    {
        return [
            'id' => $model->id,
            'key' => $model->key,
            'name' => $model->name,
        ];
    }

    public function route(Project $model)
    {
        $result = $this->small($model);
        $models = $model->group()->get();
        foreach ($models as $key => $model) {
            $result['children'][$key] = GroupFormatter::instance()->small($model);
            $routers = $model->routers()->get();
            foreach ($routers as $item) {
                $result['children'][$key]['children'][] = RouterFormatter::instance()->small($item);
            }
        }

        return $result;
    }
}
