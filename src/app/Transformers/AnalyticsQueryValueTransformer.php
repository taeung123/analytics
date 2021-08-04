<?php

namespace VCComponent\Laravel\Analytics\Transformers;

use League\Fractal\TransformerAbstract;

class AnalyticsQueryValueTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            "value"      => $model->value,
        ];
    }
}
