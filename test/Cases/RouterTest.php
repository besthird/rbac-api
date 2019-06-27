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
        $res = $this->json('/router/save', [
            'id' => 1,
            'project_id' => 1,
            'group_id' => 1,
            'type' => 1,
            'name' => '默认路由',
            'route' => '/',
            'method' => 'GET',
        ]);

        return $this->assertSame(0, $res['code']);
    }

    public function testRouterDelete()
    {
        $res = $this->post('/router/delete', [
            'id' => 2,
        ]);

        return $this->assertSame(0, $res['code']);
    }

    public function testRouterFind()
    {
        $res = $this->get('/router/find', [
            'id' => 1,
        ]);

        return $this->assertSame(0, $res['code']);
    }
}
