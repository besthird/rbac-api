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

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class RouterTest extends HttpTestCase
{
    public function testRouterIndex()
    {
        $res = $this->get('/router/index', [
            'id' => 0,
        ]);

        return $this->assertSame(0, $res['code']);
    }

    public function testRouterSave()
    {
        $res = $this->post('/router/save', [
            'id' => 0,
            'project_id' => '1',
            'group_id' => '1',
            'type' => '1',
            'name' => '管理员' . rand(0, 100),
            'route' => '/user',
            'method' => 'get',
        ]);

        return $this->assertSame(0, $res['code']);
    }

    public function testRouterDelete()
    {
        $res = $this->post('/router/delete', [
            'id' => 1,
        ]);

        return $this->assertSame(0, $res['code']);
    }

    public function testRouterFind()
    {
        $res = $this->get('/router/find', [
            'id' => 2,
        ]);

        return $this->assertSame(0, $res['code']);
    }
}
