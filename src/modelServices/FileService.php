<?php

namespace services;

require_once('src/loginSystem.php');

class FileService {
    private static $fileName = 'FileService';

    public function get() {
        if (file_exists(self::$fileName)) {
            return file_get_contents(self::$fileName);
        }

        return null;
    }

    public function set($value) {
        file_put_contents(self::$fileName, $value);
    }
}
