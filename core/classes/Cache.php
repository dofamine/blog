<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 19.05.2018
 * Time: 22:16
 */

class Cache {
    private static $inst = null;
    private static $memcache = null;

    private function __construct()
    {
        self::$memcache = new Memcache();
    }

    private function __sleep(){}

    private function __wakeup(){}

    public static function instance():?self
    {
        return self::$inst === null ? new self() : self::$inst;
    }

    public static function connect(?string $host):self
    {
        if (!self::$memcache->connect($host ? $host : '127.0.0.1', 11211))
            throw new Exception("Cannot connect to ${host} server");
        return self::$inst;
    }

    public static function add(string $key, $value)
    {

    }
}