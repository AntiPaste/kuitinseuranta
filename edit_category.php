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
$categoryClass = new Category($db);

if (!$userClass->isLoggedIn()) {
	$alertClass->addAlert('Sinun täytyy olla kirjautuneen sisään muokataksesi kategorioita', 'error');
	$alertClass->redirect('/login.php');
}

$user = $userClass->getCurrentUser();

if (!empty($_POST)) {
	if (empty($_POST['id'])) $alertClass->addAlert('Kategorian tunnus oli tyhjä', 'error');
	if (empty($_POST['name'])) $alertClass->addAlert('Kategorian nimi oli tyhjä', 'error');
	if (!is_numeric($_POST['id'])) $alertClass->addAlert('Virheellinen kategorian tunnus', 'error');
	
	if ($alertClass->hasErrors()) $alertClass->redirect('/list_categories.php');
	
	$category = $categoryClass->getCategory($_POST['id']);
	if ($category == null) {
		$alertClass->addAlert('Kategoriaa ei löytynyt', 'error');
		$alertClass->redirect('/list_categories.php');
	}
	
	if ($category['userID'] !== $user['id']) {
		$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kategoriaan', 'error');
		$alertClass->redirect('/list_categories.php');
	}
	
	$categoryClass->updateCategory($_POST['id'], htmlspecialchars($_POST['name']));
	$alertClass->addAlert('Kategorian päivittäminen onnistui!', 'success');
	$alertClass->redirect("/view_category.php?id={$_POST['id']}");
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$alertClass->addAlert('Kategorian ID oli tyhjä', 'error');
	$alertClass->redirect('/list_categories.php');
}

$category = $categoryClass->getCategory($_GET['id']);

if ($category === null) {
	$alertClass->addAlert('Kategoriaa ei löytynyt', 'error');
	$alertClass->redirect('/list_categories.php');
}

if ($category['userID'] !== $user['id']) {
	$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kategoriaan', 'error');
	$alertClass->redirect('/list_categories.php');
}

require_once 'header.php';

?>

		<div>
			<div class="form-group">
				<label>ID</label>
				<input type="text" class="form-control" name="id" value="<?= $category['id'] ?>" disabled="disabled" />
			</div>
			
			<div class="form-group">
				<label>Nimi</label>
				<input type="text" class="form-control" name="name" value="<?= $category['name'] ?>" />
			</div>
		</div>
		
		<div class="container" style="margin-top: 20px;">
			<input type="submit" class="btn btn-success" value="Tallenna" />
			<a class="btn btn-warning" href="/view_category.php?id=<?= $category['id'] ?>">Peruuta</a>
		</div>

<?php require_once 'footer.php'; ?>