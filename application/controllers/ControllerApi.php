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

        $curl = curl_init("https://www.linkedin.com/");
        curl_setopt($curl,CURLOPT_HEADER,true);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        $html = curl_exec($curl);
        curl_close($curl);
        echo $html;

    }
}