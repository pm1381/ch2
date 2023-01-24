<?php
namespace App\Providers;

use App\Classes\Session;
use App\Interfaces\Provider;

class AppServiceProvider extends ServiceProvider implements Provider {
    public function register()
    {
        $session = new Session();
        $session->start();

    }

    public function boot()
    {
        
    }
}
