<?php


namespace MyProject\Controllers;

use MyProject\View\View;


class PersonalAreaController extends AbstractController
{
    public function view()
    {
        $this->view->renderHtml('personalArea/personalArea.php');
    }

}