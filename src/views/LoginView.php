<?php

namespace View;

require_once('src/loginSystem.php');

use Model\User;
use Template\View;
use Template\ViewSettings;

class LoginView extends View {
    protected $template = 'login.html';
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user, ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $this->user =$user;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $_POST['username'];
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $_POST['password'];
    }

    /**
     * @return bool
     */
    public function isAuthenticatingUser() {
        return isset($_POST['submit']);
    }

    public function onRender() {
        $this->setVariable('isLoggedIn', $this->user->isLoggedIn());
        $this->setVariable('username', $this->user->getUsername());
    }
}
