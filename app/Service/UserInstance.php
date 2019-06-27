<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Role;
use App\Service\Dao\UserDao;
use Hyperf\Utils\Traits\StaticInstance;

class UserInstance
{
    use StaticInstance;

    public $user;

    public function init($userId)
    {
        if (is_int($userId)) {
            $user = di()->get(UserDao::class)->first($userId);
            $this->user = $user;

            if ($user->id === 1) {
                return $this;
            }

            /** @var Role $role */
            $role = $user->role;
            if ($role && $role->id === 1) {
                return $this;
            }
        }

        // 后台 只允许超级管理员或者超级管理角色 进入
        throw new BusinessException(ErrorCode::AUTH_INVALID);
    }
}
