<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use App\Model\Role;
use App\Model\Router;
use App\Service\Dao\RouterDao;
use App\Service\Dao\UserDao;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CachePut;

class AuthService
{
    /**
     * @Cacheable(prefix="auth", value="#userId", ttl=86400)
     * @param mixed $userId
     */
    public function getRouters($userId): array
    {
        return $this->routers($userId);
    }

    /**
     * @CachePut(prefix="auth", value="#userId", ttl=86400)
     * @param mixed $userId
     */
    public function resetRouters($userId): array
    {
        return $this->routers($userId);
    }

    /**
     * @param int|string $userId
     * @param int|string $projectId
     * @param stirng $method
     * @param string $route
     * @return bool
     */
    public function check($userId, $projectId, $method, $route): bool
    {
        $user = di()->get(UserDao::class)->first($userId, false);
        if (empty($user)) {
            $user = di()->get(UserDao::class)->firstByKey($userId);
        }

        if ($user->isAdmin()) {
            return true;
        }

        $routers = $this->getRouters($userId);
        if ($routes = $routers[$projectId][$method]) {
            foreach ($routes as $item) {
                if ($route == $item) {
                    return true;
                }
                $preg = "/^{$item}$/";
                if (preg_match($preg, $route)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function routers($userId)
    {
        $user = di()->get(UserDao::class)->first($userId);

        if ($user->isAdmin()) {
            return $this->all();
        }

        $result = [];
        $roles = $user->roles;

        /** @var Role $role */
        foreach ($roles as $role) {
            /** @var Router $router */
            foreach ($role->router as $router) {
                if ($router->type == Router::TYPE_API) {
                    $result[$router->project_id][$router->method][] = $router->route;
                }
            }
        }

        return $result;
    }

    private function all()
    {
        $routers = di()->get(RouterDao::class)->all();
        $result = [];
        /** @var Router $router */
        foreach ($routers as $router) {
            if ($router->type == Router::TYPE_API) {
                $result[$router->project_id][$router->method][] = $router->route;
            }
        }

        return $result;
    }
}
