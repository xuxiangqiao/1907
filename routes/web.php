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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::view('aa','index',['name'=>'wenansheng']);

//get路由
//Route::get('test', 'TestController@index');//123
//Route::get('test', 'Index\TestController@index');//456
//Route::get('login', 'Index\TestController@login');//login 页面
//post路由
//Route::post('dologin', 'Index\TestController@dologin')->name('do');//login 页面
//控制器接收id
//Route::get('goods/{id}/{name}', 'Index\TestController@goods');

//Route::get('goods/{id}/{name}', function($id,$goodsname){
//    echo $id."<br/>";
//    echo $goodsname;
//});

//可选参数
//Route::get('goods/{id}/{name?}', 'Index\TestController@goods');
//正则约束
//Route::get('goods/{id}/{name}', 'Index\TestController@goods');

Route::view('/login', 'login');
Route::post('/dologin', 'Admin\LoginController@dologin');//列表页
Route::post('/logindo', 'Admin\LoginController@logindo');//列表页
//商品品牌模块
Route::prefix('brand')->group(function () {
    Route::get('/', 'Admin\BrandController@index');//列表页
    Route::get('create', 'Admin\BrandController@create');//列表页
    Route::post('store', 'Admin\BrandController@store');//列表页
    Route::get('edit/{id}', 'Admin\BrandController@edit');//列表页
    Route::post('update/{id}', 'Admin\BrandController@update');//列表页
    Route::get('delete/{id}', 'Admin\BrandController@destroy');//列表页
    Route::post('checkonly', 'Admin\BrandController@checkonly');//列表页
});

//设置cookie
//Route::get('addcookie', function () {
//    $res =  response('欢迎来到 Laravel 学院')->cookie('aa', 'lvxin', 1);
//    dump($res);
//    $aa =  request()->cookie('aa');
//    dd($aa);
//});

Route::get('addcookie', function () {
     \Cookie::queue('name', 'aa', 1);
   // return response('欢迎来到 Laravel 学院')->cookie('aa', 'lvxin', 1);
});
//获取cookie
Route::get('getcookie', function () {
    //设置cookie
    //\Cookie::queue(\Cookie::make('uu', '123', 2));
    \Cookie::queue('yuyu', 'opop', 1);
    
   //获取的两种方式
    //echo request()->cookie('yuyu');
    echo \Cookie::get('name');
});

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');



Route::get('/','Index\IndexController@index');
//Route::get('/login','Index\IndexController@login');
Route::get('/pay/{orderid}','Index\OrderController@pay');
Route::get('/return_url','Index\OrderController@return_url');//同步通知
Route::get('/notify_url','Index\OrderController@notify_url');//异步跳转

