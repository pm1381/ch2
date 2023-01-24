<?php

namespace App\MiddleWares\Site;

use App\Helpers\Tools;
use App\Classes\Response;
use App\Models\LoginAttemptModel;

class Login {
    public function ipCheck() {
        if (Tools::getIp() == 'UNKNOWN') {
            Response::setStatus(400, 'unkonwn ip');
            exit();
        }
    }

    public function loginAttempt() {
        // check wrong number of neseccary attempts;
        $attempModel = new LoginAttemptModel();
        $count = $attempModel->howManyAttempts(Tools::getIp());
        if  ($count > 3) {
            Response::setStatus(400, 'too many attempts');
            exit();
        }
    }
}
