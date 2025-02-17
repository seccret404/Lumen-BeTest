<?php

use App\Http\Controllers\UserController;

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

 $router->group(['prefix' => 'users'], function () use ($router){

    $router->get('/',[UserController::class,'getUserAll']);
    $router->get('/{id}',[UserController::class,'getUserById']);
    $router->post('/',[UserController::class, 'addUser']);
    $router->put('/{id}',[UserController::class, 'updateById']);
    $router->delete('/{id}',[UserController::class, 'deleteUser']);
    
 });
