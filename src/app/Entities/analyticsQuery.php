<?php

namespace VCComponent\Laravel\Analytics\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AnalyticsQuery extends Model implements Transformable
{
    use TransformableTrait;
    protected $table = 'analytics_query';
    protected $fillable = [
        'type',
        'date_type',
        'slug',
        'query'
    ];
}
