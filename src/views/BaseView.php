<?php

namespace views;

require_once('src/loginSystem.php');

use Template\View;

class BaseView extends View {
    protected $template = 'base.html';

    public function setTitle($title) {
        $this->setVariable('title', $title);
    }
}
