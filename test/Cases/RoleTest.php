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
            'id' => 0,
            'name' => '角色1',
            'comment' => '角色1测试',
            'status' => 1
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testRoleDelete()
    {
        $res = $this->json('/role/delete', [
            'id' => 1,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
