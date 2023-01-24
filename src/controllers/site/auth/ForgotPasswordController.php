<?php

namespace App\Controllers\Site\Auth;

use App\Helpers\Input;
use App\Entities\User;
use App\Classes\Response;
use App\Classes\Session;
use App\Events\PasswordChange;
use App\Controllers\Refrence\SiteRefrenceController;
use App\Helpers\Tools;
use App\Models\UserModel;

class ForgotPasswordController extends SiteRefrenceController {    
    public function showLinkRequestForm()
    {
        Tools::render("site\auth\showLinkRequestForm");
    }

    public function reset()
    {
        $dataArray = Input::getDataForm();
        $validateResult = $this->AuthValidation($dataArray, [
            'email' => 'required|email'
        ]);

        if ($validateResult['error'] == false) {
            $userEntity = new User();
            $userEntity->setEmail($dataArray['email']);
            $userModel = new UserModel();
            $result = $userModel->loginCheck($userEntity);
            if (count($result) > 0) {
                $forgotPassEvent = new PasswordChange(new User, $dataArray);
                $forgotPassEvent->dispatch();
                $session = new Session();
                $session->setFlash('success', 'email has been sent successfully');
                Response::setStatus(200, 'email has been sent successfully');
            } else {
                $errors[] = 'email not found . go to signup page';
            }
        } else {
            $errors[] = array_values($validateResult['firstError'])[0];
        }
        $session = new Session();
        (count($errors))? $session->setFlash('error', $errors[0]): '';
        // Tools::redirect(ORIGIN . '/password/reset/');
        // Response::setStatus(400, $errors[0]);
    }

    public function showResetForm($token)
    {

    }
}
