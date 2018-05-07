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
            "avatar_min_id" => $profile->avatar_min_id
        ]);
    }

    private function _update(UserProfile $profile)
    {
        $this->db->user_profile->updateById((int)$profile->id,[
            "about" => $profile->about,
            "hobbies" => $profile->hobbies,
            "avatar_id" => $profile->avatar_id,
            "avatar_min_id" => $profile->avatar_min_id
        ]);
    }

    public function update(int $id,string $about,string $hobbies,int $avatar_id,int $avatar_min_id)
    {
        $profile = new UserProfile();
    }
}