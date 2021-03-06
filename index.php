<?php

require_once('src/loginSystem.php');

$injector = new \Di\Injector();
$injector->bindToInstance('Di\Injector', $injector);
$injector->get('Template\ViewSettings')->templatePath = 'src/templates/';

$baseView = $injector->get('views\BaseView');
$loginController = $injector->get('controllers\LoginController');

$baseView->setView('content', $loginController->render());

echo $baseView->render();
