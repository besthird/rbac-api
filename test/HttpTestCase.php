<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace HyperfTest;

use Hyperf\Testing;
use PHPUnit\Framework\TestCase;

/**
 * Class HttpTestCase.
 * @method get($uri, $data = [], $headers = [])
 * @method post($uri, $data = [], $headers = [])
 * @method json($uri, $data = [], $headers = [])
 * @method file($uri, $data = [], $headers = [])
 */
abstract class HttpTestCase extends TestCase
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = make(Testing\Client::class, ['server' => 'sdk']);
        $this->httpClient = make(Testing\Client::class);
    }

    public function __call($name, $arguments)
    {
        return $this->client->{$name}(...$arguments);
    }
}
