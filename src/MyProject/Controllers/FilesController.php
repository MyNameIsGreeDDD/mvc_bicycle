<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\DownloadException;
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
        $newFilePath = __DIR__ . '/../../../usersImages/' . $image['name'] = $this->user->getId() . '.png';

        try {
            if (!move_uploaded_file($image['tmp_name'], $newFilePath)) {
                throw new DownloadException('Ошибка при загрузке файла');
            }
        } catch (DownloadException $e) {
            $this->view->renderHtml('personalArea/personalArea.php', ['error' => $e->getMessage()]);
            return;
        }
        Images::addImage($newFilePath, $this->user->getId());
        header('Location:/personalArea');
        exit;


    }
}