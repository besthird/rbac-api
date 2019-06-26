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
class RoleTest extends HttpTestCase
{
    public function testRoleIndex()
    {
        $res = $this->get('/role', []);

        $this->assertSame(0, $res['code']);
    }

    public function testRoleSave()
    {
        $res = $this->json('/role/save', [
            'id' => 1,
            'name' => '超级角色',
            'comment' => '超级管理员权限角色',
            'status' => 1,
            'router_list' => [1],
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testRoleDelete()
    {
        $res = $this->json('/role/delete', [
            'id' => 2,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
