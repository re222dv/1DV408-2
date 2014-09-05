<?php

namespace Template;

/**
 * Matches variable insertion points.
 *
 * A variable insertion point starts with {{ and ends with }},
 * between them is a variable name that starts with a lower case
 * and may contains lower case, upper case and numbers. It may be
 * surrounded by a single space.
 */
const VARIABLE_REGEX = '{{{(?: )?([a-z][a-zA-Z0-9]*?)(?: )?}}}';
/**
 * Matches sub view insertion points.
 *
 * A sub view insertion point follows the schema {% view $name %}
 * where $name is the name of the sub view.
 */
const SUB_VIEW_REGEX = '{{%(?: )?view ([a-z][a-zA-Z0-9]*?)(?: )?%}}';

/**
 * This is a base class for views.
 *
 * @package Template
 */
abstract class View {

    /**
     * @var string Path to the template relative to the templates folder.
     */
    protected $template;
    /**
     * @var mixed[] An assoc array with name => variable of all variables
     *              that should be inserted in the output.
     */
    protected $variables = [];
    /**
     * @var View[] An assoc array with name => View of all children views
     *             that should be inserted in the output.
     */
    protected $views = [];

    public function setVariable($name, $value) {
        $this->variables[$name] = $value;
    }

    public function setView($name, View $view) {
        $this->views[$name] = $view;
    }

    /**
     * @returns string Rendered HTML.
     * @throws \Exception If the template file doesn't exist.
     */
    public function render() {
        if(!is_file('templates/'.$this->template)) {
            throw new \Exception("Template file '$this->template' don't exists");
        }
        $output = file_get_contents('templates/'.$this->template);

        preg_match_all(SUB_VIEW_REGEX, $output, $subViewMatches, PREG_SET_ORDER);

        foreach($subViewMatches as $match) {
            $output = str_replace($match[0], $this->views[$match[1]]->render(), $output);
        }

        preg_match_all(VARIABLE_REGEX, $output, $variableMatches, PREG_SET_ORDER);

        foreach($variableMatches as $match) {
            $variable = $this->variables[$match[1]];
            $variable = str_replace('<', '&lt;', $variable);
            $variable = str_replace('>', '&gt;', $variable);
            $variable = str_replace('"', '&quot;', $variable);
            $output = str_replace($match[0], $variable, $output);
        }

        return $output;
    }
}
