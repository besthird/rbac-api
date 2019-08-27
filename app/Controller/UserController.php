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
use App\Model\UserRole;
use App\Service\Dao\UserDao;
use App\Service\Dao\UserRoleDao;
use App\Service\Formatter\UserFormatter;
use App\Utils\JwtAuth;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class UserController extends Controller
{
    /**
     * @Inject
     * @var UserDao
     */
    protected $dao;

    /**
     * @Inject
     * @var UserRoleDao
     */
    protected $userRole;

    /**
     * list.
     */
    public function index()
    {
        $input = $this->request->all();
        $offset = $this->request->input('offset', 0);
        $limit = $this->request->input('limit', 10);

        $validator = Validate::make([
            'id' => 'integer|>=:0',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        [$count, $items] = $this->dao->find($input, $offset, $limit);
        $result = [];
        foreach ($items as $item) {
            $result[] = UserFormatter::instance()->base($item);
        }

        return $this->response->success([
            'count' => $count,
            'items' => $result,
        ]);
    }

    /**
     * find.
     */
    public function find()
    {
        $id = $this->request->input('id');

        if (empty($id)) {
            throw new BusinessException(ErrorCode::USRE_NOT_EXIST);
        }

        $model = $this->dao->first($id);
        $result = UserFormatter::instance()->base($model);
        return $this->response->success($result);
    }

    /**
     * save.
     */
    public function save()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'integer|>=:0',
            'key' => 'require',
            'name' => 'require',
            'role_id' => 'require|>=:0',
            'mobile' => 'require|mobile',
            'status' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $user = $this->dao->save($input, $input['id'] ?? null);
        $roleIds = $input['role_id'];
        $rels = $this->userRole->all($user->id);

        foreach ($roleIds as $roleId) {
            $rel = $rels->shift();
            if (empty($rel)) {
                $rel = new UserRole();
                $rel->user_id = $user->id;
            }
            $rel->role_id = $roleId;
            $rel->save();
        }

        while ($rel = $rels->shift()) {
            $rel->delete();
        }

        $result = UserFormatter::instance()->base($user);

        return $this->response->success($result);
    }

    public function status()
    {
        $id = $this->request->input('id');

        if (empty($id)) {
            throw new BusinessException(ErrorCode::USRE_NOT_EXIST);
        }

        $result = false;
        if ($id != 1) {
            $result = $this->dao->status($id);
        }

        return $this->response->success($result);
    }

    /**
     * delete.
     */
    public function delete()
    {
        $id = $this->request->input('id');

        if (empty($id)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID);
        }
        $result = $this->dao->delete($id);

        return $this->response->success($result);
    }

    public function login()
    {
        $result = [];
        $input = $this->request->all();

        $validator = Validate::make([
            'mobile' => 'require',
            'password' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $model = $this->dao->firstMobile($input['mobile']);

        // 判断账号密码是否正确
        if (! password_verify($input['password'], $model->password)) {
            throw new BusinessException(ErrorCode::USRE_NOT_PASSWORD_EXIST);
        }

        // 判断是否冻结
        if ($model->status == 0) {
            throw new BusinessException(ErrorCode::USRE_NOT_FROZEN_EXIST);
        }

        $token = JwtAuth::getToken($model->id);

        $result['token'] = $token;

        return $this->response->success($result);
    }
}
