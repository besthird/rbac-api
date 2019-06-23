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

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Kernel\Helper\ModelHelper;
use App\Model\Project;

class ProjectDao extends Dao
{
    /**
     * @param mixed $id
     * @param mixed $throw
     * @return Project
     */
    public function first($id, $throw = true)
    {
        $model = Project::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::PROJECT_NOT_EXIST);
        }

        return $model;
    }

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

    public function save($input, $id)
    {
        $model = new Project();
        if ($id > 0) {
            $model = $this->first($id);
        }

        $model->fill($input);
        return $model->save();
    }

    /**
     * 获取项目
     * @param $id
     * @return Project|array
     */
    public function info($id)
    {
        if (!$id) {
            return [];
        }
        return $this->first($id);
    }

    public function delete($id)
    {
        $model = $this->first($id, false);

        if ($model) {
            $model->delete();
        }

        return true;
    }
}
