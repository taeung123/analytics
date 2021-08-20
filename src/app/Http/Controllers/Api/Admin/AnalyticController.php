<?php

namespace VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin;

use Exception;
use Illuminate\Http\Request;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;
use VCComponent\Laravel\Analytic\Transformers\AnalyticTransformer;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;

class AnalyticController extends ApiController
{
    public function __construct(Analytics $analytics)
    {
        $this->analytics   = $analytics;
        $this->transformer = AnalyticTransformer::class;
        if (config('analytics_query.auth_middleware.admin.middleware') !== '') {
            $this->middleware(
                config('analytics_query.auth_middleware.admin.middleware'),
                ['except' => config('analytics_query.auth_middleware.admin.except')]
            );
        }
        else {
            throw new Exception("Admin middleware configuration is required");
        }
    }

    public function extraTime($request)
    {
        if ($request->has('year')) {
            return Period::years($request->year);
        } else if ($request->has('month')) {
            return Period::months($request->month);
        } else if ($request->has('day')) {
            return Period::days($request->day);
        } else {
            return Period::days(7);
        }
    }

    public function mostVisitedPages(Request $request)
    {
        $period = $this->extraTime($request);

        $analyticsData = $this->analytics->fetchMostVisitedPages($period);

        if (count($analyticsData) === 0) {
            throw new Exception("Empty data");
        }

        return $analyticsData;
    }

    public function visitorsAndPageview(Request $request)
    {

        $period = $this->extraTime($request);

        $analyticsData = $this->analytics->fetchVisitorsAndPageViews($period);

        if (count($analyticsData) === 0) {
            throw new Exception("Empty data");
        }

        return $analyticsData;
    }

    public function topBrowser(Request $request)
    {
        $period = $this->extraTime($request);

        $analyticsData = $this->analytics->fetchTopBrowsers($period);

        if (count($analyticsData) === 0) {
            throw new Exception("Empty data");
        }

        return $analyticsData;
    }

    public function performQuery(Request $request)
    {
        $period = $this->extraTime($request);

        $analyticsData = $this->analytics->performQuery(
            $period,
            'ga:sessions',
            [
                'metrics'    => 'ga:sessions, ga:pageviews',
                'dimensions' => 'ga:yearMonth',
            ]
        );

        if (count($analyticsData) === 0) {
            throw new Exception("Empty data");
        }

        return response()->json($analyticsData);
    }
}
