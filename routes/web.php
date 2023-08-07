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


Route::get('/n/{t}', 'SiteController@writeThought');
Route::post('/n', 'SiteController@appendThought');

Route::get('tkv', function(){
	return view('testkv');
});

Route::get('v/{v}', 'SiteController@vidview');

Route::get('verum', 'WritingController@index');
Route::get('verum/create', 'WritingController@create');
Route::get('verum/{id}', 'WritingController@show');
Route::post('verum/store', 'WritingController@store');

Route::post('verum/comments/store', 'CommentController@store');

Route::get('mc-restart', 'SiteController@restartMCServer');
Route::get('mc-cancelrestart', 'SiteController@cancelRestartMCServer');
Route::get('4', function(){
	return view('4chan_search_query');
});
Route::post('4', 'SiteController@search4chan');

Route::get('cam', function(){
	return view('cam');
});
Route::get('snapshot', 'SiteController@captureCameraImage');

//TODO use controller to query API from PHP
Route::get('geomat', function(){
	return view('map');
});

Route::get('garden', function(){
	return view('thegarden.index');
});

Route::resource('podcasts', 'PodcastController');
Route::get('kv', 'KVController@index');
Route::get('kv/{k}', 'KVController@show');
Route::post('kv', 'KVController@store');
Route::get('kvt/{k}', 'KVController@getTimestamp');

Route::get('sheeshbb', function(){
	return view('imgdump');
});
Route::post('sheeshbb', 'SiteController@uploadImgDump');

Route::get('phpi', function(){
	print( sys_get_temp_dir());
	print( phpinfo());
});
Route::get('vidstream', 'SiteController@streamVideo');

Route::get('vt', function(){

});

Route::get('/u', function () {
    return view('u');
})->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
