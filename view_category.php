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
	$alertClass->addAlert('Sinun täytyy olla kirjautuneen sisään katsellaksesi kategorioita', 'error');
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

require_once 'header.php';

?>

		<div id="names" class="pull-left">
			<div class="text-info">Kategorian ID:</div>
			<div class="text-info">Kategorian nimi:</div>
			<div class="text-info">Kuittien kokonaissumma:</div>
		</div>
		
		<div id="data" class="pull-left" style="margin-left: 20px;">
			<div><?= $category['id'] ?></div>
			<div><?= $category['name'] ?></div>
			<div><?= $category['total_sum'] ?></div> 
		</div>
		
		<div class="clearfix"></div>
		
		<div class="container" style="margin-top: 20px;">
			<a class="btn btn-warning" href="/edit_category.php?id=<?= $category['id'] ?>">Muokkaa kategoriaa</a>
			<a class="btn btn-danger" href="/remove_category.php?id=<?= $category['id'] ?>">Poista kategoria</a>
		</div>

<?php require_once 'footer.php'; ?>