<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Reliese\Coders\CodersServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Factory $factory): void
    {
        $factory->addExtension('yml', 'file');
    }
}
