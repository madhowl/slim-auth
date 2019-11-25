<?php
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

$container['view'] = function ($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views',[
        'cache' => false,
    ]);
    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    return $view;
};

$container['HomeController'] = function ($container){
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container){
    return new \App\Controllers\Auth\AuthController($container);
};

require __DIR__.'/../app/routes.php';