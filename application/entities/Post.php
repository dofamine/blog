<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 11:44
 */

namespace Entity;


class Post extends Entity
{
    public $id,$name,$text,$likes,$views,$time,$users_id,$categories_id,$image_id;

    public function __construct(string $name="",string $text="",int $time=0,int $users_id=0,int $categories_id=0,int $image_id=null,int $likes=0,int $views=0)
    {
        $this->name = $name;
        $this->text = $text;
        $this->likes = $likes;
        $this->views = $views;
        $this->time = $time;
        $this->users_id = $users_id;
        $this->categories_id = $categories_id;
        $this->image_id = $image_id;
    }

    public function getImage():?Image
    {
        if (!$this->image_id) return null;
        return \ModelImages::instance()->getById($this->image_id);
    }

    public function getCategory():Category
    {
        return \ModelCategories::instance()->getById($this->categories_id);
    }
    public static function fromAssocies(array $array): array
    {
        return self::_fromAssocies($array,self::class);
    }
}