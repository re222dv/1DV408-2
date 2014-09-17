<?php

namespace views;

require_once('src/loginSystem.php');

use models\User;
use Template\directives\InputDirective;
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

    public function __construct(BaseView $baseView, InputDirective $inputDirective, User $user,
                                ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $inputDirective->registerInput($this, 'logoutButton');

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

    public function setLoginSucceededRemembering() {
        $this->setVariable('status', 'Inloggning lyckades och vi kommer ihåg dig nästa gång');
    }

    public function setLoginSucceededRemembered() {
        $this->setVariable('status', 'Inloggning lyckades via cookies');
    }

    public function onRender() {
        $this->baseView->setTitle('Inloggad');

        $this->setVariable('username', $this->user->getUsername());
    }
}
