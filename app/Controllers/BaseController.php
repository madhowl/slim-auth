<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.11.2019
 * Time: 9:57
 */

namespace App\Controllers;


class BaseController
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}){

            return $this->container->{$property};

        }
    }
}