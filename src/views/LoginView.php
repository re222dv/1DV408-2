<?php

namespace views;

require_once('src/loginSystem.php');

use models\User;
use Template\directives\Model;
use Template\View;
use Template\ViewSettings;

class LoginView extends View {
    protected $template = 'login.html';
    /**
     * @var User
     */
    private $user;

    public function __construct(Model $model, User $user,
                                ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $model->registerModel($this, 'username');
        $model->registerModel($this, 'password');
        $model->registerModel($this, 'rememberMe');
        $model->registerModel($this, 'submit');

        $this->user =$user;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->variables['username'];
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->variables['password'];
    }

    /**
     * @return bool
     */
    public function isAuthenticatingUser() {
        return isset($this->variables['submit']);
    }

    public function onRender() {
        $this->setVariable('isLoggedIn', $this->user->isLoggedIn());
        $this->setVariable('username', $this->user->getUsername());
    }
}
