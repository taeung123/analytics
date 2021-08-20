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
        else {
            throw new Exception("Admin middleware configuration is required");
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
        if (strtotime($request->from_date) > strtotime($request->to_date)) {
            throw new Exception("from_date phải nhỏ hơn to_date");
        }
        $diff = date_diff(date_create($request->from_date), date_create($request->to_date));
        switch ($request->date_type) {
            case 'day':
                if ($diff->days > 7)
                    throw new Exception("Khoảng ngày không được quá 7 ngày");
                break;
            case 'week':
                if (($diff->days / 7) > 8)
                    throw new Exception("Khoảng tuần không được quá 8 tuần");
                break;
            case 'month':
                if (($diff->m > 6) || ($diff->m == 6 && $diff->d > 0)) {
                    throw new Exception("Khoảng tháng không được quá 6 tháng");
                }
                break;
        }
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
