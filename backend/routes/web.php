<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Auth\LoginController;

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

$router->group(['prefix'=>'api'],function() use($router){
   $router->post('/login','Auth\\LoginController@login');
   $router->post('/register','Auth\\RegisterController@register');
   $router->post('/forgot-password','Auth\\RegisterController@forgot');
   $router->post('/reset-password','Auth\\RegisterController@reset_password');
   $router->get('/activateaccount/{token}','Auth\\RegisterController@activate');
   $router->group(['middleware' => 'auth:api'], function () use ($router) {
     $router->get('/me','Auth\\LoginController@userDetails');
     $router->post('/logout','Auth\\LoginController@logout');
     $router->get('/check-login','Auth\\LoginController@checkLogin');
     $router->get('/getProfile','client\\profileController@index');
     $router->post('/updateProfile','client\\profileController@update');
   });
});