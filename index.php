<?php

use controllers\LoginController;
use views\BaseView;

require_once('src/loginSystem.php');

$injector = new \Di\Injector();
$injector->bindToInstance('Di\Injector', $injector);
$injector->get('Template\ViewSettings')->templatePath = 'src/templates/';

$baseView = $injector->get(BaseView::class);
$loginController = $injector->get(LoginController::class);

$baseView->setView('content', $loginController->render());

echo $baseView->render();
