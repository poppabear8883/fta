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

use App\Bid;
use App\Notifications\UserRegistered;
use App\Notified;
use App\User;
use Carbon\Carbon;
use Yangqi\Htmldom\Htmldom;

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('home',['uses'=>'HomeController@index', 'as' => 'dt']);
Route::get('home/{data}',['uses'=>'HomeController@getData', 'as' => 'dt.data']);

Route::get('won',['uses'=>'WonController@index', 'as' => 'wdt']);
Route::get('won/{data}',['uses'=>'WonController@getData', 'as' => 'wdt.data']);

Route::get('profile', 'ProfileController@index');
Route::patch('profile/{id}', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);


Route::patch('bid/{id}/won', 'BidController@updateWon');

Route::resource('bids', 'BidController');


Route::get('/debug', function() {
    /*$html = new Htmldom('');
    $form = $html->find('form[name=bidform]')[0];

    dd($form
        ->children(1)
        ->children(1)
        ->children(3)
        ->innertext);*/
    //dd();
});