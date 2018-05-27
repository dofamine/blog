<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 27.05.2018
 * Time: 13:37
 */

class ControllerPaginator extends Controller
{
    private $view;
    private $countPerPage;
    private $uriParam;
    private $pagesAmount;
    private $baseUri;
    private $size;

    public function __construct(View $view,
                                int $countPerPage,
                                int $pagesAmount,
                                string $uriParam,
                                string $baseUri,
                                int $size = 9)
    {
        $this->countPerPage = $countPerPage;
        $this->uriParam = $uriParam;
        $this->view = $view;
        $this->pagesAmount = $pagesAmount;
        $this->baseUri = $baseUri;
        $this->size = $size;
    }

    public function getPage(): int
    {
        $page = $this->getUriParam($this->uriParam);
        if ($page === null) return 1;
        if (!preg_match("/^\d+$/", $page)) return 1;
        $page = (int)$page;
        if ($page < 1 ) return 1;
        if ($page > $this->pagesAmount) return $this->pagesAmount;
        return $page;
    }
    public function get()
    {
        try {
            $id = $this->getPage();
        } catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
        $this->view->nav = ModuleHtml::instance()->paginator($id,$this->pagesAmount,$this->baseUri,$this->size);
        $this->response($this->view);
        return true;
    }
}
















