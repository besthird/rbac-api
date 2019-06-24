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

use App\Model\User;

class UserFormatter extends Formatter
{
    public function base(User $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'mobile' => $model->mobile,
            'password' => $model->password,
            'status' => $model->status,
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];
    }
}
