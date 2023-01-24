<?php

namespace App\Routers;

use App\Helpers\Tools;
use ReflectionClass;
use ReflectionMethod;

class RouteProvider
{
    private $router;

    public function __construct($router)
    {
        $this->router = $router;

        //MY namespace : App\Controllers
        $this->router->setNamespace(CONTROLLER_NAMESPACE);
    }
    public function routeManage()
    {
        $files = Tools::getFilesInFolder(ROUTER, ['RouteProvider.php']);
        foreach ($files as $key => $value) {
            $value = explode(".", $value)[0];
            $fullName = __NAMESPACE__ . "\\" .  $value;
            $reflectionClass = new ReflectionClass($fullName);
            $reflectionMethod = new ReflectionMethod($fullName, 'getAllRoutes');
            $reflectionMethod->invoke($reflectionClass->newInstance($this->router));
        }

        $this->router->run();
    }
}
