<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("权限非法")
     */
    const AUTH_INVALID = 501;

    /**
     * @Message("重新登录")
     */
    const USRE__NOT_LOGIN_EXIST = 502;

    /**
     * @Message("参数非法")
     */
    const PARAMS_INVALID = 1000;

    /**
     * @Message("项目不存在")
     */
    const PROJECT_NOT_EXIST = 1001;

    /**
     * @Message("小组不存在")
     */
    const GROUP_NOT_EXIST = 1101;

    /**
     * @Message("小组存在")
     */
    const GROUP_EXIST = 1104;

    /**
     * @Message("角色不存在")
     */
    const ROLE_NOT_EXIST = 1302;

    /**
     * @Message("路由不存在")
     */
    const ROUTER_NOT_EXIST = 1403;

    /**
     * @Message("管理员已存在")
     */
    const USRE_EXIST = 1200;

    /**
     * @Message("管理员不存在")
     */
    const USRE_NOT_EXIST = 1204;

    /**
     * @Message("管理员密码错误")
     */
    const USRE_NOT_PASSWORD_EXIST = 1205;

    /**
     * @Message("管理员账号冻结")
     */
    const USRE_NOT_FROZEN_EXIST = 1206;

    /**
     * @Message("路由不存在")
     */
    const Router__NOT_EXIST = 1208;

    /**
     * @Message("路由存在")
     */
    const Router__EXIST = 1209;
}
