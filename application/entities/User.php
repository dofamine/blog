<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 06.05.2018
 * Time: 16:48
 */

namespace Entity;


class User extends Entity
{
    public $id,$login,$password,$email,$phone,$profile_id;

    public function __construct(
        string $login = null,
        string $password = null,
        string $email = null,
        string $phone = null,
        int $profile_id = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->profile_id = $profile_id;
    }

    public static function fromAssocies(array $array): array
    {
        return self::_fromAssocies($array,self::class);
    }
}