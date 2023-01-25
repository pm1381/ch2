<?php

namespace App\Routers;

class AuthRoutes
{
    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function getAllRoutes()
    {
        $this->authMiddleWare();
        $this->authSite();
        $this->authAdmin();
    }

    private function authSite()
    {
        $this->router->get('/register/', 'site\auth\RegisterController@showRegistrationForm');
        $this->router->post('/register/', 'site\auth\RegisterController@register');
        $this->router->post('/password/email/', 'site\auth\ForgotPasswordController@sendResetLinkEmail', 'password.email');
        $this->router->get('/password/confirm/', 'site\auth\ConfirmPasswordController@showConfirmationForm', 'password.confirm');
        $this->router->post('/password/confirm/', 'site\auth\ConfirmPasswordController@confirm');
        $this->router->get('/login/', 'site\auth\LoginController@showLoginForm');
        $this->router->post('/login/', 'site\auth\LoginController@login');
        $this->router->post('/logout/', 'site\auth\LoginController@logout', 'logout');
        $this->router->get('/password/reset/', 'site\auth\ForgotPasswordController@showLinkRequestForm', 'password.request');
        $this->router->post('/password/reset/', 'site\auth\ForgotPasswordController@reset', 'password.update');
        $this->router->get('/password/reset/{token}/', 'site\auth\ForgotPasswordController@showResetForm');
    }

    private function authMiddleWare()
    {
        $this->router->before('POST', '/login/', 'middlewares\site\LoginMiddleWare@ipCheck');
        $this->router->before('GET', '/login/', 'middlewares\site\LoginMiddleWare@loginAttempt');
    }
    private function authAdmin()
    {
    }
}
