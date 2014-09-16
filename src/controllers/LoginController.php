<?php

namespace controllers;

require_once('src/loginSystem.php');

use models\User;
use services\ClientService;
use services\SessionService;
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

    public function __construct(LoginView $loginView, UserView $userView, User $user,
                                ClientService $clientService, SessionService $sessionService) {
        $this->loginView = $loginView;
        $this->userView = $userView;
        $this->user = $user;

        $sessionService->setClientIdentifier($clientService->getClientIdentifier());
    }

    public function render() {
        if (!$this->user->isLoggedIn() and $this->loginView->isUserRemembered()) {
            if ($this->user->logInWithKey($this->loginView->getRememberedKey())) {
                $this->userView->setLoginSucceededRemembered();
            } else {
                $this->loginView->forgetUser();
                $this->loginView->setLoginErrorRemembered();
            }
        }

        if ($this->user->isLoggedIn()) {
            if ($this->userView->isAuthenticatingUser()) {
                $this->user->logOut();
                $this->loginView->forgetUser();
                $this->loginView->setHaveLoggedOut();
            }
        } else {
            if ($this->loginView->isAuthenticatingUser()) {
                $username = $this->loginView->getUsername();
                $password = $this->loginView->getPassword();

                if ($this->user->logIn($username, $password)) {
                    if ($this->loginView->shouldUserBeRemembered()) {
                        $this->loginView->rememberUser();
                    }
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
