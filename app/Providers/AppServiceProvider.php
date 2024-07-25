<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\Repository\LocalRepository;
use Modules\Admin\Repository\ResponsibleRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LocalGateway::class, LocalRepository::class);
        $this->app->bind(ResponsibleGateway::class, ResponsibleRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
