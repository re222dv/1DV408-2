<?php

namespace View;

require_once('src/lib/Template/View.php');
require_once('src/lib/Template/ViewSettings.php');
require_once('src/views/DateView.php');

use Template\View;
use Template\ViewSettings;

class BaseView extends View {
    protected $template = 'base.html';

    public function __construct(ViewSettings $settings) {
        parent::__construct($settings);

        $this->views = [
            'date' => new DateView($settings),
        ];
    }
}
