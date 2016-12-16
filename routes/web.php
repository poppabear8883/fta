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

Auth::routes();
Route::get('/', 'DashboardController@index');
Route::get('/dashboard', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);

Route::get('dt/{data}',['uses'=>'BidController@getData', 'as' => 'dt.data']);

Route::get('won',['uses'=>'WonController@index', 'as' => 'wdt']);
Route::get('won/{data}',['uses'=>'WonController@getData', 'as' => 'wdt.data']);

Route::get('profile', 'ProfileController@index');
Route::patch('profile/{id}', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);


Route::patch('bid/{id}/won', 'BidController@updateWon');

Route::post('bids/create', ['uses' => 'BidController@createPost', 'as' => 'bids.create.post']);
Route::resource('bids', 'BidController');


Route::get('/debug', function() {

});