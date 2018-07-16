<?php


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

//kpi目标
Route::group(['prefix' => '/statistic/kpi-target'], function() {
    Route::get('/index','\App\Statistic\Controllers\KpiTargetController@index');
    Route::post('/edit','\App\Statistic\Controllers\KpiTargetController@edit');
    Route::post('/import','\App\Statistic\Controllers\KpiTargetController@import');
    Route::get('/export','\App\Statistic\Controllers\KpiTargetController@export');

});

Route::group(['prefix' => '/statistic/api'], function() {
    Route::post('/get-organize','\App\Statistic\Controllers\ApiController@getOrganize');
});
//订单
Route::group(['prefix' => '/statistic/order'], function() {
    Route::get('/index','\App\Statistic\Controllers\OrderController@index');
    Route::post('/edit-organize','\App\Statistic\Controllers\OrderController@editOrganize');
    Route::get('/export','\App\Statistic\Controllers\OrderController@export');

});
//用户合作社
Route::group(['prefix' => '/statistic/user-cooperative'], function() {

    Route::any('/index','\App\Statistic\Controllers\UserCooperativeController@index');
    Route::any('/reset','\App\Statistic\Controllers\UserCooperativeController@reset');
    Route::get('/export','\App\Statistic\Controllers\UserCooperativeController@export');

});

Route::group(['prefix' => '/statistic/ribao'], function() {

    Route::get('/index','\App\Statistic\Controllers\RibaoController@index');
    Route::any('/reset','\App\Statistic\Controllers\RibaoController@reset');
    Route::get('/export','\App\Statistic\Controllers\RibaoController@export');
});

Route::post('/statistic/api/get-stat-daily','\App\Statistic\Controllers\ApiController@getStatDaily');

Route::group(['prefix' => '/statistic/area-user'], function() {

    Route::get('/index','\App\Statistic\Controllers\AreaUserController@index');
    Route::any('/reset','\App\Statistic\Controllers\AreaUserController@reset');
    Route::get('/export','\App\Statistic\Controllers\AreaUserController@export');

});
Route::group(['prefix' => '/statistic/user-add'], function() {
    Route::get('/index','\App\Statistic\Controllers\UserAddController@index');
    Route::post('/search','\App\Statistic\Controllers\UserAddController@searchUserChart');
    Route::any('/reset','\App\Statistic\Controllers\UserAddController@reset');
    Route::get('/export','\App\Statistic\Controllers\UserAddController@export');

});

Route::group(['prefix' => '/statistic/cooperative'], function() {
    Route::get('/index','\App\Statistic\Controllers\CooperativeController@index');
    Route::get('/reset','\App\Statistic\Controllers\CooperativeController@reset');
    Route::get('/export','\App\Statistic\Controllers\CooperativeController@export');

});

Route::group(['prefix' => '/statistic/kpi-complete'], function() {

    Route::get('/index','\App\Statistic\Controllers\KpiCompleteController@index');
    Route::get('/export','\App\Statistic\Controllers\KpiCompleteController@export');

});
Route::group(['prefix' => '/statistic/kpi-contribution'], function() {
    Route::get('/index','\App\Statistic\Controllers\KpiContributionController@index');

    Route::get('/export','\App\Statistic\Controllers\KpiContributionController@export');
});
