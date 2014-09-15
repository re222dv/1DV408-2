<?php

namespace services;

require_once('src/loginSystem.php');

class CookieService {

    public function has($key) {
        return isset($_COOKIE[$key]);
    }

    public function get($key) {
        if ($this->has($key)) {
            return $_COOKIE[$key];
        }
        return null;
    }

    public function set($key, $value) {
        setcookie($key, $value, strtotime('+7 days'));
        $_COOKIE[$key] = $value;
    }

    public function remove($key) {
        setcookie($key, null, time() - 1);
        if ($this->has($key)) {
            unset($_COOKIE[$key]);
        }
    }
}