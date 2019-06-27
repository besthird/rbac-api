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
class AuthTest extends HttpTestCase
{
    public function testAuthRouters()
    {
        $res = $this->get('/auth/routers', ['user_id' => 1]);

        $this->assertSame(0, $res['code']);
    }
}
