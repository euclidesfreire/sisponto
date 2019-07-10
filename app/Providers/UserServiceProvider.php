<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Services\UserService;

class UserServiceProvider extends ServiceProvider
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
        $this->app->bind('UserContract', 'App\Core\Services\UserService');
    }
}
