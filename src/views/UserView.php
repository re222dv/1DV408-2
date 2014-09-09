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
     * @var User
     */
    private $user;

    public function __construct(Model $model, User $user, ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $model->registerModel($this, 'logoutButton');

        $this->user =$user;
    }

    /**
     * @return bool
     */
    public function isAuthenticatingUser() {
        return isset($this->variables['logoutButton']);
    }

    public function onRender() {
        $this->setVariable('username', $this->user->getUsername());
    }
}
