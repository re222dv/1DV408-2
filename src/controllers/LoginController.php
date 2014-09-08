<?php

namespace controllers;

require_once('src/loginSystem.php');

use models\User;
use views\LoginView;

class LoginController {
    private $user;
    private $view;

    public function __construct(LoginView $view, User $user) {
        $this->view =$view;
        $this->user =$user;
    }

    public function render() {
        if ($this->view->isAuthenticatingUser()) {
            $username = $this->view->getUsername();
            $password = $this->view->getPassword();

            $this->user->logIn($username, $password);
        }

        return $this->view;
    }
}
