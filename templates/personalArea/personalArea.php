<?php include __DIR__ . '/../main/header.php'; ?>
    <table width="100%">
        <tr>
            <td>
                зона информации об аккаунте
            </td>
            <td>
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