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
            self::$instance = new self() :
            self::$instance;
    }

    protected function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        return Post::fromAssocies($this->db->posts->getAllWhere());
    }

    public function getPostsByPageAndByUser(int $page, int $amount, int $id): array
    {
        return Post::fromAssocies($this->db->posts->getGroupByPage($page, $amount)->where('users_id', $id)->desc()->all());
    }

    public function getPostsByPageAndByCategories(int $page, int $amount, int $id): array
    {
        return Post::fromAssocies($this->db->posts->getGroupByPage($page, $amount)->where('categories_id', $id)->desc()->all());
    }

    public function getCountOfPagesByUser(int $amount, int $id): int
    {
        return $this->db->posts->pagesCounter($amount, "users_id=?", [$id]);
    }

    public function getCountOfPagesByCategory(int $amount, int $id): int
    {
        return $this->db->posts->pagesCounter($amount, "categories_id=?", [$id]);
    }

    public function getAllByUserId(int $id): array
    {
        return Post::fromAssocies($this->db->posts->getAllWhere("users_id=?", [$id]));
    }

    public function getById(int $id): Post
    {
        $post = new Post();
        $post->fromAssoc($this->db->posts->getElementById($id));
        return $post;
    }

    public function updateViewsById(int $id, int $views): void
    {
        $this->db->posts->updateById($id, ["views" => $views]);
    }

    public function addPost(Post $post): int
    {
        return $this->db->posts->insert([
            "name" => $post->name,
            "text" => $post->text,
            "time" => $post->time,
            "users_id" => (int)$post->users_id,
            "categories_id" => (int)$post->categories_id,
            "image_id" => $post->image_id
        ]);
    }

    public function getTop(int $n): array
    {
        return Post::fromAssocies($this->db->posts->limit($n)->desc()->all());
    }

    public function addLikeToPost(int $user_id, int $post_id)
    {
        if ($this->isLikedByUser($user_id, $post_id))
            $this->db->likes->deleteWhere("user_id=? AND post_id=?", [$user_id, $post_id]);
        else
            $this->db->likes->insert(["user_id" => $user_id, "post_id" => $post_id]);
    }

    public function isLikedByUser(int $user_id, int $post_id): bool
    {
        return $this->db->likes->countOfWhere("user_id=? AND post_id=?", [$user_id, $post_id]);
    }

    public function getAllInCategory(int $category_id): array
    {
        return Post::fromAssocies($this->db->posts->getAllWhere("categories_id", [$category_id]));
    }
}