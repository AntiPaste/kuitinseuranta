<?php

require_once './config.php';
require_once './lib/alert.class.php';
$alertClass = new Alert();

$alerts = $alertClass->getAlerts();

$_SESSION = array();
session_destroy();

session_start();
session_regenerate_id(true);

$alertClass->setAlerts($alerts);
$alertClass->addAlert('Uloskirjautuminen onnistui!', 'success');
$alertClass->redirect('/index.php');