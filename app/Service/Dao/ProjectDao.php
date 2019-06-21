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

namespace App\Service\Dao;

use App\Kernel\Helper\ModelHelper;
use App\Model\Project;

class ProjectDao extends Dao
{
    public function find($input = [], $offset = 0, $limit = 10)
    {
        $query = Project::query();
        if (! empty($input['id'])) {
            $query->where('id', (int) $input['id']);
        }
        if (! empty($input['key'])) {
            $query->where('key', $input['key']);
        }
        if (! empty($input['name'])) {
            $query->where('name', 'like', "%{$input['key']}%");
        }

        return ModelHelper::pagination($query, $offset, $limit);
    }
}
