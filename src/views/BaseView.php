<?php

namespace View;

require_once('src/lib/Template/View.php');

use Template\View;

class BaseView extends View {
    protected $template = 'base.html';
}
