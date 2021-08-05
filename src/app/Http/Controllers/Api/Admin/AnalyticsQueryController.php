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
use Carbon\Carbon;
class AnalyticsQueryController extends ApiController
{
    public function __construct(AnalyticsQueryRepository $repository, Request $request)
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
        $data = $this->repository->FindBySlug('widget', $slug);
        $query = DB::select($data->query);
        $value = new AnalyticQueryValue($query[0]->value, '');
        $response = $this->response->item($value, new AnalyticsQueryValueTransformer());
        return $response;
    }
    public function chartAnalyticsQuery(Request $request, $slug)
    {
        $data = $this->repository->FindBySlug('chart', $slug);
        if ($request->has('from_date')) {
            if ($request->has('to_date')) {
                $trans = [":from" =>"'" .$request->from_date."'", ':to' => "'".$request->to_date."'"];
            } else {
                $trans = [':from' => "'" .$request->from_date."'", ':to' => "'" . date('Y-m-d') ."'"];
            }
            $tring_query = strtr($data->query, $trans);
            $query = DB::select($tring_query);
            $value = collect($query)->map(function ($item) {
                return new AnalyticQueryValue($item->value, $item->date);
            });
            $response = $this->response->collection($value, new AnalyticsQueryValueTransformer());
            return $response;
        }
    }
}
