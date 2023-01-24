<?php

namespace App\MiddleWares\Refrence;

use App\Entities\User;

class General {
    public function login()
    {
        $userService = new User();
        // login check using sessions;
        // $current = $userService->isLogin();

        //login check using jwt
        $current = $userService->isLoginJwt();
        if ($current['login'] == false) {
            exit();
        }
    }
}
