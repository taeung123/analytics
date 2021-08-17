<?php

namespace VCComponent\Laravel\Analytic\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
interface AnalyticsQueryRepository extends RepositoryInterface
{
    public function findBySlug($type, $date_type, $slug);
    public function getEntity();

}
