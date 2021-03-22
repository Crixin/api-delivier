<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidationService
{
    private $rules;
    private $data;

    public function __construct(array $rules, array $data)
    {
        $this->rules = $rules;
        $this->data = $data;
    }


    public function make()
    {
        $validator = Validator::make($this->data, $this->rules);

        if ($validator->fails()) {
            return $validator;
        }
        return false;
    }
}
