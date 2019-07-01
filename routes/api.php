<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = $router->app->make(Dingo\Api\Routing\Router::class);

$router->get('/', function () use ($api) {
    return app()->version();
});

$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    $api->post('user', 'UserController@register');
    $api->post('auth', 'AuthController@login');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->post('auth-refresh-token', 'AuthController@refresh');
        $api->get('me', 'AuthController@me');
        $api->get('user/{id}', 'UserController@show');
        $api->put('me', 'UserController@update');
        $api->put('me/change_password', 'UserController@changePassword');
    });
});