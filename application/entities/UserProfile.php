<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 06.05.2018
 * Time: 18:13
 */

namespace Entity;


class UserProfile extends Entity
{
    public $id,$about,$hobbies,$avatar_id,$avatar_min_id;

    public function __construct(
        int $id = null,
        string $about = null,
        string $hobbies = null,
        int $avatar_id = null,
        int $avatar_min_id = null)
    {
        $this->id = $id;
        $this->about = $about;
        $this->hobbies = $hobbies;
        $this->avatar_id = $avatar_id;
        $this->avatar_min_id = $avatar_min_id;
    }

    public static function fromAssocies(array $array): array
    {
        return self::_fromAssocies($array,self::class);
    }
}