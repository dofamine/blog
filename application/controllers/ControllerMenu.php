<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 14:21
 */

class ControllerMenu extends Controller
{
    public function rightMenu()
    {
        $view = new View("components/rightmenu");
        $view->categories = ModelCategories::instance()->getAll();
        $this->response($view);
    }

    public function action_showCategory()
    {
        $id = (int)$this->getUriParam("id");
    }
}