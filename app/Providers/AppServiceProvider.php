<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\UrlEncryption;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register URL encryption helper
       
        $this->app->singleton('url-encryption', function () {
            return new UrlEncryption();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
