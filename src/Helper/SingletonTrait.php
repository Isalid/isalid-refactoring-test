<?php
namespace App\Helper;

trait SingletonTrait
{
    protected static $instance = null;

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
