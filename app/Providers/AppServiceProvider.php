<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\Gateway\MeetingGroupGateway;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\Repository\LocalRepository;
use Modules\Admin\Repository\MeetingGroupRepository;
use Modules\Admin\Repository\PeriodRepository;
use Modules\Admin\Repository\ResponsibleRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LocalGateway::class, LocalRepository::class);
        $this->app->bind(ResponsibleGateway::class, ResponsibleRepository::class);
        $this->app->bind(PeriodGateway::class, PeriodRepository::class);
        $this->app->bind(MeetingGroupGateway::class, MeetingGroupRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
