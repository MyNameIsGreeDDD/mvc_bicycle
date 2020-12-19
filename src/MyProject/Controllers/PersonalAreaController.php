<?php


namespace MyProject\Controllers;

use MyProject\Models\Images\Images;
use MyProject\View\View;


class PersonalAreaController extends AbstractController
{
    public function view()
    {
        $avatar = Images::getOneByAttribute(Images::getAttributeNameUserId(), $this->user->getId());
        $this->view->renderHtml('personalArea/personalArea.php', ['avatar' => $avatar]);
    }

}