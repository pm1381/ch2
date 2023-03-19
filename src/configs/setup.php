<?php

use App\Configs\Application;

define('HOST_NAME', 'localhost');
define('DOMAIN', "http://localhost/");
define('DRIVER', "mysql");
define('BASE_URL', 'http://localhost/project/hera/admin/list/');
define('ORIGIN', 'http://localhost/project/hera/');
define('ADMIN_ORIGIN', 'http://localhost/project/hera/admin');
define('JWT_SECRET_KEY', 'new test for project');
define('JWT_ALGORITHM', 'HS512');
define('EXPIRE_DATE', '+55 minutes');
define('LIMIT', 10);
define('REMAIN_LOG', 1000);

//---mongo database---//
define('MONGO_DB_NAME', '');

//---mysql database---//
define('DB_NAME', 'hera');
define('USERNAME', 'root');
define('PASSWORD', '');

//---statics---//
define('SRC', 'src' . DIRECTORY_SEPARATOR);
define('PUBLIC_FOLDER', 'public' . DIRECTORY_SEPARATOR);
define('UPLOAD', PUBLIC_FOLDER . 'upload' . DIRECTORY_SEPARATOR);
define('TEMPLATE', SRC . 'Views' . DIRECTORY_SEPARATOR);
define('ADMIN_TEMPLATE', TEMPLATE . 'admin' . DIRECTORY_SEPARATOR);
define('MODEL', SRC . 'Models' . DIRECTORY_SEPARATOR);
define('ROUTER', SRC . 'Routers' . DIRECTORY_SEPARATOR);
define('LIBRARY', SRC . 'Libs' . DIRECTORY_SEPARATOR);
define('CONFIG', SRC . 'Configs' . DIRECTORY_SEPARATOR);
define('PROVIDER', SRC . 'Providers' . DIRECTORY_SEPARATOR);
define('POLICY', SRC . 'Policies' . DIRECTORY_SEPARATOR);
define('CONTROLLER', SRC . 'Controllers' . DIRECTORY_SEPARATOR);
define('SITE_CONTROLLER', CONTROLLER . 'Site' . DIRECTORY_SEPARATOR);
define('ADMIN_CONTROLLER', CONTROLLER . 'Admin' . DIRECTORY_SEPARATOR);
define('REFRENCE_CONTROLLER', CONTROLLER . 'Refrence' . DIRECTORY_SEPARATOR);
define('VIEW', SRC . 'views' . DIRECTORY_SEPARATOR);
define('SITE_VIEW', VIEW . 'site' . DIRECTORY_SEPARATOR);
define('ADMIN_VIEW', VIEW . 'admin' . DIRECTORY_SEPARATOR);
define("CONTROLLER_NAMESPACE", "App\Controllers");
define("MIDDLEWARE_NAMESPACE", "App\MiddleWares" . DIRECTORY_SEPARATOR);
define('ROUTER_NAMESPACE', "App\Routers" . DIRECTORY_SEPARATOR);
define("POLICY_NAMESPACE", "App\Policies" . DIRECTORY_SEPARATOR);

// and adding all files from library floder
// ./vendor/bin/phpcs  --standard=phpcs.xml src\ phpcs check error. to solve errors use phpcbf
require LIBRARY . 'Function.php';
require LIBRARY . 'JDF.php';

$application = new Application();
$application->run();
