<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;


class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        if ($user instanceof User) {
            $code = UserActivationService::createActivationCode($user);

            EmailSender::send($user, 'Активация', 'userActivation.php', [
                'userId' => $user->getId(),
                'code' => $code
            ]);

            $this->view->renderHtml('users/signUpSuccessful.php');
            return;
        }
        $this->view->renderHtml('users/signUp.php');
    }

    public function activateCode(int $userId, string $activationCode)
    {
        try {
            $user = User::getById($userId);
            if ($user === null) {
                throw new InvalidArgumentException('Не найден активриуемый пользователь');
            }
            if ($user->isConfirmed()) {
                throw new InvalidArgumentException('Пользватель уже активирован');
            }
            if (!UserActivationService::checkActivationCode($user, $activationCode)) {
                throw new InvalidArgumentException('Код активации неверен');
            }

            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
            if ($isCodeValid) {
                $user->activate();
                UserActivationService::deleteActivationCode($userId);
                echo 'OK!';
            }
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('errors/404.php', ['error' => $e->getMessage()]);
            return;
        }
    }


    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('users/login.php');
    }

    public function exit()
    {
        setcookie('token', $_COOKIE['token'], time() - 3600, '/', '', false, true);\
        header('Location: /');
    }
}
