<?php

namespace Template;

require_once('directives/Condition.php');
require_once('directives/InjectView.php');
require_once('directives/Model.php');
require_once('directives/View.php');

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

    public function __construct(directives\Condition $condition, directives\InjectView $injectView,
                                directives\Model $model, directives\View $view) {
        $this->blockDirectives = [
            'if' => $condition,
        ];

        $this->inlineDirectives = [
            'injectView' => $injectView,
            'model' => $model,
            'view' => $view,
        ];
    }
}
