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
     * @Message("角色不存在")
     */
    const ROLE_NOT_EXIST = 1102;
}
