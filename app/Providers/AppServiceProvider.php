<?php

namespace studentPreRegisteration\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\UrlGenerator;

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
    public function boot(UrlGenerator $url)
    {
        Validator::extend('recaptcha', 'studentPreRegisteration\\Validators\\ReCaptcha@validate');
        if(\App::environment() === 'production')
        $url->forceScheme('https');
    }
}
