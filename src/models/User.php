<?php

namespace models;

require_once('src/loginSystem.php');

use services\SessionService;

class User {
    private static $sessionKey = 'User::username';
    /**
     * @var SessionService
     */
    private $session;

    private $username = 'Admin';
    private $password = 'password';

    public function __construct(SessionService $session) {
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return bool True if the user is logged in
     */
    public function isLoggedIn() {
        return $this->session->has(self::$sessionKey);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function logIn($username, $password) {
        if ($username === $this->username and
            $password === $this->password) {
            $this->session->set(self::$sessionKey, $username);
            return true;
        }

        return false;
    }

    public function logOut() {
        $this->session->remove(self::$sessionKey);
    }
}
