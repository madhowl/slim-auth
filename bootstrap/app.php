<?php
use Respect\Validation\Validator as v;
session_start();
require __DIR__ .'/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' =>[
        'displayErrorDetails'=>true,
        'db' => [
            'driver' => 'mysql',
            'host' => '192.168.200.79',
            'database' => 'slim-auth',
            'username' => 'user',
            'password' => 'user',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefixs' =>'',
        ]
    ],

 ]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
};

$container['auth'] = function ($container){
    return new App\Auth\Auth;
};

$container['flash'] = function ($container){
    return new \Slim\Flash\Messages;
};

$container['view'] = function ($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views',[
        'cache' => false,
    ]);
    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash',$container->flash);

    return $view;
};

$container['validator'] = function ($container){
    return new \App\Validation\Validator;
};

$container['HomeController'] = function ($container){
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container){
    return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function ($container){
    return new \App\Controllers\Auth\PasswordController($container);
};

$container['csrf'] = function ($container){
    return new \Slim\Csrf\Guard;
};


$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));
$app->add(new App\Middleware\CsrfViewMiddleware($container));
$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');
require __DIR__.'/../app/routes.php';