<?php

namespace App\Controllers\Auth;

use App\Models\UserModel;
use App\Controllers\BaseController;


class AuthController extends BaseController
{
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }
    public function postSignUp($request, $response)
    {
        $user = UserModel::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'),PASSWORD_DEFAULT),
        ]);
        //var_dump($user);

        return $response->withRedirect($this->router->pathFor('home'));
    }
}