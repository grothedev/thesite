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

Route::post('/upload-files','SiteController@uploadFiles');

Route::get('/', function () {
	return view('home');
});


Route::get('/n', function(){
	return view('note');
});

Route::post('note', 'SiteController@appendThought');

Route::get('tkv', function(){
	return view('testkv');
});

Route::get('verum', 'WritingController@index');
Route::get('verum/create', 'WritingController@create');
Route::get('verum/{id}', 'WritingController@show');
Route::post('verum/store', 'WritingController@store');

Route::post('verum/comments/store', 'CommentController@store');



Route::get('4', function(){
	return view('4chan_search');
});

//TODO use controller to query API from PHP
Route::get('geomat', function(){
	return view('map');
});

//music mirror
Route::get('mu', 'SiteController@music');

Route::resource('podcasts', 'PodcastController');
Route::get('kv', 'KVController@index');
Route::get('kv/{k}', 'KVController@show');
Route::post('kv', 'KVController@store');

//Auth::routes();
Route::get('logout', function(){
	Auth::logout();
	return 'you logged out';
});
