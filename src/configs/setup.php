<?php

use App\Configs\Application;

define('HOST_NAME', 'localhost');
define('DOMAIN', "http://localhost/");
define('DRIVER', "mysql");
define('BASE_URI', 'http://localhost/project/ch2/home');
define('ORIGIN', 'http://localhost/project/ch2');
define('JWT_SECRET_KEY', 'a new test for project');
define('JWT_ALGORITHM', 'HS512');
define('EXPIRE_DATE', '+20 minutes');

//---mongo database---//
define('MONGO_DB_NAME', '');

//---mysql database---//
define('DB_NAME', 'test');
define('USERNAME', 'root');
define('PASSWORD', '');

//---statics---//
define('SRC', 'src' . DIRECTORY_SEPARATOR);
define('PUBLIC_FOLDER', 'public' . DIRECTORY_SEPARATOR);
define('TEMPLATE', SRC . 'Views' . DIRECTORY_SEPARATOR);
define('ADMIN_TEMPLATE', TEMPLATE . 'admin' . DIRECTORY_SEPARATOR);
define('MODEL', SRC . 'Models' . DIRECTORY_SEPARATOR);
define('ROUTER', SRC . 'Routers' . DIRECTORY_SEPARATOR);
define('LIBRARY', SRC . 'Libs' . DIRECTORY_SEPARATOR);
define('CONFIG', SRC . 'Configs' . DIRECTORY_SEPARATOR);
define('PROVIDER', SRC . 'Providers' . DIRECTORY_SEPARATOR);
define('CONTROLLER', SRC . 'Controllers' . DIRECTORY_SEPARATOR);
define('SITE_CONTROLLER', CONTROLLER . 'Site' . DIRECTORY_SEPARATOR);
define('ADMIN_CONTROLLER', CONTROLLER . 'Admin' . DIRECTORY_SEPARATOR);
define('REFRENCE_CONTROLLER', CONTROLLER . 'Refrence' . DIRECTORY_SEPARATOR);
define('VIEW', SRC . 'views' . DIRECTORY_SEPARATOR);
define('SITE_VIEW', VIEW . 'site' . DIRECTORY_SEPARATOR);
define('ADMIN_VIEW', VIEW . 'admin' . DIRECTORY_SEPARATOR);
define("CONTROLLER_NAMESPACE", "App\Controllers");

// and adding all files from library floder
require LIBRARY . 'Function.php';

$application = new Application();
$application->run();
