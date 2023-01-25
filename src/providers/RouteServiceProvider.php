<?php
namespace App\Providers;

use App\Helpers\Tools;
use App\Interfaces\Provider;
use App\Routers\RouteProvider;
use Bramus\Router\Router;
use ReflectionClass;
use ReflectionMethod;

class RouteServiceProvider extends ServiceProvider implements Provider {
    public function register()
    {
        $router = new Router();
        $router->setNamespace(CONTROLLER_NAMESPACE);
        $files = Tools::getFilesInFolder(ROUTER);
        foreach ($files as $key => $value) {
            $value = explode(".", $value)[0];
            $fullName = ROUTER . "\\" .  $value;
            $reflectionClass = new ReflectionClass($fullName);
            $reflectionMethod = new ReflectionMethod($fullName, 'getAllRoutes');
            $reflectionMethod->invoke($reflectionClass->newInstance($router));
        }
        $router->run();
    }

    public function boot()
    {
        
    }
}

