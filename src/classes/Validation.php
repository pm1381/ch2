<?php
namespace App\Classes;

use App\Helpers\Tools;
use App\Helpers\Arrays;
use Rakit\Validation\Validator;

class Validation {
    
    private array $data;
    private Validator $validator;
    private $validData;
    
    public function __construct($data,Validator $validator)
    {
        $this->data = $data;
        $this->validator = $validator;
    }

    public function makeValidation($check)
    {
        $v = $this->validator->make($this->data, $check);
        $v->validate();

        $this->validData = $v;
    }

    public function handleValidationError()
    {
        $validationResult['error'] = false;
        $validationResult['grabResult'] = [];
        if ($this->validData->fails()) {
            // $errors = Tools::translateErrors($this->validData->errors(), Arrays::fieldNameTranslations());
            $errors = $this->validData->errors();
            $validationResult = [
                'error' => true,
                'grabResult' => $errors->all(),
                'count' => $errors->count(),
                'to array' => $errors->toArray(),
                'firstError' => $errors->firstOfAll()
            ];
        }
        return $validationResult;
    }
}