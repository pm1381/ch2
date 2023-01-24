<?php

namespace App\Configs;

use App\Helpers\Tools;
use ReflectionClass;
use ReflectionMethod;

class Application
{
    public function run()
    {
        $allFiles = Tools::getFilesInFolder(PROVIDER, ['ServiceProvider.php']);
        foreach ($allFiles as $value) {
            $fullName = 'App\providers' . "\\" .  explode(".", $value)[0];
            $refclass = new ReflectionClass($fullName);
            $methods = $refclass->getMethods();
            foreach ($methods as  $method) {
                if ($method->name == 'register') {
                    $registers[] = ['method' => 'register', "class" => $method->class];
                }

                if ($method->name == 'boot') {
                    $boots[] = ['method' => 'boot', "class" => $method->class];
                }
            }
        }
        
        foreach ($registers as $value) {
            $this->runClosures($value);
        }
        foreach ($boots as $value) {
            $this->runClosures($value);
        }
    }

    private function runClosures($value, $params = [])
    {
        $refMethod = new ReflectionMethod($value['class'], $value['method']);
        $closure = $refMethod->getClosure(new $value['class']);
        call_user_func_array($closure, $params);
    }
}
?>
