<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Middleware;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Request;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DebugMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $time = microtime(true);
        $response = $handler->handle($request);

        $container = ApplicationContext::getContainer();
        $logger = $container->get(LoggerFactory::class)->get('request');

        /** @var Request $request */
        $request = $container->get(RequestInterface::class);
        $result = $response->getBody()->getContents();

        // 日志
        $time = microtime(true) - $time;
        $debug = 'URL: ' . $request->getUri() . PHP_EOL;
        $debug .= 'TIME: ' . $time . PHP_EOL;
        $debug .= 'PARAMS: ' . $request->getBody()->getContents() . PHP_EOL;
        $debug .= 'RESPONSE: ' . $result . PHP_EOL;

        if ($time > 1) {
            $logger->error($debug);
        } else {
            $logger->info($debug);
        }

        return $response;
    }
}
