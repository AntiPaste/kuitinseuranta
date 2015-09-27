<?php

require_once './config.php';
require_once './lib/alert.class.php';
require_once './lib/user.class.php';
require_once './lib/receipt.class.php';

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
	$alertClass->addAlert('Sinun täytyy olla kirjautuneen sisään poistaaksesi kuitteja', 'error');
	$alertClass->redirect('/login.php');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$alertClass->addAlert('Kuitin ID oli tyhjä', 'error');
	$alertClass->redirect('/list_receipts.php');
}

$user = $userClass->getCurrentUser();

$receiptClass = new Receipt($db);
$receipt = $receiptClass->getReceipt($_GET['id']);

if ($receipt === null) {
	$alertClass->addAlert('Kuittia ei löytynyt');
	$alertClass->redirect('/list_receipts.php');
}

if ($receipt['userID'] !== $user['id']) {
	$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kuittiin', 'error');
	$alertClass->redirect('/list_receipts.php');
}

$receiptClass->removeReceipt($_GET['id']);
header('Location: /list_receipts.php');