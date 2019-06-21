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
}
