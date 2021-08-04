<?php

namespace VCComponent\Laravel\Analytic\Providers;

use Illuminate\Support\ServiceProvider;
use VCComponent\Laravel\Analytic\Repositories\AnalyticsQueryRepository;
use VCComponent\Laravel\Analytic\Repositories\AnalyticsQueryRepositoryEloquent;
use VCComponent\Laravel\Analytic\Entities\AnalyticsQuery;

class AnalyticServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->publishes([
            __DIR__ . '/../../config/analytic.php' => config_path('analytic.php'),
            __DIR__ . '/../../database/seeds/AnalyticsQuerySeeder.php'  => base_path('/database/seeds/AnalyticsQuerySeeder.php'),
        ]);
    }

    /**
     * Register any package services
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('analytics_query', AnalyticsQuery::class);
        $this->app->bind(AnalyticsQueryRepository::class, AnalyticsQueryRepositoryEloquent::class);
    }
}
