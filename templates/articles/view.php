<?php include __DIR__ . '/../main/header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<?php if ($user != null) : ?>
    <?php if ($user->isAdmin() === true) : ?>
        <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a>
        <?php if (!empty($error)): ?>
            <div style="color: red;"><?= $error ?></div>
        <?php endif; ?>
        <form action="/articles/<?= $article->getId() ?>/addComment" method="post">
            <label for="text">Комментировать</label><br>
            <textarea name="text" id="text" rows="5" cols="50"><?= $_POST['text'] ?? '' ?></textarea><br>
            <br>
            <input type="submit" value="->">
        </form>
    <?php endif ?>
<?php endif ?>
<?php foreach ($comments as $comment): ?>
    <p><?= $comment->getAuthor($comment->getAuthorId())->getNickname() ?></p>
    <p><?= $comment->getText() ?></p>
    <?php if ($user->isAdmin() === true) : ?>
        <a href="/articles/<?= $comment->getArticleId() ?>/deleteComment/<?= $comment->getId() ?>">Удалить</a>
        <a href="/articles/<?= $comment->getArticleId() ?>/editComments/<?= $comment->getId() ?>">Редактировать</a>
    <?php endif; ?>
    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../main/footer.php'; ?>