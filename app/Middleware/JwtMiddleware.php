<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Utils\JwtAuth;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = '';
        $headers = $request->getHeader('TOKEN');
        if ($headers){
            $token = $headers[0];
        }
        if (!$token){
            throw new BusinessException(ErrorCode::USRE__NOT_LOGIN_EXIST);
        }

        $verify = JwtAuth::verifyToken($token);

        if (!$verify) {
            throw new BusinessException(ErrorCode::USRE__NOT_LOGIN_EXIST);
        }

        return $handler->handle($request);
    }
}