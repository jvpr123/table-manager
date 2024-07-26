<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\Gateway\MeetingDayGateway;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\Repository\LocalRepository;
use Modules\Admin\Repository\MeetingDayRepository;
use Modules\Admin\Repository\PeriodRepository;
use Modules\Admin\Repository\ResponsibleRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LocalGateway::class, LocalRepository::class);
        $this->app->bind(ResponsibleGateway::class, ResponsibleRepository::class);
        $this->app->bind(PeriodGateway::class, PeriodRepository::class);
        $this->app->bind(MeetingDayGateway::class, MeetingDayRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
