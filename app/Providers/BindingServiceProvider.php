<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $caching = env('CACHING', false);
        if ($caching) {
            $getFrom = 'cache';
        } else {
            $getFrom = 'direct';
        }
        $binds = config('binding');
        foreach ($binds as $intefaces) {
            $this->app->bind($intefaces['interface'], $intefaces[$getFrom]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
