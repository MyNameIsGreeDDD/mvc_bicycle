<?php

namespace MyProject\Models\Comments;

use MyProject\Controllers\CommentsController;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;


class Comments extends ActiveRecordEntity
{
    protected $id;

    protected $authorId;

    protected $articleId;

    protected $text;

    protected $createdAt;

    public static function getAttributeNameArticleId(): string
    {
        return 'article_id';
    }

    public static function getTableName(): string
    {
        return 'comments';
    }

    public function getText()
    {
        return $this->text;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getAuthor(int $author_id): User
    {
        $db = Db::getInstance();
        $nickname = $db->query('SELECT * FROM `users` where id =:' . $author_id, [':' . $author_id => $author_id], User::class);
        return $nickname[0];
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }

    public function setArticleId($articleId): void
    {
        $this->articleId = $articleId;
    }

    public static function createComment($fields, User $author, $articleId): Comments
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }
        $comment = new Comments();

        $comment->setText($fields['text']);
        $comment->setAuthorId($author->getId());
        $comment->setArticleId($articleId);

        $comment->save();

        return $comment;
    }

    public function updateComment(array $fields): Comments
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }
        $this->setText($fields['text']);

        $this->save();

        return $this;
    }


}