<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.11.2019
 * Time: 14:43
 */

namespace App\Controllers;
use Slim\Views\Twig as View;

class HomeController extends BaseController
{

    public function index($request,$response)
    {
        
        return $this->container->view->render($response, 'home.twig');
    }


}