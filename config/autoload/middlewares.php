<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'http' => [
        \App\Middleware\CorsMiddleware::class,
        \App\Middleware\DebugMiddleware::class,
        \App\Middleware\JwtMiddleware::class,
    ],
    'sdk' => [
        \App\Middleware\DebugMiddleware::class,
    ],
];
