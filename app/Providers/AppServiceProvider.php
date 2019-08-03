<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Phabricator\Phabricator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Phabricator::class, function () {
            return new Phabricator(
                config('services.phabricator.endpoint'),
                config('services.phabricator.token')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
