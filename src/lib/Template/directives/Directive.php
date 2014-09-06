<?php

namespace Template;

abstract class InlineDirective {
    /**
     * @param View $view The View this directive is rendered in.
     * @param array $arguments All arguments specified in the template.
     * @return string Return a rendered version of this directive.
     */
    abstract function render(View $view, array $arguments);
}

abstract class BlockDirective {
    /**
     * @param View $view The View this directive is rendered in.
     * @param array $arguments All arguments specified in the template.
     * @param string $body The body of this template.
     * @return string Return a rendered version of this directive.
     */
    abstract function render(View $view, array $arguments, $body);
}
