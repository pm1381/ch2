<?php

namespace App\Controllers\Refrence;

use ReflectionClass;

class GeneralRefrenceController {
    protected $model = null;
    protected $view = null;

    public function __construct()
    {
        $namespace = explode("\\", $this::class);
        $controllerName = $namespace[count($namespace) - 1];
        $modelName = str_replace("Controller", "", $controllerName);
        $modelNamespace = 'App\\Models\\' . $modelName . "Model";
        if (class_exists($modelNamespace)) {
            $reflectionClass = new ReflectionClass($modelNamespace);
            $newInstance = $reflectionClass->newInstance();
            $this->model = $newInstance;
        }
    }

    protected function makeClassData($dataArray, $className) {
        $reflectionClass = new ReflectionClass($className);
        $newInstance = $reflectionClass->newInstanceWithoutConstructor();
        $userClassProperties = $reflectionClass->getProperties();
        if (count($dataArray) == count($userClassProperties)) {
            $i = 0;
            foreach ($dataArray as $key => $value) {
                foreach($userClassProperties as $prop) {
                    $prop->setAccessible(true);
                    if ($key == $prop->getName()) {
                        $i++;
                        $prop->setValue($newInstance, $value);
                        break;
                    }
                }
            }
            if ($i == count($dataArray)) {
                return $newInstance;
            }
        }
        return '';
    }
}