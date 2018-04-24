<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 10:17
 */

use \Entity\Category;

class ModelCategories extends Model
{
    private static $instance = null;

    public static function instance()
    {
        return self::$instance === null ?
            self::$instance = new self():
            self::$instance;
    }
    protected function __construct()
    {
        parent::__construct();
    }
    public function getAll()
    {
        return Category::fromAssocies($this->db->categories->getAllWhere());
    }

    public function getById(int $id): Category
    {
        $category = new Category();
        $category->fromAssoc($this->db->categories->getElementById($id));
        return $category;
    }

    public function addCategory(Category $category): int
    {
        return $this->db->categories->insert([
            "name"=>$category->name,
            "image_id"=>$category->image_id
        ]);
    }
}