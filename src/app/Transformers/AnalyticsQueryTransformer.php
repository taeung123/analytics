<?php

namespace VCComponent\Laravel\Analytics\Transformers;

use League\Fractal\TransformerAbstract;

class AnalyticsQueryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            'type'      => $model->type,
            'date_type' => $model->date_type,
            "slug"      => $model->slug,
            "query"     => $model->query,
        ];
    }
}
