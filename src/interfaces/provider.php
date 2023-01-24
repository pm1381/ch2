<?php
namespace App\Interfaces;

interface Provider
{
    public function register();

    public function boot();
}
?>