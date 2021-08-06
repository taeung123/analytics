<?php

namespace VCComponent\Laravel\Analytics\Entities;

class AnalyticQueryProductValue
{
    public $value;
    public $date;
    public $id_product;
    public $name_product;
    public function __construct($value, $date, $id_product, $name_product)
    {
        $this->value = $value;
        $this->date = $date;
        $this->id_product = $id_product;
        $this->name_product = $name_product;
    }
}
