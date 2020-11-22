<?php

namespace MyProject\Controllers;


use MyProject\Services\Db;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;
use MyProject\Models\Articles\Article;

class MainController extends AbstractController
{

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

}