<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 06.05.2018
 * Time: 18:21
 */

use Entity\UserProfile;


class ModelUsersProfile extends Model
{
    private static $instance = null;

    public static function instance()
    {
        return self::$instance === null ?
            self::$instance = new self() :
            self::$instance;
    }

    protected function __construct()
    {
        parent::__construct();
    }

    public function getById(int $id): UserProfile
    {
        $profile = new UserProfile();
        $profile->fromAssoc($this->db->user_profile->getElementById($id));
        return $profile;
    }

    public function add(UserProfile $profile): int
    {
        return $this->db->user_profile->insert([
            "id" => $profile->id,
            "about" => $profile->about,
            "hobbies" => $profile->hobbies,
            "avatar_id" => $profile->avatar_id,
            "avatar_min_id" => $profile->avatar_min_id,
            "name" => $profile->name,
            "surname" => $profile->surname,
            "sex" => $profile->sex,
            "country" => $profile->country,
            "city" => $profile->city
        ]);
    }

    private function _update(UserProfile $profile)
    {
        $this->db->user_profile->updateById((int)$profile->id,[
            "about" => $profile->about,
            "hobbies" => $profile->hobbies,
            "avatar_id" => $profile->avatar_id,
            "avatar_min_id" => $profile->avatar_min_id,
            "name" => $profile->name,
            "surname" => $profile->surname,
            "sex" => $profile->sex,
            "country" => $profile->country,
            "city" => $profile->city
        ]);
    }

    public function update(int $id,
                           ?string $about,
                           ?string $hobbies,
                           ?int $avatar_id,
                           ?int $avatar_min_id,
                           ?string $name,
                           ?string $surname,
                           ?int $country,
                           ?int $city,
                           ?int $sex)
    {
        $profile = new UserProfile($id,
            $about ,
            $hobbies ,
            $avatar_id,
            $avatar_min_id,
            $name,
            $surname,
            $country,
            $city,
            $sex
        );
        if ($this->db->user_profile->countOfWhere("id=?",[$id]) !== 0) $this->_update($profile);
        else $this->add($profile);
    }

    public function addAvatar(int $id,int $img_src, int $img_min)
    {
        if ($this->db->user_profile->countOfWhere("id=?",[$id]) !== 0)
            $this->db->user_profile->updateById($id,["avatar_id"=>$img_src,"avatar_min_id"=>$img_min]);
        else $this->add(new UserProfile($id,null,null,$img_src,$img_min,null,null,null,null,null));
    }
}