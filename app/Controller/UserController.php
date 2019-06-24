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

namespace App\Controller;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Dao\UserDao;
use App\Service\Formatter\UserFormatter;
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
     * list.
     */
    public function index()
    {
        $input = $this->request->all();
        $offset = $this->request->input('offset', 0);
        $limit = $this->request->input('limit', 0);

        $validator = Validate::make([
            'id' => 'integer>=:0',
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

        $result = $this->dao->first($id);
        return $this->response->success($result);
    }

    /**
     * save.
     */
    public function save()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require|integer|>=:0',
            'name' => 'require',
            'mobile' => 'require',
            'password' => 'require',
            'status' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->save($input, $input['id']);

        return $this->response->success($result);
    }

    public function status()
    {
        $id = $this->request->input('id');

        if (empty($id)) {
            throw new BusinessException(ErrorCode::USRE_NOT_EXIST);
        }
        $result = $this->dao->status($id);

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
}