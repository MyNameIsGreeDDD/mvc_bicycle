<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\DownloadException;
use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Images\Images;
use MyProject\View\View;


class FilesController extends AbstractController
{
    public function downloadImage()
    {
        try {
            if (empty($_FILES['image'])) {
                throw new NotFoundException('Отсутсвует авaтар для загрузки');
            }
        } catch (NotFoundException $e) {
            $this->view->renderHtml('personalArea/personalArea.php', ['error' => $e->getMessage()]);
            return;
        }


        $image = $_FILES['image'];

        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'png', 'gif'];

        try {
            if (!in_array($extension, $allowedExtensions)) {
                throw new ForbiddenException('Загрузка файла такого типа запрещена.Разрешенные типы файлов:
                .jpg, .png, .gif');
            }
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('personalArea/personalArea.php', ['error' => $e->getMessage()]);
            return;
        }

        $userId = $this->user->getId();
        $newFilePath = 'usersImages/' . $image['name'] = $userId . '.' . $extension;

        try {
            if (!move_uploaded_file($image['tmp_name'], $newFilePath)) {
                throw new DownloadException('Ошибка при загрузке файла');
            }
        } catch (DownloadException $e) {
            $this->view->renderHtml('personalArea/personalArea.php', ['error' => $e->getMessage()]);
            return;
        }

        $checkAvatar = Images::checkAvatar($newFilePath, $userId);

        if ($checkAvatar === true) {
            $avatar = Images::getOneByAttribute(Images::getAttributeNameUserId(), $userId);
            $avatar->delete();
        }
        Images::addImage($newFilePath, $userId);

        header('Location:/personalArea');
        exit;
    }
}