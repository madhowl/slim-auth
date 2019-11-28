<?php


namespace App\Controllers\Auth;

use App\Models\UserModel;
use App\Controllers\BaseController;
use Respect\Validation\Validator as v;

class PasswordController extends BaseController
{

    public function getChangePassword($request, $response)
    {
        return $this->view->render($response, 'auth/password/change.twig');

    }
    public function postChangePassword($request, $response)
    {

    }
}