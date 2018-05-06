<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 8:31
 */

class ControllerPost extends Controller
{
    private $menuCtrl;

    public function __construct()
    {
        $this->menuCtrl = new ControllerMenu();
        $this->menuCtrl->rightMenu();
    }

    private static function is_empty()
    {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) return true;
        }
        return false;
    }

    public function action_myPosts()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        $view = new View("posts/posts");
        $view->useTemplate();
        $view->rightmenu = $this->menuCtrl->getResponse();
        $user = ModuleAuth::instance()->getUser();
        $view->posts = ModelPost::instance()->getAllByUserId((int)$user["id"]);
        $this->response($view);
    }

    public function action_new()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        $view = new View("posts/addform");
        $view->categories = ModelCategories::instance()->getAll();
        $view->useTemplate();
        $view->rightmenu = $this->menuCtrl->getResponse();
        if (!empty($_SESSION["addpost_error"])) {
            $view->error = $_SESSION["addpost_error"];
            $view->values = $_SESSION["addpost_values"];
            unset($_SESSION["addpost_error"]);
            unset($_SESSION["addpost_values"]);
        }
        $this->response($view);
    }

    public function action_add()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        try {
            if (self::is_empty(trim(@$_POST["header"]), trim(@$_POST["text"]), trim(@$_POST["category"])))
                throw new Exception("Enter all fields please");
            $user = ModuleAuth::instance()->getUser();
            $img = $_FILES["image"];
            if ($img["size"] > 0)
                $image_id = ModelImages::instance()->saveToDir("blog_images/",$img);

            ModelPost::instance()->addPost(new \Entity\Post(
                trim($_POST["header"]),
                trim($_POST["text"]),
                time(),
                $user["id"],
                trim($_POST["category"]),
                @$image_id));
            $this->redirect(URLROOT);
        } catch (Exception $e) {
            $_SESSION["addpost_error"] = $e->getMessage();
            $_SESSION["addpost_values"] = [
                "header" => @$_POST["header"],
                "text" => @$_POST["text"]
            ];
            $this->redirect(URLROOT . "post/new");
        }
    }
}