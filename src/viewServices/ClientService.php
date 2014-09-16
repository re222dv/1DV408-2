<?php

namespace services;

require_once('src/loginSystem.php');

class ClientService {

    public function getClientIdentifier() {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}
