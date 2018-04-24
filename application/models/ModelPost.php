<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23.04.2018
 * Time: 12:21
 */
use Entity\Post;
class ModelPost extends Model
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

    public function getAll():array
    {
        return Post::fromAssocies($this->db->posts->getAllWhere());
    }
    public function getAllByUserId(int $id):array
    {
        return Post::fromAssocies($this->db->posts->getAllWhere("users_id=?",[$id]));
    }

    public function getById(int $id): Post
    {
        $post = new Post();
        $post->fromAssoc($this->db->posts->getElementById($id));
        return $post;
    }
    public function addPost(Post $post): int
    {
        return $this->db->posts->insert([
            "name"=>$post->name,
            "text"=>$post->text,
            "time"=>$post->time,
            "users_id"=>(int)$post->users_id,
            "categories_id"=>(int)$post->categories_id,
            "image_id"=>$post->image_id
        ]);
    }

    public function getTop(int $n)
    {
        return Post::fromAssocies($this->db->posts->limit($n)->desc()->getAllWhere());
    }
}