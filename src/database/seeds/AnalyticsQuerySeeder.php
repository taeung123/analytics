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
            ["type"=>"widget","slug" => "monthly_revenue","query" => "SELECT SUM(total) AS value from orders where month(created_at) = month(CURRENT_DATE())"],
            ["type"=>"widget","slug" => "daily_revenue","query" => "SELECT SUM(total) AS value from orders where day(created_at) = day(CURRENT_DATE())"],
            ["type"=>"widget","slug" => "monthly_visited","query" => "SELECT 100 AS value"],
            ["type"=>"widget","slug" => "total_visited","query" => "SELECT 100 AS value"],
            ["type"=>"chart","slug" => "revenue","query" => "SELECT sum(total) as value, date(order_date) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by date(order_date))"],
            ["type"=>"chart", "slug" => "order_count","query" => "SELECT count(id) as value, date(order_date) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by date(order_date))"],
            ["type"=>"chart", "slug" => "order_avg","query" => "SELECT avg(total) as value, date(order_date) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by date(order_date))"],
            ["type"=>"chart", "slug" => "top_product","query" => "SELECT MAX(sum_order.value) as value, sum_order.date as date, sum_order.id, sum_order.name  from (SELECT sum(order_items.quantity) as value, date(order_items.created_at) as date, products.id as id, products.name as name from order_items INNER JOIN products ON products.id = order_items.product_id  where (date(order_items.created_at) >= :from) and (date(order_items.created_at) <= :to) group by order_items.created_at, products.id) sum_order, order_items where (date(order_items.created_at) >= :from) and (date(order_items.created_at) <= :to) group by sum_order.date"],

        ]);
    }
}
