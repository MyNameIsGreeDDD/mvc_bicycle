<?php include __DIR__ . '/../main/header.php'; ?>
    <table width="100%">
        <tr>
            <td>
                зона информации об аккаунте
            </td>
            <td>
                <?php if ($avatar !== null): ?>
                    <img src="<?= $avatar->getImagePath() ?>" width="150" height="150"
                         alt="Вы можете установить аватар">
                <?php endif ?>
                <?php if (!empty($error)): ?>
                    <div style="color: red;"><?= $error ?></div>
                <?php endif; ?>
                <form action="personalArea/downloadImage" method="post" enctype="multipart/form-data">
                    <input type="file" name="image">
                    <input type="submit">
                </form>
            </td>
        </tr>
        <tr>
            <td colspan="2">Зона о себе</td>
        </tr>
    </table>
<?php include __DIR__ . '/../main/footer.php'; ?>