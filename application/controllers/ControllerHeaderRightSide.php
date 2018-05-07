<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 06.05.2018
 * Time: 14:44
 */

class ControllerHeaderRightSide extends Controller
{
    public function logformInit()
    {
        $view = new View("components/login");
        if (!empty($_SESSION["login_error"])) {
            $view->errorLogin = $_SESSION["login_error"];
            $view->login = $_SESSION["login"];
            unset($_SESSION["login_error"]);
            unset($_SESSION["login"]);
        }
        $this->response($view);
    }

    public function userbarInit()
    {
        $view = new View("components/userInterface");
        $user_id = (int)ModuleAuth::instance()->getUser()["id"];
        $profile = ModelUsersProfile::instance()->getById($user_id);
        if ($profile->avatar_min_id)
            $view->avatar = ModelImages::instance()->getById((int)$profile->avatar_min_id);
        $this->response($view);
    }
}