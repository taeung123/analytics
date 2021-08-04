<?php

namespace VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin;

use Exception;
use Illuminate\Http\Request;
use VCComponent\Laravel\Analytics\Entities\AnalyticsQuery;
use VCComponent\Laravel\Analytics\Entities\AnalyticQueryValue;
use VCComponent\Laravel\Analytics\Transformers\AnalyticsQueryTransformer;
use VCComponent\Laravel\Analytics\Transformers\AnalyticsQueryValueTransformer;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;
use VCComponent\Laravel\Analytic\Repositories\AnalyticsQueryRepository;
use Illuminate\Support\Facades\DB;

class AnalyticsQueryController extends ApiController
{
    public function __construct(AnalyticsQueryRepository $repository)
    {
        $this->repository  = $repository;
        $this->entity      =  $repository->getEntity();
        if (config('analytics_query.auth_middleware.admin.middleware') !== '') {
            $this->middleware(
                config('analytics_query.auth_middleware.admin.middleware'),
                ['except' => config('analytics_query.auth_middleware.admin.except')]
            );
        }
        $this->transformer = AnalyticsQueryTransformer::class;
    }

    public function analyticsQuery($slug)
    {
        $data = $this->repository->FindBySlug($slug);

        $l_query = DB::select($data->query);
        $value = new AnalyticQueryValue($l_query[0]->value);
        $response = $this->response->item($value, new AnalyticsQueryValueTransformer());
        return $response;
    }
}
