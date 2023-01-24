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
use App\Models\LoginAttemptModel;
use App\Controllers\Refrence\SiteRefrenceController;

class LoginController extends SiteRefrenceController implements Auth {    
    public function showLoginForm()
    {
        Tools::render('site\auth\showLoginForm');
    }

    public function login()
    {
        $dataArray = Input::getDataForm();
        $validateResult = $this->AuthValidation($dataArray, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validateResult['error'] == false) {
            $user = new User();
            $user->setEmail($dataArray['email']);
            $user->setPassword($dataArray['password']);
            $this->model = new UserModel();
            $result = $this->model->loginCheck($user);
            
            if (count($result) > 0) {
                $user->setId($result[0]->id);
                $token = Tools::createUniqueToken($this->model);
                $user->setToken($token);
                $this->model->updateToken($user);
                $session = new Session();
                $session->set('userId', $token);

                $jwt = new Jwt();
                $jwtData = $jwt->create(['email' => $user->getEmail(), 'userId' => $token]);
                $cookie = new Cookie();
                $cookie->setName('jwtToken')->setContent($jwtData)->setExpire(EXPIRE_DATE)->add();

                return Response::setStatus(200, 'logged in');
            } else {
                $errors[] = 'user does not exist';
            }
            $this->addLoginAttempt();
        } else {
            $errors[] = array_values($validateResult['firstError'])[0];
        }
        
        $session = new Session();
        $session->setFlash('error', $errors[0]);
        // return Response::setStatus(400, $errors);
        Tools::redirect(ORIGIN . '/login/');       
    }

    public function logout()
    {
        $session = new Session();
        $session->delete('userId');
        Tools::redirect($this->redirectTo, 301);
    }

    private function addLoginAttempt()
    {
        $attempModel = new LoginAttemptModel();
        $attempModel->addAttempt();
    }

}