<?php

namespace views;

require_once('src/loginSystem.php');

use models\User;
use Template\directives\Model;
use Template\View;
use Template\ViewSettings;

class UserView extends View {
    protected $template = 'user.html';
    /**
     * @var BaseView
     */
    private $baseView;
    /**
     * @var User
     */
    private $user;

    public function __construct(BaseView $baseView, Model $model, User $user,
                                ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $model->registerModel($this, 'logoutButton');

        $this->baseView = $baseView;
        $this->user =$user;
    }

    /**
     * @return bool
     */
    public function isAuthenticatingUser() {
        return isset($this->variables['logoutButton']);
    }

    public function setLoginSucceeded() {
        $this->setVariable('status', 'Inloggning lyckades');
    }

    public function setLoginSucceededRemembered() {
        $this->setVariable('status', 'Inloggning lyckades via cookies');
    }

    public function onRender() {
        $this->baseView->setTitle('Inloggad');

        $this->setVariable('username', $this->user->getUsername());
    }
}
