<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends HttpTestCase
{
    public function testUserSave()
    {
        $res = $this->post('/user/save', [
            'id' => 1,
            'role_id' => [1, 3],
            'name' => '超级管理员',
            'key' => 'admin',
            'mobile' => '15963611521',
            'password' => 'besthird',
            'status' => 1,
        ]);

        $this->assertSame(0, $res['code']);

        $res = $this->httpClient->post('/user/login', [
            'mobile' => '15963611521',
            'password' => 'besthird',
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testUserIndex()
    {
        $res = $this->get('/user', [
            'limit' => 5,
            'name' => '',
            'mobile' => '',
            'status' => 1,
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testUserDelete()
    {
        $res = $this->post('/user/delete', [
            'id' => 2,
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testUserFind()
    {
        $res = $this->get('/user/find', [
            'id' => 1,
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testUserStatus()
    {
        $this->post('/user/status', ['id' => 1]);
        $res = $this->post('/user/status', ['id' => 1]);

        $this->assertSame(0, $res['code']);
    }
}
