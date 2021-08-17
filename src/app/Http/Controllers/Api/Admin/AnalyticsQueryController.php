<?php

namespace VCComponent\Laravel\Analytic\Http\Controllers\Api\Admin;

use Exception;
use Illuminate\Http\Request;
use VCComponent\Laravel\Analytics\Entities\AnalyticsQuery;
use VCComponent\Laravel\Analytics\Entities\AnalyticQueryValue;
use VCComponent\Laravel\Analytics\Entities\AnalyticQueryProductValue;
use VCComponent\Laravel\Analytics\Transformers\AnalyticsQueryTransformer;
use VCComponent\Laravel\Analytics\Transformers\AnalyticsQueryValueTransformer;
use VCComponent\Laravel\Analytics\Transformers\AnalyticsQueryProductValueTransformer;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;
use VCComponent\Laravel\Analytic\Repositories\AnalyticsQueryRepository;
use Illuminate\Support\Facades\DB;
use VCComponent\Laravel\Analytic\Validators\AnaliticsQueryValidator;

class AnalyticsQueryController extends ApiController
{
    public function __construct(AnalyticsQueryRepository $repository, AnaliticsQueryValidator $validator)
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
        $this->validator   = $validator;
    }

    public function analyticsQuery($slug)
    {
        $data = $this->repository->findBySlug('widget','', $slug);
        $query = DB::select($data->query);
        $value = new AnalyticQueryValue($query[0]->value, '');
        $response = $this->response->item($value, new AnalyticsQueryValueTransformer());
        return $response;
    }
    public function chartAnalyticsQuery(Request $request, $slug)
    {
        $this->validator->isValid($request, 'RULE_ADMIN_REQUEST');
        $data = $this->repository->findBySlug('chart', $request->date_type, $slug);
        $trans = [":from" => "'" . $request->from_date . "'", ':to' => "'" . $request->to_date . "'"];
        $tring_query = strtr($data->query, $trans);
        $query = DB::select($tring_query);
        if ($slug == "best_selling_product") {

            $value = collect($query)->map(function ($item) {
                return new AnalyticQueryProductValue($item->value, $item->date, $item->id_product, $item->name_product, $item->thumbnail_product, $item->desc_product);
            });
            $response = $this->response->collection($value, new AnalyticsQueryProductValueTransformer());
        } else {
            $value = collect($query)->map(function ($item) {
                return new AnalyticQueryValue($item->value, $item->date);
            });
            $response = $this->response->collection($value, new AnalyticsQueryValueTransformer());
        }

        return $response;
    }
}
