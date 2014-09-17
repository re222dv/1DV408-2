<?php

namespace Template;

require_once('directives/IfDirective.php');
require_once('directives/InjectViewDirective.php');
require_once('directives/InputDirective.php');
require_once('directives/ViewDirective.php');

class ViewSettings {
    /**
     * @var directives\BlockDirective[] An assoc array with name => Directive of
     *                                  all registered block directives.
     */
    public $blockDirectives;
    /**
     * @var directives\InlineDirective[] An assoc array with name => Directive of
     *                                   all registered inline directives.
     */
    public $inlineDirectives;

    public $templatePath = 'templates/';

    public function __construct(directives\IfDirective $if,
                                directives\InjectViewDirective $injectView,
                                directives\InputDirective $input,
                                directives\ViewDirective $view) {
        $this->blockDirectives = [
            'if' => $if,
        ];

        $this->inlineDirectives = [
            'injectView' => $injectView,
            'input' => $input,
            'view' => $view,
        ];
    }
}
