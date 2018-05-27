<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 21.05.2018
 * Time: 11:57
 */

class ControllerAdmin extends Controller
{
    private static function is_empty()
    {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) return true;
        }
        return false;
    }

    public function __construct()
    {
        try {
            ModuleAuth::instance()->hasRole("admin");
        } catch (Exception $e) {
//            echo $e->getMessage();
            $this->redirect404();
        }
    }

    public function action_index()
    {

    }

    public function action_paginator()
    {
        $id = (int)$this->getUriParam("id");
        $nav = ModuleHtml::instance()->paginator(
            $id,50,"/admin/paginator",10);
        $view = new View("admin/pag");
        $view->page = $id;
        $view->nav = $nav;
        $this->response($view);
    }
    public function action_addCategory()
    {
        try {
            if (self::is_empty(@$_POST["cat"]))
                throw new Exception("Empty field5");
            $img = $_FILES["img"];
            if ($img["size"] > 0) {
                $id = ModelImages::instance()->saveToDir("categories/", $img);
            }
            ModelCategories::instance()->addCategory(new \Entity\Category($_POST["cat"], @$id));
//            header("Location: http://blog/admin");
            $this->redirect(URLROOT."admin");
        } catch (Exception $e) {
            //            $this->redirect(URLROOT . "post/new");
            echo $e->getMessage();
        }
    }

}