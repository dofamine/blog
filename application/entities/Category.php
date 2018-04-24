<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 10:07
 */

namespace Entity;


class Category extends Entity
{
    public $id,$name,$image_id;

    public function __construct(string $name="",int $image_id=0)
    {
        $this->name = $name;
        $this->image_id = $image_id;
    }
    public static function fromAssocies(array $array): array
    {
        return self::_fromAssocies($array,self::class);
    }

    public function getImage():?Image
    {
        if ($this->image_id === null) return NULL;
        return \ModelImages::instance()->getById($this->image_id);
    }
}