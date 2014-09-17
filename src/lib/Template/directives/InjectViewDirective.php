<?php

namespace Template\directives;

require_once('Directive.php');

use Di\Injector;
use Template\View;

class InjectViewDirective extends InlineDirective {
    /**
     * @var Injector
     */
    private $injector;

    public function __construct(Injector $injector) {
        $this->injector = $injector;
    }

    /**
     * @param View $view       The View this directive is rendered in.
     * @param array $arguments All arguments specified in the template.
     * @throws \InvalidArgumentException If more or less than one argument specified.
     * @return string Return a rendered version of this directive.
     */
    function render(View $view, array $arguments) {
        if (count($arguments) !== 1) {
            throw new \InvalidArgumentException('Exactly one view name must be specified');
        }

        $injectedView = $this->injector->get($arguments[0]);

        return $injectedView->render();
    }
}
