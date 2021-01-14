<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::domain('me.domain.com')->group(function () {
//     Route::get('/', function(){
//        return "Hello, Welcome to my Laravel Domain Routing. Thanks You";
//     });
//  }]);

Route::group(['middleware' => 'cors'], function() {
    Route::get('/', function () {
        // return view('welcome');
        return redirect('/home');
    });

    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]);

    // Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/{any}', 'HomeController@index')->where('any', '.*');

    // Route::get('/users', 'API\UserController@index')->name('users');
    // Route::get('/jabatan', 'API\PositionController@index')->name('users');
    // Route::get('/detail', 'API\UserController@show')->name('users');
});
