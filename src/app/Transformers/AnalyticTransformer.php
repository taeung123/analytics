<?php

namespace VCComponent\Laravel\Analytic\Transformers;

use League\Fractal\TransformerAbstract;

class AnalyticTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            "url"        => $model->url,
            "pageTitle"  => $model->pageTitle,
            "pageViews"  => $model->pageViews,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ],
        ];
    }
}
