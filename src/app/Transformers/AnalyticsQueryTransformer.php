<?php

namespace VCComponent\Laravel\Analytic\Transformers;

use League\Fractal\TransformerAbstract;

class AnalyticQueryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            "slug"        => $model->slug,
            "query"      => $model->query,
        ];
    }
}
