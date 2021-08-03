<?php
use Illuminate\Database\Seeder;
use VCComponent\Laravel\Analytics\Entities\AnalyticsQuery;
class AnalyticsQuerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnalyticsQuery::insert([
            ["slug" => "monthly_revenue","query" => "SELECT SUM(total) AS value from orders where month(created_at) = month(CURRENT_DATE())"],
            ["slug" => "daily_revenue","query" => "SELECT SUM(total) AS value from orders where day(created_at) = day(CURRENT_DATE())"],
            ["slug" => "monthly_visited","query" => "SELECT 100 AS value"],
            ["slug" => "total_visited","query" => "SELECT 100 AS value"],
        ]);
    }
}
