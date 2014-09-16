<?php

namespace services;

require_once('src/loginSystem.php');

class SessionService {
    private static $clientIdentifierKey = 'SessionService::clientIdentifier';
    private $clientIdentifier;

    public function __construct() {
        session_start();
    }

    private function checkIdentifier() {
        if ($this->clientIdentifier == null) {
            throw new \Exception('A client client identifier');
        }

        if (isset($_SESSION[self::$clientIdentifierKey])) {
            if ($_SESSION[self::$clientIdentifierKey] !== $this->clientIdentifier) {
                session_destroy();
                session_start();
            }
        } else {
            $_SESSION[self::$clientIdentifierKey] = $this->clientIdentifier;
        }
    }

    public function setClientIdentifier($identifier) {
        $this->clientIdentifier = $identifier;
    }

    public function has($key) {
        $this->checkIdentifier();

        return isset($_SESSION[$key]);
    }

    public function get($key) {
        $this->checkIdentifier();

        if ($this->has($key)) {
            return $_SESSION[$key];
        }
        return null;
    }

    public function set($key, $value) {
        $this->checkIdentifier();

        $_SESSION[$key] = $value;
    }

    public function remove($key) {
        $this->checkIdentifier();

        unset($_SESSION[$key]);
    }
}
