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

    public function saveToDir(string $path,array $file):int
    {
        $type = explode("/",$file["type"]);
        $image_type = end($type);
        $name = md5(time())."_".mt_rand(0,100000)."_".rand(10000,99999).".".$image_type;
        if (!move_uploaded_file($file["tmp_name"],MEDIA_PATH."images/".$path.$name))
            throw new Exception("Error saving image");
        else return self::instance()->addImage(new Image(MEDIA_URL."images/".$path.$name));
    }
}