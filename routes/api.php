<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('souye', 'XcxController@index')->name('index');
Route::get('science', 'XcxController@science')->name('science');
Route::get('knowledge', 'XcxController@knowledge')->name('knowledge');
Route::get('qa', 'XcxController@qa')->name('qa');
Route::get('ht', 'XcxController@ht')->name('ht');
Route::get('wddetails', 'XcxController@wddetails')->name('wddetails');
Route::get('zsdetails', 'XcxController@zsdetails')->name('zsdetails');
Route::get('htdetails', 'XcxController@htdetails')->name('htdetails');
Route::get('authors', 'XcxController@authors')->name('authors');
Route::get('searchs', 'XcxController@searchs')->name('searchs');
