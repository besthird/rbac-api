<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use App\Service\Dao\ProjectDao;
use App\Service\Formatter\ProjectFormatter;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CachePut;

class RouterService
{
    /**
     * @Cacheable(prefix="routers", value="all", ttl=864000)
     */
    public function getRouters()
    {
        return $this->routers();
    }

    /**
     * @CachePut(prefix="routers", value="all", ttl=864000)
     */
    public function resetRouters()
    {
        return $this->routers();
    }

    private function routers(): array
    {
        $result = [];
        $models = di()->get(ProjectDao::class)->all();

        if ($models) {
            foreach ($models as $model) {
                $result[] = ProjectFormatter::instance()->route($model);
            }
        }

        return $result;
    }
}
