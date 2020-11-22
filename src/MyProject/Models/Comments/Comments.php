<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;


class Comments extends ActiveRecordEntity
{
    protected $id;

    protected $author_id;

    protected $article_id;

    protected $text;

    protected $created_at;

    public static function getAttributeNameArticleId(): string
    {
        return 'article_id';
    }

    public static function getTableName(): string
    {
        return 'comments';
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function getAuthor(int $author_id): User
    {
        $db = Db::getInstance();
        $nickname = $db->query('SELECT * FROM `users` where id =:' . $author_id, [':' . $author_id => $author_id], User::class);
        return $nickname[0];
    }


}