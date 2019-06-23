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
class GroupTest extends HttpTestCase
{
    public function testGroupSave()
    {
        $res = $this->post('/group/save', [
            'id' => 0,
            'project_id' => 1,
            'name' => '测试小组，误删',
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testGroupIndex()
    {
        $res = $this->get('/group', []);

        $this->assertSame(0, $res['code']);
    }

    public function testGroupDelete()
    {
        $res = $this->post('/group/delete', [
            'id' => 1,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
