<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

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
            $result = $this->auth->resetRouters($userId);
        }

        return $this->response->success($result);
    }

    /**
     * 验证用户是否存在当前路由.
     */
    public function check()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'user_id' => 'require',
            'project_id' => 'require',
            'method' => 'require',
            'route' => 'require',
        ]);


        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $bool = $this->auth->check($input['user_id'], $input['project_id'], $input['method'], $input['route']);

        return $this->response->success($bool);
    }
}
