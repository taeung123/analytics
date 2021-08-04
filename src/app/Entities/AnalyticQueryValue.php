<?php

namespace VCComponent\Laravel\Analytics\Entities;

class AnalyticQueryValue
{
    public $value;
    public function __construct($value)
    {
        $this->value = $value;
    }
}
