<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Services\Batidas\BatidasService;

class BatidasServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'BatidasContract', 
            function() { return new BatidasService; }
        );
    }
}
