<?php

require_once './config.php';
require_once './lib/alert.class.php';
require_once './lib/user.class.php';
require_once './lib/category.class.php';

$db = new MySQLi(
	$config['database']['host'],
	$config['database']['username'],
	$config['database']['password'],
	$config['database']['database']
);

if ($db->connect_errno) {
	die('Ei tietokantayhteyttä.');
}

$alertClass = new Alert();
$userClass = new User($db);

if (!$userClass->isLoggedIn()) {
	$alertClass->addAlert('Sinun täytyy olla kirjautuneen sisään poistaaksesi kategorioita', 'error');
	$alertClass->redirect('/login.php');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$alertClass->addAlert('Kategorian ID oli tyhjä', 'error');
	$alertClass->redirect('/list_categories.php');
}

$user = $userClass->getCurrentUser();

$categoryClass = new Category($db);
$category = $categoryClass->getCategory($_GET['id']);

if ($category === null) {
	$alertClass->addAlert('Kategoriaa ei löytynyt');
	$alertClass->redirect('/list_categories.php');
}

if ($category['userID'] !== $user['id']) {
	$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kategoriaan', 'error');
	$alertClass->redirect('/list_categories.php');
}

$categoryClass->removeCategory($_GET['id']);
header('Location: /list_categories.php');