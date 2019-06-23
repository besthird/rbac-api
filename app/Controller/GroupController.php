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
use App\Service\Dao\GroupDao;
use App\Service\Formatter\GroupFormatter;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class GroupController extends Controller
{
    /**
     * @Inject
     * @var GroupDao
     */
    protected $dao;

    public function index()
    {
        $input = $this->request->all();
        $offset = $this->request->input('offset', 0);
        $limit = $this->request->input('limit', 10);

        $validator = Validate::make([
            'id' => 'integer|>=:0',
            'project_id' => 'integer|>=:0',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        [$count,$items] = $this->dao->find($input, ['project'], $offset, $limit);

        $result = [];
        foreach ($items as $item) {
            $result[] = GroupFormatter::instance()->detail($item, $item->project);
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
            'id' => 'require|integer|>=:0',
            'project_id' => 'require|integer|>=:0',
            'name' => 'require',
        ]);

        if (! $validator->check($input)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID, (string) $validator->getError());
        }

        $result = $this->dao->save($input, $input['id']);

        return $this->response->success($result);
    }

    public function delete()
    {
        $id = $this->request->input('id', 0);

        if (empty($id)) {
            throw new BusinessException(ErrorCode::PARAMS_INVALID);
        }

        $result = $this->dao->delete($id);

        return $this->response->success($result);
    }
}
