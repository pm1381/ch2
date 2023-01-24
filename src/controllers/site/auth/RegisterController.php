<?php

namespace App\Controllers\Site\Auth;

use App\Classes\Cookie;
use App\Classes\Jwt;
use App\Helpers\Input;
use App\Helpers\Tools;
use App\Entities\User;
use App\Classes\Session;
use App\Interfaces\Auth;
use App\Classes\Response;
use App\Models\UserModel;
use App\Controllers\Refrence\SiteRefrenceController;

class RegisterController extends SiteRefrenceController implements Auth {
    public function showRegistrationForm()
    {
        Tools::render("site\auth\showRegister");
    }

    public function register()
    {
        $dataArray = Input::getDataForm();
        $validateResult = $this->AuthValidation($dataArray, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validateResult['error'] == false) {
            $userModel = new UserModel();
            $userEntity = new User();
            if ($userModel->createUser($userEntity, $dataArray)) {
                $token = Tools::createUniqueToken($userModel);
                $userEntity->setToken($token);
                $userModel->updateToken($userEntity);
                $session = new Session();
                $session->set('userId', $token);

                $jwt = new Jwt();
                $jwtData = $jwt->create(['email' => $userEntity->getEmail(), 'userId' => $token]);
                $cookie = new Cookie();
                $cookie->setName('jwtToken')->setContent($jwtData)->setExpire(EXPIRE_DATE)->add();
                return Response::setStatus(200, 'registered');
            }
            $errors[] = 'email exist before. try new';
        } else {
            $errors[] = array_values($validateResult['firstError'])[0];
        }
        
        $session = new Session();
        $session->setFlash('error', $errors[0]);

        // return Response::setStatus(400, $validateResult['grabResult']);
        Tools::redirect(ORIGIN . '/register/');
    }
}
