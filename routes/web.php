<?php
//define('STDIN',fopen("php://stdin","r"));
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
$router->get('/', function () {
  return file_get_contents(base_path() . '/public/index.html');
});

$router->get('/api/list', 'AgendaController@index');
$router->post('/api/store', 'AgendaController@store');


$router->get('/oauth2callback', function ($code) use ($router) {
    return $code;
});
