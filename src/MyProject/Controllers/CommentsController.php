<?php


namespace MyProject\Controllers;


use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comments;
use MyProject\View\View;

class CommentsController extends AbstractController
{
    public function addComment($articleId): void
    {
        try {
            Comments::createComment($_POST, $this->user, $articleId);
        } catch (InvalidArgumentException $e) {
            $article = Article::getById($articleId);
            $comments = Comments::getAllByAttribute(Comments::getAttributeNameArticleId(), $articleId);
            $this->view->renderHtml('articles/view.php', ['article' => $article, 'comments' => $comments,
                'error' => $e->getMessage()]);
            return;
        }
        header('Location: /articles/' . $articleId, true, 302);
        exit;
    }

    public function deleteComment($articleId, $commentId): void
    {

        $comment = Comments::getById($commentId);
        if (!$comment) {
            header('Location: /articles/' . $articleId, true, 302);
        }
        $comment->delete();
        header('Location: /articles/' . $articleId, true, 302);
    }

    public function editComment($articleId, $commentId): void
    {
        $comment = Comments::getById($commentId);
        $article = Article::getById($articleId);
        $comments = Comments::getAllByAttribute(Comments::getAttributeNameArticleId(), $articleId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        try {
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Не администраторам редактировать комментарии запрещено');
            }
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('comments/editComments.php', ['error' => $e->getMessage(),
                'comment' => $comment]);
            return;
        }

        if (!empty($_POST)) {
            try {
                $comment->updateComment($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/editComments.php',
                    ['error' => $e->getMessage(), 'comment' => $comment, 'article' => $article, 'comments' => $comments,
                        'commentId' => $commentId]);
                return;
            }
            header('Location: /articles/' . $comment->getArticleId(), true, 302);
            exit;
        }

        $this->view->renderHtml('comments/editComments.php', ['comment' => $comment,
            'article' => $article]);
    }

    public function editComments($articleId, $commentId)
    {
        $comment = Comments::getById($commentId);
        $article = Article::getById($articleId);
        $comments = Comments::getAllByAttribute(Comments::getAttributeNameArticleId(), $articleId);

        $this->view->renderHtml('comments/editComments.php', ['comments' => $comments, 'article' => $article,
            'commentId' => $commentId
        ]);
    }
}