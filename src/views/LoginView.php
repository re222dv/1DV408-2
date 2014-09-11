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

    public function __construct(Model $model, User $user, ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $model->registerModel($this, 'username');
        $model->registerModel($this, 'password');
        $model->registerModel($this, 'rememberMe');
        $model->registerModel($this, 'loginButton');

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
        return isset($this->variables['loginButton']);
    }

    /**
     * @param string $error
     */
    private function setError($error) {
        $this->setVariable('error', $error);
    }

    public function setLoginError() {
        $this->setError('Felaktigt användarnamn och/eller lösenord');
    }

    public function setHaveLoggedOut() {
        $this->setVariable('haveLoggedOut', true);
    }

    public function onRender() {
        if ($this->isAuthenticatingUser()) {
            if (empty($this->getUsername())) {
                $this->setError('Användarnamn saknas');
            } elseif (empty($this->getPassword())) {
                $this->setError('Lösenord saknas');
            }
        }
    }
}
