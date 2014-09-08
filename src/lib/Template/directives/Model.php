<?php

namespace Template\directives;

use Template\View;

require_once('Directive.php');

class Model extends InlineDirective {
    private $registeredModels = [];

    function registerModel(View $view, $modelName) {
        $this->registeredModels[] = $modelName;

        if (isset($_POST[$modelName])) {
            $view->setVariable($modelName, $_POST[$modelName]);
        }
    }

    function render(View $view, array $arguments) {
        $flags = [];

        if (count($arguments) === 2) {
            if ($arguments[1] !== 'checkbox') {
                throw new \InvalidArgumentException("Unsupported flag '$arguments[1]'");
            }

            $flags[] = $arguments[1];
        } elseif (count($arguments) !== 1) {
            throw new \InvalidArgumentException('Exactly one variable name must be specified,'
                .'with one optional flag');
        }
        $modelName = $arguments[0];

        if (!in_array($modelName, $this->registeredModels)) {
            throw new \Exception("Model $modelName have not been registered");
        }

        if (isset($_POST[$modelName])) {
            if (in_array('checkbox', $flags) && $_POST[$modelName] === 'on') {
                return 'name="'.$modelName.'" checked';
            }
            return 'name="'.$modelName.'" value="{{ '.$modelName.' }}"';
        }

        return 'name="'.$modelName.'"';
    }
}
