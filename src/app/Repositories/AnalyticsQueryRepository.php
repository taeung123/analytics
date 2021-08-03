<?php

namespace VCComponent\Laravel\Analytic\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
interface AnalyticsQueryRepository extends RepositoryInterface
{
    public function findBySlug($field);
    public function getEntity();

}
