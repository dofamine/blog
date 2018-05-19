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
        else return $this->addImage(new Image(MEDIA_URL."images/".$path.$name));
    }

    public function addAvatar(int $user_id,array $photo)
    {
        $img_source_id = $this->saveToDir("avatars/avatar_source/",$photo);
        $source_path = $this->getById($img_source_id)->url;
        $min_path = $this->createResized($source_path,"avatars/avatar_min/",100,100);
        ModelUsersProfile::instance()->addAvatar(
            $user_id,
            $img_source_id,
            $this->addImage(new \Entity\Image($min_path))
        );
    }

    public function createResized(string $path_from,string $path_to,int $width,int $height):string
    {
        $type = end(explode(".",$path_from));
        if ($type === "jpg" || $type === "jpeg" ) $img = imagecreatefromjpeg(DOCROOT.$path_from);
        elseif ($type === "png") $img = imagecreatefrompng(DOCROOT.$path_from);
        else throw new Exception("Incorrect file to resize");

        $img_small = imagecreatetruecolor($width, $height);
        $size = getimagesize(DOCROOT.$path_from);

        $w = $size[0];
        $h = $size[1];

        $name = md5(time())."_".mt_rand(0,100000)."_".rand(10000,99999).".".$type;
        $url = MEDIA_URL."images/".$path_to.$name;
        $path_to = MEDIA_PATH."images/".$path_to.$name;

        imagecopyresampled($img_small, $img,
            0, 0, 0, 0,
            $width, $height, $w, $h);

        $type === "png" ? imagepng($img_small,$path_to) : imagejpeg($img_small,$path_to);
        return $url;
    }
}