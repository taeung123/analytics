<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'admin'], function ($api) {
        $api->get('analytics/most-visited-pages', 'VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin\AnalyticController@mostVisitedPages');
        $api->get('analytics/visitors-and-pageview', 'VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin\AnalyticController@visitorsAndPageview');
        $api->get('analytics/top-browser', 'VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin\AnalyticController@topBrowser');
        $api->get('analytics/query', 'VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin\AnalyticController@performQuery');
        $api->get('analytics/widget/{slug}', 'VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin\AnalyticsQueryController@analyticsQuery');
        $api->get('analytics/chart/{slug}', 'VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin\AnalyticsQueryController@chartAnalyticsQuery');
    });
});
