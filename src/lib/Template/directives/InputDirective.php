<?php

namespace Template\directives;

use Template\View;

require_once('Directive.php');

class InputDirective extends InlineDirective {
    private $registeredModels = [];

    function registerInput(View $view, $modelName) {
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
        $inputName = $arguments[0];

        if (!in_array($inputName, $this->registeredModels)) {
            throw new \Exception("InputDirective $inputName have not been registered");
        }

        if (isset($_POST[$inputName])) {
            if (in_array('checkbox', $flags) && $_POST[$inputName] === 'on') {
                return 'name="'.$inputName.'" checked';
            }
            return 'name="'.$inputName.'" value="{{ '.$inputName.' }}"';
        }

        return 'name="'.$inputName.'"';
    }
}
