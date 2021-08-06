<?php

namespace VCComponent\Laravel\Analytics\Transformers;

use League\Fractal\TransformerAbstract;

class AnalyticsQueryProductValueTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            "value" => $model->value,
            "date" =>  $model->date,
            "id_product" => $model->id_product,
            "name_product" => $model->name_product,
        ];
    }
}
