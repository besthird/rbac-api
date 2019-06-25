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
Router::post('/project/save', 'App\Controller\ProjectController@save');
Router::get('/project/info', 'App\Controller\ProjectController@info');
Router::post('/project/delete', 'App\Controller\ProjectController@delete');
Router::get('/project/router/list', 'App\Controller\ProjectController@projectRouterList');

Router::post('/group/save', 'App\Controller\GroupController@save');
Router::get('/group', 'App\Controller\GroupController@index');
Router::post('/group/delete', 'App\Controller\GroupController@delete');
Router::get('/group/find', 'App\Controller\GroupController@find');

Router::post('/user/save', 'App\Controller\UserController@save');
Router::get('/user', 'App\Controller\UserController@index');
Router::post('/user/delete', 'App\Controller\UserController@delete');
Router::get('/user/find', 'App\Controller\UserController@find');
Router::post('/user/status', 'App\Controller\UserController@status');
Router::post('/user/login', 'App\Controller\UserController@login');

Router::get('/role', 'App\Controller\RoleController@index');
Router::post('/role/save', 'App\Controller\RoleController@save');
Router::get('/role/info', 'App\Controller\RoleController@info');
Router::post('/role/delete', 'App\Controller\RoleController@delete');
Router::post('/role/status', 'App\Controller\RoleController@status');
Router::get('/role/router/list', 'App\Controller\RoleController@roleRouterAll');

