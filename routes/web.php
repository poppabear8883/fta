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
use Carbon\Carbon;

Auth::routes();
Route::get('/', 'DashboardController@index');
Route::get('/dashboard', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);

Route::get('dt/{data}',['uses'=>'BidController@getData', 'as' => 'dt.data']);

Route::get('calendar', ['uses' => 'CalendarController@index', 'as' => 'calendar']);
Route::get('calendar/events', 'CalendarController@getEvents');

Route::get('won',['uses'=>'WonController@index', 'as' => 'wdt']);
Route::get('won/{data}',['uses'=>'WonController@getData', 'as' => 'wdt.data']);

Route::get('profile', 'ProfileController@index');
Route::patch('profile/{id}', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);


Route::patch('bid/{id}/won', 'BidController@updateWon');

Route::post('bids/create', ['uses' => 'BidController@createFromHtml', 'as' => 'bids.create.html']);
Route::resource('bids', 'BidController');


Route::get('/debug', function() {
    $uid = auth()->user()->id;
    $tz = auth()->user()->timezone;

    $events = Bid::where('user_id', $uid)
        ->where('won', 1)
        ->get();

    $eventsJson = [];
    foreach ($events as $event) {
        $month_pattern = '/(?:jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)[a-z]{1,}/i';
        $year_pattern = '/2\d{3}?/';
        $days_pattern = '/(?:\d{1,2})(?:st|nd|rd|th)/i';
        $time_pattern = '/(?:\d{1,2})(?:\s|)(?:am|pm)(?:-|\s|\s[a-zA-Z]{1,}\s)(?:\d{1,2})(?:\s|)(?:am|pm)/i';

        preg_match($month_pattern, $event->pickup, $month);
        preg_match($year_pattern, $event->pickup, $year);
        preg_match_all($days_pattern, $event->pickup, $days);
        $days = array_collapse($days);
        preg_match($time_pattern, $event->pickup, $time);

        foreach($days as $day) {
            $start = Carbon::parse("$month[0] $day, $year[0]")->addDay(1)->setTimezone($tz)->format('Y-m-d');

            $eventsJson[] = [
                'id' => $event->id,
                'title' => $event->name . ' ('.$time[0].')',
                'url' => $event->url,
                'start' => $start
            ];
        }
    }

    dd($eventsJson);

    return response()->json($eventsJson);
});

Route::post('quick/email', 'DashboardController@postQuickEmail');