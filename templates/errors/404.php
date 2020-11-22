<?php if (empty($error)): ?>
    <h1>Страница не найдена</h1>
<?php else : ?>
    <h1>Чего-то не хватает ;(</h1>
    <p><?= $error ?></p>
<?php endif; ?>