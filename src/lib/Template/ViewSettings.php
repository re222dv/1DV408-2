<?php

namespace Template;

require_once('directives/Condition.php');
require_once('directives/View.php');

class ViewSettings {
    /**
     * @var BlockDirective[] An assoc array with name => Directive of
     *                       all registered block directives.
     */
    public $blockDirectives;
    /**
     * @var InlineDirective[] An assoc array with name => Directive of
     *                        all registered inline directives.
     */
    public $inlineDirectives;

    public $templatePath = 'templates/';

    public function __construct() {
        $this->blockDirectives = [
            'if' => new directives\Condition(),
        ];

        $this->inlineDirectives = [
            'view' => new directives\View(),
        ];
    }
}
