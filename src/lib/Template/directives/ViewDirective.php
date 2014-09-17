<?php

namespace Template\directives;

use Template\View;

require_once('Directive.php');

class ViewDirective extends InlineDirective {

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

        return $view->getView($arguments[0])->render();
    }
}
