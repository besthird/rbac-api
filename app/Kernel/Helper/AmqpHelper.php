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

namespace App\Kernel\Helper;

use App\Job\AmqpProducerJob;
use Hyperf\Amqp\Message\ProducerMessageInterface;

class AmqpHelper
{
    public static function produce(ProducerMessageInterface $message)
    {
        $job = new AmqpProducerJob($message);
        return QueueHelper::push($job);
    }
}
