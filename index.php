<?php

require_once('src/loginSystem.php');

$injector = new \Di\Injector();
$injector->bindToInstance('Di\Injector', $injector);
$injector->get('Template\ViewSettings')->templatePath = 'src/templates/';

$baseView = $injector->get('\View\BaseView');
$loginView = $injector->get('\View\LoginView');

$baseView->setView('content', $loginView);

echo $baseView->render();
