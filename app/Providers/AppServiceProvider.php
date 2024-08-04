<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Services\IPdfService;
use App\Http\Services\PdfService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPdfService::class, PdfService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
