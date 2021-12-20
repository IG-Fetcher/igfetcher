<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', [
    'as' => 'homepage',
    'uses' => 'IgFetcherController@homepage'
]);



$router->post('/user', [
    'as' => 'userinfo',
    'uses' => 'IgFetcherController@fetchUserInfos'
]);

$router->get('user/{username}', [
    'as' => 'userinfo.html',
    'uses' => 'IgFetcherController@showUserInfos'
]);

$router->get('user/{username}/json', [
    'as' => 'userinfo.json',
    'uses' => 'IgFetcherController@showUserInfosJSON'
]);
