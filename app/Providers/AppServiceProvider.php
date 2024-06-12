<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\Repository\LocalRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LocalGateway::class, LocalRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
