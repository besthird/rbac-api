<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Kernel\Helper;

use Hyperf\Amqp\Message\ProducerMessageInterface;
use Hyperf\Amqp\Producer;

class AmqpHelper
{
    public static function produce(ProducerMessageInterface $message, int $times = 2)
    {
        return retry($times, function () use ($message) {
            return di()->get(Producer::class)->produce($message, true);
        });
    }
}
