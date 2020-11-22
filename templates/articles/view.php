<?php include __DIR__ . '/../main/header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<?php if ($user != null) : ?>
    <?php if ($user->isAdmin() === true) : ?>
        <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a>
    <?php endif ?>
<?php endif ?>
<?php foreach ($comments as $comment): ?>
    <p><?= $comment->getAuthor($comment->getAuthorId())->getNickname() ?></p>
    <p><?= $comment->getText() ?></p>
    <hr>
<?php endforeach; ?>
<?php include __DIR__ . '/../main/footer.php'; ?>