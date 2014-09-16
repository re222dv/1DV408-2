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
const VARIABLE_REGEX = '{{{ ?([a-z][a-zA-Z0-9]*?) ?}}}';

/**
 * Matches inline directives
 *
 * An inline directive does only have a header that contains the name
 * of the directive and an optional list of space separated arguments.
 *
 * Example:
 *  {% view content %}
 */
const INLINE_DIRECTIVE_REGEX = '/{% ?([a-z][a-zA-Z0-9]*)((?: [^ ]*)*?) ?%}/';

/**
 * Matches block directives
 *
 * A block directive a header and a body. The header contains the name
 * of the directive and an optional list of space separated arguments.
 * The header is ended with a colon (:) and after that the body starts
 * and ends at the closing tag (?}).
 *
 * Example:
 *  {? if loggedIn:
 *     Hello, {{ userName }}!
 *  ?}
 */
const BLOCK_DIRECTIVE_REGEX = '/({\? ?([a-z][a-zA-Z0-9]*)((?: ?[^ :]*)+) ?:)((?:(?!(?1)|(\?})).|(?R))*)\?}/s';

/**
 * This is a base class for views.
 *
 * @package Template
 */
abstract class View {

    private $settings;

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

    public function __construct(ViewSettings $settings) {
        $this->settings = $settings;
    }

    public function getVariable($name) {
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        }

        return null;
    }

    public function setVariable($name, $value) {
        $this->variables[$name] = $value;
    }

    public function getView($name) {
        return $this->views[$name];
    }

    public function setView($name, View $view) {
        $this->views[$name] = $view;
    }

    /**
     * Called on render before the template is actually rendered
     */
    public function onRender() {}

    /**
     * @returns string Rendered HTML.
     * @throws \Exception If the template file doesn't exist.
     */
    public function render() {
        $this->onRender();

        if (!is_file($this->settings->templatePath.$this->template)) {
            throw new \Exception("Template file '$this->template' don't exists");
        }
        $output = file_get_contents($this->settings->templatePath.$this->template);

        return $this->renderPartial($output);
    }

    /**
     * @param string $string
     * @return string[]
     */
    private function extractArguments($string) {
        $arguments = [];
        foreach (preg_split('/ +/', trim($string)) as $argument) {
            $arguments[] = $argument;
        }

        return $arguments;
    }

    /**
     * @param string $string A possibly unsafe string
     * @returns string A string that is safe inside HTML if double quotes are
     *                 used when placing in an attributes value.
     */
    private function htmlEscape($string) {
        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        $string = str_replace('"', '&quot;', $string);

        return $string;
    }

    /**
     * @param string $partial A part of a template.
     * @returns string A rendered version of that part.
     */
    private function renderPartial($partial) {

        preg_match_all(BLOCK_DIRECTIVE_REGEX, $partial, $blockDirectiveMatches, PREG_SET_ORDER);

        foreach ($blockDirectiveMatches as $match) {
            $name = $match[2];
            $arguments = $this->extractArguments($match[3]);
            $body = $match[4];

            $rendered = $this->settings->blockDirectives[$name]->render($this, $arguments, $body);
            $rendered = $this->renderPartial($rendered);

            $partial = str_replace($match[0], $rendered, $partial);
        }

        preg_match_all(INLINE_DIRECTIVE_REGEX, $partial, $inlineDirectiveMatches, PREG_SET_ORDER);

        foreach ($inlineDirectiveMatches as $match) {
            $name = $match[1];
            $arguments = $this->extractArguments($match[2]);

            $rendered = $this->settings->inlineDirectives[$name]->render($this, $arguments);

            $partial = str_replace($match[0], $rendered, $partial);
        }

        preg_match_all(VARIABLE_REGEX, $partial, $variableMatches, PREG_SET_ORDER);

        foreach ($variableMatches as $match) {
            $variable = $this->variables[$match[1]];
            $variable = $this->htmlEscape($variable);
            $partial = str_replace($match[0], $variable, $partial);
        }

        return $partial;
    }
}
