<?php

namespace Aplag;

use Illuminate\Support\ServiceProvider;
use Aplag\Domain\PortsIn\CompServiceInterface;
use Aplag\Domain\PortsIn\ExcelServiceInterface;
use Aplag\Domain\PortsOut\CompTextCreatorInterface;
use Aplag\Domain\PortsOut\ExcelExporterInterface;
use Aplag\Domain\PortsOut\ReportCreatorInterface;
use Aplag\Domain\Services\CompService;
use Aplag\Domain\Services\Excelservice;
use Aplag\Infra\CompTextCreator\CompTextCreator;
use Aplag\Infra\ExcelExporter\ExcelExporter;
use Aplag\Infra\ReportCreator\ReportCreator;

class AplagServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CompServiceInterface::class, CompService::class);
        $this->app->bind(CompTextCreatorInterface::class, CompTextCreator::class);
        $this->app->bind(ReportCreatorInterface::class, ReportCreator::class);
        $this->app->bind(ExcelServiceInterface::class, \Aplag\Domain\Services\ExcelService::class);
        $this->app->bind(ExcelExporterInterface::class, ExcelExporter::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/App/Http/views', 'aplag');
    }
}
