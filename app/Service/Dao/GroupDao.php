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
use App\Model\Group;

class GroupDao extends Dao
{
    /**
     * @param mixed $id
     * @param mixed $throw
     * @return Group
     */
    public function first($id, $throw = true)
    {
        $model = Group::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::GROUP_NOT_EXIST);
        }

        return $model;
    }

    public function save($input, $id = 0)
    {
        $model = new Group();
        if ($id > 0) {
            $model = $this->first($id);
        }

        $model->project_id = $input['project_id'];
        $model->name = $input['name'];

        return $model->save();
    }
}
