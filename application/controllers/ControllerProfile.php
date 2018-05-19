<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 07.05.2018
 * Time: 14:31
 */

class ControllerProfile extends Controller
{
    private $menuCtrl;
    private $rightSide;

    public function __construct()
    {
        $this->menuCtrl = new ControllerMenu();
        $this->menuCtrl->rightMenu();
        $this->rightSide = new ControllerHeaderRightSide();
    }

    public function action_show()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect404();
        $view = new View("profile");
        $view->useTemplate();
        $this->rightSide->userbarInit();
        $view->rightmenu = $this->menuCtrl->getResponse();
        $view->rightSide = $this->rightSide->getResponse();
        $user_id = (int)ModuleAuth::instance()->getUser()["id"];
        $view->profile = ModelUsersProfile::instance()->getById($user_id);
        $view->countries = ModuleDatabaseConnection::instance()->country->getAllWhere();
        $this->response($view);
    }

    public function action_addinfo()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect404();
        list($about,$hobby,$name,$surname) =
            $this->trimAll(@$_POST["about"],@$_POST["hobby"],@$_POST["name"],@$_POST["surname"]);
        $sex = @$_POST["sex"];
        $photo = $_FILES["photo"];
        $city = @$_POST["city"];
        $country = @$_POST["country"];
        if ($photo["size"] > 0)
            ModelImages::instance()->addAvatar((int)ModuleAuth::instance()->getUser()["id"], $photo);
        ModelUsersProfile::instance()->update(
            (int)ModuleAuth::instance()->getUser()["id"],
            $about,
            $hobby,
            ModelUsersProfile::instance()->getById((int)ModuleAuth::instance()->getUser()["id"])->avatar_id,
            ModelUsersProfile::instance()->getById((int)ModuleAuth::instance()->getUser()["id"])->avatar_min_id,
            $name,
            $surname,
            (int)$country,
            (int)$city,
            (int)$sex
        );
        $this->redirect("/");
    }

    public function trimAll()
    {
        $args = func_get_args();
        return array_map("trim",$args);
    }

}