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
            ["type"=>"chart","date_type"=>"day", "slug" => "revenue","query" => "SELECT sum(total) as value, date(order_date) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by date(order_date) order by date asc"],
            ["type"=>"chart","date_type"=>"week", "slug" => "revenue","query" => "SELECT sum(total) as value, CONCAT( DATE_FORMAT(DATE_ADD(order_date, INTERVAL (1-DAYOFWEEK(order_date)) DAY), '%m-%d'), ' -> ', DATE_FORMAT(DATE_ADD(order_date, INTERVAL (7-DAYOFWEEK(order_date)) DAY), '%m-%d')) as date from orders where (date(order_date) >= DATE_ADD(:from, INTERVAL (1-DAYOFWEEK(:from)) DAY)) and (date(order_date) <= DATE_ADD(:to, INTERVAL (7-DAYOFWEEK(:to)) DAY)) group by week(order_date) order by date(order_date) asc"],
            ["type"=>"chart","date_type"=>"month", "slug" => "revenue","query" => "SELECT sum(total) as value, convert(date(order_date), nchar(7)) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by month(order_date) order by date asc"],
            ["type"=>"chart","date_type"=>"day", "slug" => "order_count","query" => "SELECT count(id) as value, date(order_date) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by date(order_date) order by order_date asc"],
            ["type"=>"chart","date_type"=>"week", "slug" => "order_count","query" => "SELECT count(id) as value, CONCAT( DATE_FORMAT(DATE_ADD(order_date, INTERVAL (1-DAYOFWEEK(order_date)) DAY), '%m-%d'), ' -> ', DATE_FORMAT(DATE_ADD(order_date, INTERVAL (7-DAYOFWEEK(order_date)) DAY), '%m-%d')) as date from orders where (date(order_date) >= DATE_ADD(:from, INTERVAL (1-DAYOFWEEK(:from)) DAY)) and (date(order_date) <= DATE_ADD(:to, INTERVAL (7-DAYOFWEEK(:to)) DAY)) group by week(order_date) order by order_date asc"],
            ["type"=>"chart","date_type"=>"month", "slug" => "order_count","query" => "SELECT count(id) as value, convert(date(order_date), nchar(7)) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by month(order_date) order by order_date asc"],
            ["type"=>"chart","date_type"=>"day", "slug" => "order_avg","query" => "SELECT avg(total) as value, date(order_date) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by date(order_date) order by date(order_date)"],
            ["type"=>"chart","date_type"=>"week", "slug" => "order_avg","query" => "SELECT avg(total) as value, CONCAT( DATE_FORMAT(DATE_ADD(order_date, INTERVAL (1-DAYOFWEEK(order_date)) DAY), '%m-%d'), ' -> ', DATE_FORMAT(DATE_ADD(order_date, INTERVAL (7-DAYOFWEEK(order_date)) DAY), '%m-%d')) as date from orders where (date(order_date) >= DATE_ADD(:from, INTERVAL (1-DAYOFWEEK(:from)) DAY)) and (date(order_date) <= DATE_ADD(:to, INTERVAL (7-DAYOFWEEK(:to)) DAY)) group by week(order_date) order by date(order_date)"],
            ["type"=>"chart","date_type"=>"month", "slug" => "order_avg","query" => "SELECT avg(total) as value, convert(date(order_date), nchar(7)) as date from orders where (date(order_date) >= :from) and (date(order_date) <= :to) group by month(order_date) order by date(order_date)"],
            ["type"=>"chart","date_type"=>"day", "slug" => "best_selling_product","query" => "SELECT sum(order_items.quantity) as value, date(order_items.created_at) as date, products.id as id_product, products.name as name_product, products.thumbnail as thumbnail_product, products.description as desc_product from order_items INNER JOIN products ON products.id = order_items.product_id  where (date(order_items.created_at) >= :from) and (date(order_items.created_at) <= :to) group by order_items.created_at, products.id order by value DESC limit 5"],
            ["type"=>"chart","date_type"=>"week", "slug" => "best_selling_product","query" => "SELECT sum(order_items.quantity) as value, CONCAT( DATE_FORMAT(DATE_ADD(order_items.created_at, INTERVAL (1-DAYOFWEEK(order_items.created_at)) DAY), '%m-%d'), ' -> ', DATE_FORMAT(DATE_ADD(order_items.created_at, INTERVAL (7-DAYOFWEEK(order_items.created_at)) DAY), '%m-%d')) as date, products.id as id_product, products.name as name_product, products.thumbnail as thumbnail_product, products.description as desc_product from order_items INNER JOIN products ON products.id = order_items.product_id where (date(order_items.created_at) >= DATE_ADD(:from, INTERVAL (1-DAYOFWEEK(:from)) DAY)) and (date(order_items.created_at) <= DATE_ADD(:to, INTERVAL (7-DAYOFWEEK(:to)) DAY)) group by week(order_items.created_at), products.id order by value DESC limit 5"],
            ["type"=>"chart","date_type"=>"month", "slug" => "best_selling_product","query" => "SELECT sum(order_items.quantity) as value, convert(date(order_items.created_at), nchar(7)) as date, products.id as id_product, products.name as name_product, products.thumbnail as thumbnail_product, products.description as desc_product from order_items INNER JOIN products ON products.id = order_items.product_id  where (date(order_items.created_at) >= :from) and (date(order_items.created_at) <= :to) group by month(order_items.created_at), products.id order by value DESC limit 5"],


        ]);
    }
}
