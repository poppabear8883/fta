<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Repositories\CalendarRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    private $cal;

    public function __construct(CalendarRepositoryInterface $cal) {
        $this->cal = $cal;
    }

    public function index() {
        return view('pages.calendar');
    }

    public function getEvents() {
        $uid = auth()->user()->id;
        $tz = auth()->user()->timezone;

        $events = Bid::where('user_id', $uid)
            ->where('won', 1)
            ->get();

        $eventsJson = [];
        // Regex Reference: https://regex101.com/r/2HjtEV/3
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
                    'title' => $event->location,
                    'url' => $event->url,
                    'start' => $start,
                    'description' => '<h4>'.$event->name.'</h4><p class="text-primary">'.$event->pickup.'</p><p>'.$event->location.'</p>'
                ];
            }
        }
        return response()->json($eventsJson);
    }
}
