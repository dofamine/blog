<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 14:21
 */

class ControllerMenu extends Controller
{
    const POSTS_PER_PAGE = 5;
    private $rightSide;
    public function __construct()
    {
        $this->rightSide = new ControllerHeaderRightSide();
    }

    public function rightMenu()
    {
        $view = new View("components/rightmenu");
        $view->categories = ModelCategories::instance()->getAll();
        $this->response($view);
    }
    private function rightSide(){
        if (!ModuleAuth::instance()->isAuth()){
            $this->rightSide->logformInit();
        } else {
            $this->rightSide->userbarInit();
        }
    }

    public function action_showCategory()
    {
        $id = (int)$this->getUriParam("id");
        ModelPost::instance()->getAllInCategory($id);
        $view = new View("posts/posts");
        $view->useTemplate();
        $this->rightMenu();
        $view->rightmenu = $this->getResponse();
        $this->rightSide();
        $view->rightSide = $this->rightSide->getResponse();
        $paginator = new ControllerPaginator(new View("admin/pag"),
            self::POSTS_PER_PAGE,
            ModelPost::instance()->getCountOfPagesByCategory(self::POSTS_PER_PAGE, $id),
            "page", "/categories/{$id}");
        if ($paginator->get()) $view->paginator = $paginator->getResponse();
        $view->posts = ModelPost::instance()->getPostsByPageAndByCategories($paginator->getPage(),self::POSTS_PER_PAGE, $id);
        $this->response($view);
    }
}