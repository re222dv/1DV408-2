<?php

require_once('src/lib/Template/ViewSettings.php');
require_once('src/views/BaseView.php');
require_once('src/views/LoginView.php');

$viewSettings = new \Template\ViewSettings();
$viewSettings->templatePath = 'src/templates/';

$baseView = new \View\BaseView($viewSettings);
$loginView = new \View\LoginView($viewSettings);

$baseView->setView('content', $loginView);

echo $baseView->render();
