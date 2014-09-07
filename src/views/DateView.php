<?php

namespace View;

require_once('src/lib/Template/View.php');
require_once('src/lib/Template/ViewSettings.php');

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
            'day' => DateView::$days[date('w')],
            'dayNumber' => date('j'),
            'month' => DateView::$months[date('n') - 1],
            'year' => date('o'),
            'time' => date('H:i:s'),
        ];
    }
}
