<?php

namespace VCComponent\Laravel\Analytic\Validators;

use VCComponent\Laravel\Vicoders\Core\Validators\AbstractValidator;

class AnaliticsQueryValidator extends AbstractValidator
{
    protected $rules = [
        'RULE_ADMIN_REQUEST' => [
            'from_date' => ['required'],
            'to_date'   => ['required'],
            'date_type' => ['required'],
        ]
    ];
}
