<?php

namespace VCComponent\Laravel\Analytics\Entities;

class AnalyticQueryValue
{
    public $value;
    public $date;
    public function __construct($value, $date)
    {
        $this->value = $value;
        $this->date = $date;
    }
}
