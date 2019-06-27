<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Middleware;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\UserInstance;
use App\Utils\JwtAuth;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $ignoreRouters = [
        '/user/login',
    ];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (! in_array($request->getUri()->getPath(), $this->ignoreRouters)) {
            $token = $request->getHeaderLine('TOKEN');
            if (! $token) {
                throw new BusinessException(ErrorCode::USRE__NOT_LOGIN_EXIST);
            }

            $verify = JwtAuth::verifyToken($token);

            if (! $verify) {
                throw new BusinessException(ErrorCode::USRE__NOT_LOGIN_EXIST);
            }

            $userId = $verify['userId'] ?? null;
            UserInstance::instance()->init($userId);
        }

        return $handler->handle($request);
    }
}
