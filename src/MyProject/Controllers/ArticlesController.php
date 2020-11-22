<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comments;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\View\View;
use MyProject\Exceptions\UnauthorizedException;


class ArticlesController extends AbstractController
{
    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);
        $comments = Comments::getAttribute(Comments::getAttributeNameArticleId(), $articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article, 'comments' => $comments
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        try {
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Не администраторам редактировать статьи запрещено');
            }
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
            return;
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php',
                    ['error' => $e->getMessage(), 'article' => $article]);
                return;
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit;
        }
        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function addArticle(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        try {
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Не администраторам запрещено создавать статьи');
            }
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('articles/addArticle.php', ['error' => $e->getMessage()], 403);
            return;
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/addArticle.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articles/addArticle.php');
    }

    public function deleteArticle($articleId): void
    {
        $article = Article::getById($articleId);
        if ($article !== null) {
            $article->delete();
        } else {
            echo 'Такой записи нет в дб';
        }
    }
}