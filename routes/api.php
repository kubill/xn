<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.user.')->prefix('user')->group(function () {
    Route::post('register', 'UserController@register')->name('register');
    Route::post('login', 'UserController@login')->name('login');
    Route::post('verifyCode', 'UserController@verifyCode')->name('verifyCode');
    Route::get('staff', 'UserController@getUsers')->name('staff');
});

Route::name('api.user.')->prefix('user')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/orders', 'UserController@orders')->name('orders');
    Route::get('/rent', 'UserController@rent')->name('rent');
    Route::post('/uploadLayout', 'UserController@uploadLayout')->name('uploadLayout');
});

Route::resource('categories', 'CategoryController')->only(['index', 'show'])->names('api.categories');
Route::resource('regions', 'RegionController')->only(['index', 'show'])->names('api.regions');
Route::resource('layouts', 'LayoutController')->only(['index', 'show'])->names('api.layouts');
Route::resource('houses', 'HouseController')->only(['index', 'show'])->names('api.houses');

Route::name('api.index.')->prefix('index')->group(function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/houses', 'IndexController@houses')->name('houses');
});

Route::name('api.common.')->prefix('common')->group(function () {
    Route::post('/upload', 'CommonController@upload')->name('upload');
});

Route::resource('house_ins', 'HouseInController')->only(['store',])->names('api.house_ins');
Route::resource('house_outs', 'HouseOutController')->only(['store',])->names('api.house_ins');
Route::resource('visits', 'VisitController')->only(['store',])->names('api.visits');
Route::resource('job_logs', 'JobLogController')->only(['store',])->names('api.job_logs');
Route::resource('advises', 'AdviseController')->only(['index', 'store',])->names('api.advises');
Route::resource('renews', 'RenewController')->only(['store',])->names('api.renews');
Route::resource('reget_cards', 'RegetCardController')->only(['store',])->names('api.reget_cards');
Route::resource('posts', 'PostController')->only(['store',])->names('api.posts');
Route::resource('repairs', 'RepairController')->only(['store',])->names('api.repairs');
Route::resource('public_areas', 'PublicAreaController')->only(['store',])->names('api.public_areas');
Route::resource('borrows', 'BorrowController')->only(['store',])->names('api.borrows');
Route::resource('supports', 'SupportController')->only(['store',])->names('api.supports');
Route::resource('house_out_cleans', 'HouseOutCleanController')->only(['store',])->names('api.house_out_cleans');
Route::resource('public_area_cleans', 'PublicAreaCleanController')->only(['store',])->names('api.public_area_cleans');
Route::resource('articles', 'ArticleController')->only(['store',])->names('api.articles');
Route::resource('tasks', 'TaskController')->only(['store',])->names('api.tasks');
