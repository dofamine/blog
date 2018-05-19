<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 10.05.2018
 * Time: 18:58
 */

class ControllerApi extends Controller
{
    public function action_getCities()
    {
        $country = (int)$this->getUriParam("id");
        try {
            echo json_encode(ModuleDatabaseConnection::instance()->cities->getAllWhere("country_id=?", [$country]));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function action_getCache()
    {
//        $memcache = new Memcache();
////        var_dump($memcache);
//        $memcache->connect('127.0.0.1', 11211) or die ("Не могу подключиться");
//        echo "<pre>";
        print_r(new ReflectionClass(Cache::instance()));
        //$get_result = $memcache->delete('l1');
//
//        $version = $memcache->getVersion();
//        echo "Версия сервера: " . $version . "<br/>\n";
//
//        $tmp = 1;
//        $memcache->set("l1",$tmp,MEMCACHE_COMPRESSED,0) or die ("Ошибка при сохранении данных на сервере");
////
//        $memcache->increment("l1");
//        echo "Данные из кеша:<br/>\n";
//
//        var_dump($memcache->get("l1"));
    }
}