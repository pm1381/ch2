<?php

namespace App\Routers;

class WebRouter {

    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function getAllRoutes()
    {
        //middlewares
        //point : id in here has dependency injection
        $this->router->before('GET', '/users/{id}/', 'middlewares\site\UserMiddleWare@numCheck');
        $this->router->before('GET', '/home', 'middlewares\refrence\GeneralMiddleWare@login');

        $this->router->get('/users/', 'site\UserController@getUsers');
        $this->router->get("/users/{id}/", 'site\UserController@getUserById');
        $this->router->get('/home', 'site\HomeController@home');
        $this->router->post("/users/", 'site\UserController@createUser');
        $this->router->post("/users/{id}/", 'site\UserController@updateUser');
    }

}
?>
