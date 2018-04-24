<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 21.03.2018
 * Time: 13:24
 */

class ControllerMain extends Controller
{
    private $menuCtrl;

    public function __construct()
    {
        $this->menuCtrl = new ControllerMenu();
        $this->menuCtrl->rightMenu();
    }

    public function action_index()
    {
        $view = new View("main");
        $view->useTemplate();
        $view->posts = ModelPost::instance()->getTop(5);
        if(!empty($_SESSION["login_error"])){
            $view->error = $_SESSION["login_error"];
            $view->login = $_SESSION["login"];
            unset($_SESSION["login_error"]);
            unset($_SESSION["login"]);
        }
        $view->rightmenu = $this->menuCtrl->getResponse();
        $this->response($view);
    }

    public function action_register()
    {
        $view = new View("register");
        $view->useTemplate();
        $view->rightmenu = $this->menuCtrl->getResponse();
        if(!empty($_SESSION["validate_error"])){
            $view->error = $_SESSION["validate_error"];
            $view->old = $_SESSION["old"];
            unset($_SESSION["validate_error"]);
            unset($_SESSION["old"]);
        }
        $this->response($view);
    }
}