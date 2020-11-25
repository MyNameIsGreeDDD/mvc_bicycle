<?php
return [
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/addArticle$~' => [\MyProject\Controllers\ArticlesController::class, 'addArticle'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'deleteArticle'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activateCode'],
    '~^users/login~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/exit~' => [\MyProject\Controllers\UsersController::class, 'exit'],
    '~^articles/(\d+)/addComment$~' => [\MyProject\Controllers\CommentsController::class, 'addComment'],
    '~^articles/(\d+)/deleteComment/(\d+)$~' => [\MyProject\Controllers\CommentsController::class, 'deleteComment'],
    '~^articles/(\d+)/editComments/(\d+)$~' => [\MyProject\Controllers\CommentsController::class, 'editComments'],


];
