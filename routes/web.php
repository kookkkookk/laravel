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

Route::get('/', function () {
    return view('welcome');
});
// Route::post('/', 'ProductController@create');
Route::resource('products', 'ProductController');
// Route::group(['middleware' => 'check.dirty'], function() {
//     Route::resource('products', 'ProductController');
// });
// 客製化路由，一般 post 會走@store, 但這裡 method 指定 post 進來的話會走 @signup 這個 function
Route::post('signup', 'AuthController@signup');
Route::post('login', 'AuthController@login');
// 使用受保護的 API 就需要用 middleware 中間層去經過 'auth:api' 通過後才進 @user function
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('user', 'AuthController@user');
    Route::get('logout', 'AuthController@logout'); // 登出也是一定要受登入狀態保護，所以也在這裡面
    Route::post('carts/checkout', 'CarController@checkout');
    Route::resource('carts', 'CarController');
    Route::resource('cart-items', 'CarItemController');
});

// group 可以將同一路徑功能結合在同一群組裡
/*
Route::group([
    'middleware' => ['checkValidIp'], // 中間層，打api時會先經過這個中間層
    'prefix' => 'web', // 將 api的路徑加上前綴字 ex:結合下面的Route就會變 web/index and web/print
    'namespace' => 'Web' // 檢視 HomeController 的位置命名 所以搭配以下，我會在以下有該資料夾 app/Http/Web
], function() {
    Route::get('/index', 'HomeController@index');
    Route::post('/print', 'HomeController@print');
});
*/

// cmd: php artisan route:list  可以看目前擁有什麼api path