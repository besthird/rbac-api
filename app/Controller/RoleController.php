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
use App\Service\Dao\RoleDao;
use App\Service\Formatter\RoleFormatter;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class RoleController extends Controller
{
    /**
     * @Inject
     * @var RoleDao
     */
    protected $dao;

    public function index()
    {
        $input = $this->request->all();
        $offset = $this->request->input('offset', 0);
        $limit = $this->request->input('limit', 10);

        $validator = Validate::make([
            'id' => 'integer|>:0',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID);
        }

        [$count, $items] = $this->dao->find($input, $offset, $limit);

        $result = [];
        foreach ($items as $item) {
            $result[] = RoleFormatter::instance()->base($item);
        }

        return $this->response->success([
            'count' => $count,
            'items' => $result,
        ]);
    }

    public function save()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require',
            'name' => 'require',
            'comment' => 'require',
            'status' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->save($input, $input['id']);

        return $this->response->success($result);
    }

    public function info()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->info($input['id']);

        return $this->response->success($result);
    }

    public function delete()
    {
        $id = $this->request->input('id', 0);

        $result = $this->dao->delete($id);

        return $this->response->success($result);
    }

    public function status()
    {
        $input = $this->request->all();

        $validator = Validate::make([
            'id' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->status($input['id']);

        return $this->response->success($result);
    }
}
