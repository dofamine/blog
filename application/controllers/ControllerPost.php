<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 8:31
 */

class ControllerPost extends Controller
{
    CONST POSTS_PER_PAGE = 5;
    private $menuCtrl;
    private $rightSide;

    public function __construct()
    {
        $this->menuCtrl = new ControllerMenu();
        $this->menuCtrl->rightMenu();
        $this->rightSide = new ControllerHeaderRightSide();
    }

    private static function is_empty()
    {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) return true;
        }
        return false;
    }

    public function action_details()
    {
        $id = $this->getUriParam("id");
        if (!preg_match("/^\d+$/", $id)) $this->redirect404();
        $post = ModelPost::instance()->getById((int)$id);
        $view = new View("posts/post");
        $view->useTemplate();
        if (ModuleAuth::instance()->isAuth()) {
            $user = ModuleAuth::instance()->getUser();
            $view->liked = ModelPost::instance()->isLikedByUser((int)$user["id"], (int)$post->id);
        }
        if ($post->id === null) $this->redirect404();
        if (empty($_SESSION["views"]) || !in_array(md5($id), $_SESSION["views"])) {
            $_SESSION["views"] = empty($_SESSION["views"]) ? [] : $_SESSION["views"];
            $_SESSION["views"][] = md5($id);
            ModelPost::instance()->updateViewsById($id, ++$post->views);
        }
        $view->post = $post;
        $view->rightmenu = $this->menuCtrl->getResponse();
        if (isset($user)) $this->rightSide->userbarInit();
        else $this->rightSide->logformInit();
        $view->rightSide = $this->rightSide->getResponse();
        $this->response($view);
    }

    public function action_myPosts()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        $view = new View("posts/posts");
        $view->useTemplate();
        $view->rightmenu = $this->menuCtrl->getResponse();
        $this->rightSide->userbarInit();
        $view->rightSide = $this->rightSide->getResponse();
        $user = ModuleAuth::instance()->getUser();
        $paginator = new ControllerPaginator(new View("admin/pag"),
            self::POSTS_PER_PAGE,
            ModelPost::instance()->getCountOfPagesByUser(self::POSTS_PER_PAGE, (int)$user["id"]),
            "id", "/post/showall");
        if ($paginator->get()) $view->paginator = $paginator->getResponse();
        $view->posts = ModelPost::instance()->getPostsByPageAndByUser($paginator->getPage(), self::POSTS_PER_PAGE, (int)$user["id"]);
        $this->response($view);
    }

    public function action_new()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        $view = new View("posts/addform");
        $view->categories = ModelCategories::instance()->getAll();
        $view->useTemplate();
        $this->rightSide->userbarInit();
        $view->rightSide = $this->rightSide->getResponse();
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
                $image_id = ModelImages::instance()->saveToDir("blog_images/", $img);
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

    public function action_like()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        $id = $this->getUriParam("id");
        if (!preg_match("/^\d+$/", $id)) $this->redirect404();
        $post = ModelPost::instance()->getById($id);
        if ($post->id === null) $this->redirect404();
        $user = ModuleAuth::instance()->getUser();
        echo ModelPost::instance()->addLikeToPost((int)$user["id"], (int)$post->id);
        $this->redirect($_SERVER["HTTP_REFERER"]);
    }
}