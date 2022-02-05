<?php
namespace App\Repositories;


class Repository
{
    private static $instance = null;



    protected static function bind($class)
    {
        if (static::$instance != $class) {
            static::$instance = new $class;
        }

        return static::$instance;
    }
}