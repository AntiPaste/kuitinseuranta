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
	$alertClass->addAlert('Sinun täytyy olla kirjautuneen sisään katsellaksesi kuitteja', 'error');
	$alertClass->redirect('/login.php');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$alertClass->addAlert('Kuitin ID oli tyhjä');
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
	$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kuittiin');
	$alertClass->redirect('/list_receipts.php');
}

require_once 'header.php';

?>

		<div id="names" class="pull-left">
			<div class="text-info">Kuitin ID:</div>
			<div class="text-info">Ostotapahtuman sijainti:</div>
			<div class="text-info">Ostotapahtuman päivämäärä:</div>
			<div class="text-info">Ostosten summa:</div>
		</div>
		
		<div id="data" class="pull-left" style="margin-left: 20px;">
			<div><?= $receipt['id'] ?></div>
			<div><?= $receipt['location'] ?></div>
			<div><?= $receipt['date'] ?></div> 
			<div><?= $receipt['sum'] ?>€</div>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="container" style="margin-top: 20px;">
			<a class="btn btn-warning" href="/edit_receipt.php?id=<?= $receipt['id'] ?>">Muokkaa tietoja</a>
			<a class="btn btn-danger" href="/remove_receipt.php?id=<?= $receipt['id'] ?>">Poista kuitti</a>
		</div>

<?php require_once 'footer.php'; ?>