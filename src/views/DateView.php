<?php

namespace views;

require_once('src/loginSystem.php');

use Template\View;
use Template\ViewSettings;

class DateView extends View {
    private static $days = [
        'Söndag', 'Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag'
    ];
    private static $months = [
        'Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli',
        'Augusti', 'September', 'Oktober', 'November', 'December'
    ];

    protected $template = 'date.html';

    public function __construct(ViewSettings $settings) {
        parent::__construct($settings);

        $this->variables = [
            'day' => self::$days[date('w')],
            'dayNumber' => date('j'),
            'month' => self::$months[date('n') - 1],
            'year' => date('o'),
            'time' => date('H:i:s'),
        ];
    }
}
