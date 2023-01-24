<?php

namespace App\Controllers\Refrence;

use App\Helpers\Arrays;
use App\Classes\Validation;
use Rakit\Validation\Validator;

class SiteRefrenceController extends GeneralRefrenceController {
    
    protected $redirectTo = BASE_URI;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function AuthValidation($data, $pattern)
    {   
        $validation = new Validation($data, new Validator(Arrays::errorView()));
        $validation->makeValidation($pattern);
        return $validation->handleValidationError();
    }
}