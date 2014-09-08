<?php

namespace models;

require_once('src/loginSystem.php');

class User {
    private $username = 'Admin';
    private $password = 'password';
    private $loggedIn = false;

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
        return $this->loggedIn;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function logIn($username, $password) {
        if ($username === $this->username &&
            $password === $this->password) {
            $this->loggedIn = true;
            return true;
        }

        return false;
    }
}
