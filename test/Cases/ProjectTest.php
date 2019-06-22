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
class ProjectTest extends HttpTestCase
{
    public function testProjectIndex()
    {
        $res = $this->get('/project', []);

        $this->assertSame(0, $res['code']);
    }

    public function testProjectSave()
    {
        $res = $this->json('/project/save', [
            'id' => 1,
            'key' => 'test',
            'name' => '单测专用项目',
            'comment' => '单测专用项目, 勿动',
        ]);

        $this->assertSame(0, $res['code']);
    }

    public function testProjectDelete()
    {
        $res = $this->json('/project/delete', [
            'id' => 2,
        ]);

        $this->assertSame(0, $res['code']);
    }
}
