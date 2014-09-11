<?php

namespace controllers;

require_once('src/loginSystem.php');

use models\User;
use views\LoginView;
use views\UserView;

class LoginController {
    private $user;
    /**
     * @var LoginView
     */
    private $loginView;
    /**
     * @var UserView
     */
    private $userView;

    public function __construct(LoginView $loginView, UserView $userView, User $user) {
        $this->loginView = $loginView;
        $this->userView = $userView;
        $this->user = $user;
    }

    public function render() {
        if ($this->user->isLoggedIn()) {
            if ($this->userView->isAuthenticatingUser()) {
                $this->user->logOut();
                $this->loginView->setHaveLoggedOut();
            }
        } else {
            if ($this->loginView->isAuthenticatingUser()) {
                $username = $this->loginView->getUsername();
                $password = $this->loginView->getPassword();

                if ($this->user->logIn($username, $password)) {
                    $this->userView->setLoginSucceeded();
                } else {
                    $this->loginView->setLoginError();
                }
            }
        }

        if ($this->user->isLoggedIn()) {
            return $this->userView;
        } else {
            return $this->loginView;
        }
    }
}
