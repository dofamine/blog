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
    public $id, $about, $hobbies, $avatar_id, $avatar_min_id, $name, $surname, $country, $city, $sex;

    public function __construct(
        int $id = null,
        string $about = null,
        string $hobbies = null,
        int $avatar_id = null,
        int $avatar_min_id = null,
        string $name = null,
        string $surname = null,
        int $country = null,
        int $city = null,
        int $sex = null
    )
    {
        $this->id = $id;
        $this->about = $about;
        $this->hobbies = $hobbies;
        $this->avatar_id = $avatar_id;
        $this->avatar_min_id = $avatar_min_id;
        $this->name = $name;
        $this->sex = $sex;
        $this->surname = $surname;
        $this->city = $city;
        $this->country = $country;
    }

    public static function fromAssocies(array $array): array
    {
        return self::_fromAssocies($array, self::class);
    }

    public function getCitiesOfCurrentCountry(): array
    {
        return \ModuleDatabaseConnection::instance()->cities->getAllWhere("country_id=?", [$this->country]);
    }

    public function getAvatar_min()
    {
        return \ModelImages::instance()->getById($this->avatar_min_id)->url;
    }

    public function getAvatar()
    {
        return \ModelImages::instance()->getById($this->avatar_id)->url;
    }
}