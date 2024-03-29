<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'dependencies' => [
        Hyperf\Contract\StdoutLoggerInterface::class => App\Kernel\Log\LoggerFactory::class,
        App\Kernel\Http\InnerServer::class => Hyperf\HttpServer\ServerFactory::class,
    ],
];
