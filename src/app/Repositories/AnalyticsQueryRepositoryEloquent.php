<?php

namespace VCComponent\Laravel\Analytic\Repositories;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use VCComponent\Laravel\Analytics\Entities\AnalyticsQuery;
use VCComponent\Laravel\Analytic\Repositories\AnalyticsQueryRepository;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;
use Exception;
use Illuminate\Support\Str;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace VCComponent\Laravel\Post\Repositories;
 */
class AnalyticsQueryRepositoryEloquent extends BaseRepository implements AnalyticsQueryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnalyticsQuery::class;
    }

    public function getEntity()
    {
        return $this->model;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Find data by a slug
     *
     * @param string $type
     * @param int $id
     * @return self
     */
    public function findBySlug($type, $slug)
    {
        try {
            return $this->model->where('slug', $slug)->where('type', $type)->first();
        } catch (Exception $e) {
            throw new NotFoundException('data not found');
        }
    }


}
