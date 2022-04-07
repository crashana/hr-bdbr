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
        $caching = config('env.CACHING', false);
        $getFrom = $caching ? 'cache' : 'direct';
        $binds = config('binding');
        foreach ($binds as $interfaces) {
            $this->app->bind($interfaces['interface'], $interfaces[$getFrom]);
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
