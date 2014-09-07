<?php

require_once('src/lib/Di/di.php');
require_once('src/lib/Template/template.php');
require_once('src/views/BaseView.php');
require_once('src/views/LoginView.php');

$injector = new \Di\Injector();
$injector->get('Template\ViewSettings')->templatePath = 'src/templates/';

$baseView = $injector->get('\View\BaseView');
$loginView = $injector->get('\View\LoginView');

$baseView->setView('content', $loginView);

echo $baseView->render();
