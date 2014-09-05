<?php

namespace Template;

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
     * @var array[string]mixed All variables that should be inserted in the output.
     */
    protected $variables = [];
    /**
     * @var array[string]View All children views that should be inserted in the output.
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
     */
    public function render() {

    }
}
