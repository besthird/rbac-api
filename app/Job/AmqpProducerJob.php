<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Job;

use Hyperf\Amqp\Message\ProducerMessageInterface;
use Hyperf\Amqp\Producer;
use Hyperf\AsyncQueue\Job;

class AmqpProducerJob extends Job
{
    public $message;

    protected $maxAttempts = 2;

    public function __construct(ProducerMessageInterface $message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        retry($this->getMaxAttempts(), function () {
            di()->get(Producer::class)->produce($this->message, true);
        });
    }
}
