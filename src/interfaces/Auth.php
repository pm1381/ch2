<?php
namespace App\Interfaces;

interface Auth
{
    public function AuthValidation(array $data, array $pattern);
}
?>