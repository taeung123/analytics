<?php

namespace VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin;

use Exception;
use Illuminate\Http\Request;
use VCComponent\Laravel\Analytics\Entities\AnalyticsQuery;
use VCComponent\Laravel\Analytic\Transformers\AnalyticsQueryTransformer;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;
use VCComponent\Laravel\Analytic\Repositories\AnalyticsQueryRepository;
use Illuminate\Support\Facades\DB;

class AnalyticsQueryController extends ApiController
{
    public function __construct(AnalyticsQueryRepository $repository)
    {
        $this->repository  = $repository;
        $this->entity      =  $repository->getEntity();
        $this->transformer = AnalyticsQueryTransformer::class;
    }

    public function analyticsQuery($slug)
    {
        $data = $this->repository->FindBySlug($slug);
        return DB::select($data->query);
    }
}
