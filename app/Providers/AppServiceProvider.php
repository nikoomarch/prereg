<?php

namespace studentPreRegisteration\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('recaptcha', 'studentPreRegisteration\\Validators\\ReCaptcha@validate');
        if(!env('APP_DEBUG'))
        $this->app['request']->server->set('HTTPS', true);
    }
}
