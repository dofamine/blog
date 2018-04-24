<?php

namespace Entity;


class Image extends Entity
{
    public $id,$name,$url;

    public function __construct(string $url="",string $name="")
    {
        $this->name = $name;
        $this->url = $url;
    }
    public static function fromAssocies(array $array): array
    {
        return self::_fromAssocies($array,self::class);
    }
}