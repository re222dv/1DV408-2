<?php

namespace Template\directives;

use Template\View;

/**
 * A block directive should be used for functions that require an inline
 * template.
 *
 * A block directive has a header and a body. The header contains the name
 * of the directive and an optional list of space separated arguments.
 * The header is ended with a colon (:) and after that the body starts
 * and ends at the closing tag (?}).
 *
 * Example:
 *  {? if loggedIn:
 *     Hello, {{ userName }}!
 *  ?}
 */
abstract class BlockDirective {
    /**
     * @param View $view       The View this directive is rendered in.
     * @param array $arguments All arguments specified in the template.
     * @param string $body     The body of this template.
     * @return string Return a rendered version of this directive.
     */
    abstract function render(View $view, array $arguments, $body);
}

/**
 * An inline directive should be used for functions that does not require
 * an inline template.
 *
 * An inline directive does only have a header that contains the name
 * of the directive and an optional list of space separated arguments.
 *
 * Example:
 *  {% view content %}
 */
abstract class InlineDirective {
    /**
     * @param View $view       The View this directive is rendered in.
     * @param array $arguments All arguments specified in the template.
     * @return string Return a rendered version of this directive.
     */
    abstract function render(View $view, array $arguments);
}
