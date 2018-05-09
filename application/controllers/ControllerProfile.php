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
        $this->response($view);
    }

    public function action_addinfo()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect404();
        $about = trim($_POST["about"]);
        $hobby = trim($_POST["hobby"]);
        $name = trim($_POST["name"]);
        $surname = trim($_POST["surname"]);
        $sex = trim($_POST["sex"]);
        ModelUsersProfile::instance()->update(
            (int)ModuleAuth::instance()->getUser()["id"],
            $about,$hobby,null,null,
            $name,$surname,null,null,$sex
        );
        $this->redirect("/");
    }
}