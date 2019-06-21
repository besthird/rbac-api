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

namespace App\Controller\Admin;

use App\Constants\ErrorCode;
use App\Controller\Controller;
use App\Exception\BusinessException;
use App\Service\Dao\ProjectDao;
use App\Service\Formatter\ProjectFormatter;
use Hyperf\Di\Annotation\Inject;
use think\Validate;

class ProjectController extends Controller
{
    /**
     * @Inject
     * @var ProjectDao
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
            $result[] = ProjectFormatter::instance()->base($item);
        }

        return $this->response->success([
            'count' => $count,
            'items' => $result,
        ]);
    }
}
