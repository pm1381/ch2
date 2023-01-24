<?php

namespace App\MiddleWares\Site;

use App\Classes\Response;
use App\Entities\User;
use App\Helpers\Tools;

class UserMiddleWare {
    public function numCheck(...$inputs) {
        $user = new User();
        if ($user->isLogin()['login']) {
            foreach ($inputs as $input) {
                if (! is_numeric($input)) {
                    Response::setStatus(404, 'page not found');
                }
            }
        } else {
            Tools::redirect(BASE_URI . '/register/');
        }
    }
}
