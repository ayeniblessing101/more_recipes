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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
  return str_random(32);
});

$router->group(['prefix' => '/api/v1'], function () use ($router) {
  $router->post('/users/signup', ['uses' => 'UserController@store']);
  $router->post('users/login', ['uses' =>'UserController@login']);
});

$router->group(['prefix' => '/api/v1', 'middleware' => 'auth'], function () use ($router) {
  $router->post('/recipes', ['uses' => 'RecipeController@store']);
  $router->put('/recipes/{id}', ['uses' => 'RecipeController@update']);
  $router->delete('/recipes/{id}', ['uses' => 'RecipeController@delete']);
});
