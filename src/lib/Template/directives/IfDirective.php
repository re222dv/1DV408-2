<?php

namespace Template\directives;

require_once('Directive.php');

use Template\View;

class IfDirective extends BlockDirective {

    /**
     * @param View $view       The View this directive is rendered in.
     * @param array $arguments All arguments specified in the template.
     * @param string $body     The body of this template.
     * @throws \InvalidArgumentException If more or less than one argument specified.
     * @return string Return a rendered version of this directive.
     */
    function render(View $view, array $arguments, $body) {
        if (count($arguments) !== 1) {
            throw new \InvalidArgumentException('Exactly one variable name must be specified');
        }

        if (substr($arguments[0], 0, 1) === '!') {
            $condition = !$view->getVariable(substr($arguments[0], 1));
        } else {
            $condition = $view->getVariable($arguments[0]);
        }

        if ($condition) {
            return $body;
        } else {
            return '';
        }
    }
}
