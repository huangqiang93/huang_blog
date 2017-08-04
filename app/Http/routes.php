<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','Home\IndexController@index');
Route::get('/category/{category_id}','Home\IndexController@category');
Route::get('article/{article_id}','Home\IndexController@article');
Route::get('tags/{tag}','Home\IndexController@tags');
Route::get('search','Home\IndexController@search');
Route::get('contact','Home\IndexController@contact');
Route::get('about','Home\IndexController@about');
Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/captcha','Admin\LoginController@captcha');

Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('/','IndexController@index');
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('logout','LoginController@logout');
    Route::any('changepass','IndexController@changepass');

    Route::post('category_order','CategoryController@changeorder');
    Route::resource('category','CategoryController');

    Route::resource('article','ArticleController');

    Route::resource('links','LinksController');
    Route::post('links_order','LinksController@changeorder');

    Route::resource('navs','NavsController');
    Route::post('navs_order','NavsController@changeorder');

    Route::resource('article','ArticleController');

    Route::resource('config','ConfigController');
    Route::get('conf_cache','ConfigController@conf_cache');
    Route::post('config_order','ConfigController@changeorder');
    Route::post('config_content','ConfigController@changecontent');

    Route::any('upload','UploadifyController@upload');



});
