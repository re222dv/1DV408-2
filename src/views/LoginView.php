<?php

namespace views;

require_once('src/loginSystem.php');

use models\User;
use services\CookieService;
use Template\directives\Model;
use Template\View;
use Template\ViewSettings;

class LoginView extends View {
    private static $cookieKey = 'LoginView::username';
    protected $template = 'login.html';
    /**
     * @var BaseView
     */
    private $baseView;
    /**
     * @var CookieService
     */
    private $cookie;
    /**
     * @var User
     */
    private $user;

    public function __construct(BaseView $baseView, CookieService $cookie, Model $model, User $user,
                                ViewSettings $viewSettings) {
        parent::__construct($viewSettings);

        $model->registerModel($this, 'username');
        $model->registerModel($this, 'password');
        $model->registerModel($this, 'rememberMe');
        $model->registerModel($this, 'loginButton');

        $this->baseView = $baseView;
        $this->cookie = $cookie;
        $this->user = $user;
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
     * @return string
     */
    public function getRememberedKey() {
        return $this->cookie->get(self::$cookieKey);
    }

    public function forgetUser() {
        $this->cookie->remove(self::$cookieKey);
    }

    /**
     * @return bool
     */
    public function isAuthenticatingUser() {
        return isset($this->variables['loginButton']);
    }

    /**
     * @return bool
     */
    public function isUserRemembered() {
        return $this->cookie->has(self::$cookieKey);
    }

    public function rememberUser() {
        $this->cookie->set(self::$cookieKey, $this->user->getKey());
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

    public function setLoginErrorRemembered() {
        $this->setError('Felaktig information i cookie');
    }

    public function setHaveLoggedOut() {
        $this->setVariable('haveLoggedOut', true);
    }

    public function shouldUserBeRemembered() {
        return $this->getVariable('rememberMe') === 'on';
    }

    public function onRender() {
        $this->baseView->setTitle('Inte inloggad');

        if ($this->isAuthenticatingUser()) {
            $username = $this->getUsername();
            $password = $this->getPassword();
            if (empty($username)) {
                $this->setError('Användarnamn saknas');
            } elseif (empty($password)) {
                $this->setError('Lösenord saknas');
            }
        }
    }
}
