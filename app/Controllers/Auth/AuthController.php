<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;


class AuthController extends BaseController
{
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }
    public function postSignUp()
    {
        return 'lol';
    }
}