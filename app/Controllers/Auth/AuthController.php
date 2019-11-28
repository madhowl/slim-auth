<?php

namespace App\Controllers\Auth;

use App\Models\UserModel;
use App\Controllers\BaseController;
use Respect\Validation\Validator as v;


class AuthController extends BaseController
{
    public function getSignOut($request, $response)
    {

        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));

    }

    public function getSignUp($request, $response)
    {

        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailavailable(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = UserModel::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'),PASSWORD_DEFAULT),
        ]);

        $this->auth->attempt($user->email, $request->getParam('password'));


        return $response->withRedirect($this->router->pathFor('home'));
    }
        public function getSignIN($request, $response)
    {

        return $this->view->render($response, 'auth/signin.twig');
    }

    public function postSignIN($request, $response)
    {
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );
        if (!$auth){
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->router->pathFor('home'));
    }

}