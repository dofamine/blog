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

    public function show()
    {
        if (ModuleAuth::instance()->isAuth()) $this->redirect404();
        $view = new View("profile");

    }
}