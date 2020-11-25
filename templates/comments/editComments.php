<?php include __DIR__ . '/../main/header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <hr>
<?php foreach ($comments as $comment): ?>
    <p><?= $comment->getAuthor($comment->getAuthorId())->getNickname() ?></p>
    <p><?= $comment->getText() ?></p>
    <?php if ($comment->getId() == $commentId) : ?>

        <?php if (!empty($error)): ?>
            <div style="color: red;"><?= $error ?></div>
        <?php endif; ?>

        <form action="/articles/<?= $comment->getArticleId() ?>/editComment/<?= $comment->getId() ?>" method="post">
            <label for="text">Введите текст для редактирования</label><br>
            <textarea name="text" id="text" rows="5" cols="50"><?= $_POST['text'] ?? '' ?></textarea><br>
            <br>
            <input type="submit" value="->">
        </form>
        <hr>
    <?php endif; ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../main/footer.php'; ?>