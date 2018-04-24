<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 21.03.2018
 * Time: 15:58
 */

use Entity\Image;

class ModelImages extends Model
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
        return Image::fromAssocies($this->db->image->getAllWhere());
    }

    public function getById(int $id): Image
    {
        $img = new Image();
        $img->fromAssoc($this->db->image->getElementById($id));
        return $img;
    }

    public function addImage(Image $image): int
    {
        return $this->db->image->insert([
            "url"=>$image->url,
            "name"=>$image->name
        ]);
    }
}