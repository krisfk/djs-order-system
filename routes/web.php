<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => ['web']], function () {



Route::get('/info', function () {
    return phpinfo();
});   







Route::group(['prefix' => 'api'], function () {
    // Route::get('/getSmsCode', [App\Http\Controllers\UserController::class, 'getSmsCode']);
    // Route::post('/getSmsCode', [App\Http\Controllers\UserController::class, 'getSmsCode']);

    // Route::get('/checkSmsCode', [App\Http\Controllers\UserController::class, 'checkSmsCode']);
    // Route::post('/checkSmsCode', [App\Http\Controllers\UserController::class, 'checkSmsCode']);
    
    Route::post('/adminLogin', [App\Http\Controllers\AdminUserController::class, 'adminLogin']);
    Route::post('/adminLogout', [App\Http\Controllers\AdminUserController::class, 'adminLogout']);

    Route::post('/adminUser', [App\Http\Controllers\AdminUserController::class, 'getAdminUser']);


    Route::post('/allOrders', [App\Http\Controllers\OrderController::class, 'allOrders']);
    Route::post('/editOrder', [App\Http\Controllers\OrderController::class, 'editOrder']);
    Route::post('/createOrder', [App\Http\Controllers\OrderController::class, 'createOrder']);
    Route::post('/deleteOrder', [App\Http\Controllers\OrderController::class, 'deleteOrder']);


    // allOrders
});


 
// Route::get('/dashboard/{any}', 'App\Http\Controllers\AppController@index')->where('any', '.*');
// Route::get('/test', 'App\Http\Controllers\TestController@index');
// Route::get('/test', [App\Http\Controllers\TestController::class, 'index']);//->name();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['prefix'=>'{language}'],function(){
//     Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });


// Route::get('/login', [App\Http\Controllers\loginController::class, 'index'])->name('home');

// Route::get('/login-admin', [App\Http\Controllers\AdminController::class, 'index']);//->name();
// Route::get('/login', [App\Http\Controllers\AdminController::class, 'login']);//->name();
Auth::routes();

Route::get('/{any}', [App\Http\Controllers\AppController::class, 'cms'])->where('any', '.*');

// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index']);


});