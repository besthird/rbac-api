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

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/project', 'App\Controller\ProjectController@index');
//Router::post('/project/save', 'App\Controller\ProjectController@save');
Router::addRoute(['OPTIONS', 'POST'], '/project/save', 'App\Controller\ProjectController@save');
Router::addRoute(['OPTIONS', 'GET'], '/project/info', 'App\Controller\ProjectController@info');
Router::addRoute(['OPTIONS', 'GET'], '/project/delete', 'App\Controller\ProjectController@delete');
