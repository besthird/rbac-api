<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;

class AuthController extends Controller
{
    /**
     * @Inject
     * @var AuthService
     */
    protected $auth;

    /**
     * 用户所有路由.
     */
    public function routers()
    {
        $userId = $this->request->input('user_id', 0);
        $result = [];
        if ($userId > 0) {
            $result = $this->auth->getRouters($userId);
        }

        return $this->response->success($result);
    }

    /**
     * 验证用户是否存在当前路由.
     */
    public function check()
    {
    }
}
