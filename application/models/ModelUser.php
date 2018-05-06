<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 06.05.2018
 * Time: 16:46
 */

class ModelUser extends Model
{
    private static $instance = null;

    public static function instance()
    {
        return self::$instance === null ?
            self::$instance = new self():
            self::$instance;
    }
    protected function __construct()
    {
        parent::__construct();
    }

}