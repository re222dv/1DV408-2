<?php

namespace services;

require_once('src/loginSystem.php');

class CookieService {
    private $fileService;

    public function __construct(FileService $fileService) {
        $this->fileService = $fileService;
    }

    public function has($key) {
        return isset($_COOKIE[$key]);
    }

    public function get($key) {
        if ($this->fileService->get() < time()) {
            $this->remove($key);
        }
        if ($this->has($key)) {
            return $_COOKIE[$key];
        }
        return null;
    }

    public function set($key, $value) {
        $time = strtotime('+1 minutes');
        $this->fileService->set($time);
        setcookie($key, $value, $time);
        $_COOKIE[$key] = $value;
    }

    public function remove($key) {
        setcookie($key, null, time() - 1);
        if ($this->has($key)) {
            unset($_COOKIE[$key]);
        }
    }
}
