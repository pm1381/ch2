<?php
namespace App\Providers;

use App\Interfaces\Provider;
use App\Routers\RouteProvider;
use Bramus\Router\Router;

class RouteServiceProvider extends ServiceProvider implements Provider {
    public function register()
    {
        $route = new RouteProvider(new Router());
        $route->routeManage();
    }

    public function boot()
    {
        
    }
}

