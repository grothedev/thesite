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

Route::post('/upload-files','SiteController@uploadFiles');

Route::get('/', function () {
	return view('home');
});

/*
Route::get('f', function () {
	return view('dir');
});
*/

Route::get('/n', function(){
	return view('note');
});

Route::post('note', 'SiteController@appendThought');



Route::resource('podcasts', 'PodcastController');
