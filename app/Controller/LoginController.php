<?php

namespace App\Controller;

use App\Component\Auth;
use App\Component\Controller;
use Exception;

/**
 * Class LoginController
 */
class LoginController extends Controller
{
    /**
     * @throws Exception
     */
    public function loginAction(): void
    {
        if ($this->isAuth()) {
            $this->redirect('/');
        }

        $this->render('login/login');
    }

    /**
     * logout
     */
    public function logoutAction(): void
    {
        Auth::logout();

        $this->redirect('/login');
    }

    /**
     * @throws Exception
     */
    public function checkAction(): void
    {
        if (!$this->isAjax()) {
            $this->redirect('/');
        }

        $errors = [];
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        Auth::login($username, $password);

        if ($this->isAuth()) {
            $this->renderJson(['success' => true]);
        } else {
            $errors['username'] = 'User not found or wrong password.';
        }

        if (!empty($errors)) {
            http_response_code(400);
            $this->renderJson(['errors' => $errors]);
        }
    }
}
