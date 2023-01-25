<?php

namespace App\Interfaces;

interface Auth
{
    public function authValidation(array $data, array $pattern);
}
