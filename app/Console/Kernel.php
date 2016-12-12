<?php

namespace App\Console;

use App\Bid;
use App\Notifications\AuctionEndingSoon;
use App\Notified;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * Every user has multiple bids that could end with in the hour.
     * The user should only receive 1 generic notification that auctions are ending soon.
     * The user should not be notified again for at least 1 hour from the last notification.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            //Log::info('Schedule Ran');
            $notifieds = Notified::all();

            $notifieds->each(function($item) {
                $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at);
                $diff = Carbon::now()->diffInHours($datetime);

                if($diff >= 1) {
                    Notified::find($item->id)->delete();
                }
            });

            $unsent = Bid::where('sent', 0)
                ->where('datetime', '>', Carbon::now()->format('Y-m-d H:i:s'))
                ->where('won', 0)
                ->get();

            $unsent->each(function ($item) {
                $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $item->datetime);
                $diff = Carbon::now()->diffInHours($datetime);
                //Log::info('Diff: ' . $diff);

                $user = User::find($item->user_id);

                if($user !== null) {
                    $notified = Notified::where('user_id', $user->id)->first();

                    if ($diff == 0) {
                        if ($notified == null) {
                            //Log::info('Item: ' . $item->name);
                            $user->notify(new AuctionEndingSoon($item));
                            $item->sent = 1;
                            $item->save();

                            Notified::create([
                                'user_id' => $user->id
                            ]);

                            //Log::info('email sent');
                        }
                    }
                }
            });
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
