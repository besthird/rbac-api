<?php

declare(strict_types=1);
/**
 * This file is part of Besthird.
 *
 * @document https://besthird.github.io/rbac-doc/
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Utils;

use Firebase\JWT\JWT;

/**
 * Class JwtAuth.
 */
class JwtAuth
{
    public static $key = 'TOKEN';

    public static function getToken(int $userId)
    {
        $time = time();
        $token = [
            'iss' => 'besthird',
            'aud' => 'user',
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time + 7200,
            'data' => [
                'userid' => $userId,
            ],
        ];

        return JWT::encode($token, self::$key);
    }

    public static function verifyToken($token)
    {
        try {
            $arr = JWT::decode($token, self::$key, ['HS256']);
            return $arr->data->userid;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
