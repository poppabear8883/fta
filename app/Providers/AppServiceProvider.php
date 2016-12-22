<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            //Log::info($query->bindings);
            // $query->bindings
            // $query->time
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\BidRepositoryInterface',
            'App\Repositories\BidRepository'
        );

        $this->app->bind(
            'App\Repositories\UserBidsRepositoryInterface',
            'App\Repositories\UserBidsRepository'
        );

        $this->app->bind(
            'App\Repositories\CalendarRepositoryInterface',
            'App\Repositories\CalendarRepository'
        );

        $this->app->bind(
            'App\Repositories\BidFtaHtmlRepositoryInterface',
            'App\Repositories\BidFtaHtmlRepository'
        );

        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );
    }
}
