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
$receiptClass = new Receipt($db);

if (!$userClass->isLoggedIn()) {
	$alertClass->addAlert('Sinun täytyy olla kirjautuneen sisään muokataksesi kuitteja', 'error');
	$alertClass->redirect('/login.php');
}

$user = $userClass->getCurrentUser();

if (!empty($_POST)) {
	if (empty($_POST['id'])) $alertClass->addAlert('Kuitin tunnus oli tyhjä', 'error');
	if (empty($_POST['location'])) $alertClass->addAlert('Kuitin sijainti oli tyhjä', 'error');
	if (empty($_POST['date'])) $alertClass->addAlert('Kuitin päivämäärä oli tyhjä', 'error');
	if (empty($_POST['sum'])) $alertClass->addAlert('Kuitin summa oli tyhjä', 'error');
	
	if (!is_numeric($_POST['id'])) $alertClass->addAlert('Virheellinen kuitin tunnus', 'error');
	if (!is_float($_POST['sum'])) $alertClass->addAlert('Virheellinen kuitin summa', 'error');
	
	if ($alertClass->hasErrors()) $alertClass->redirect('/list_receipts.php');
	
	$receipt = $receiptClass->getReceipt($_POST['id']);
	if ($receipt == null) {
		$alertClass->addAlert('Kuittia ei löytynyt', 'error');
		$alertClass->redirect('/list_receipts.php');
	}
	
	if ($receipt['userID'] !== $user['id']) {
		$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kuittiin', 'error');
		$alertClass->redirect('/list_receipts.php');
	}
	
	$receipt->updateReceipt($_POST['id'], htmlspecialchars($_POST['location']), htmlspecialchars($_POST['date']), $_POST['sum']);
	$alertClass->addAlert('Kuitin päivittäminen onnistui!', 'success');
	$alertClass->redirect("/view_receipt.php?id={$_POST['id']}");
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	$alertClass->addAlert('Kuitin ID oli tyhjä', 'error');
	$alertClass->redirect('/list_receipts.php');
}


$receipt = $receiptClass->getReceipt($_GET['id']);

if ($receipt === null) {
	$alertClass->addAlert('Kuittia ei löytynyt');
	$alertClass->redirect('/list_receipts.php');
}

if ($receipt['userID'] !== $user['id']) {
	$alertClass->addAlert('Sinulla ei ole oikeuksia tähän kuittiin', 'error');
	$alertClass->redirect('/list_receipts.php');
}

require_once 'header.php';

?>

		<form action="" method="post">
			<div>
				<div class="form-group">
					<label>ID</label>
					<input type="text" class="form-control" name="id" value="<?= $receipt['id'] ?>" disabled="disabled" />
				</div>
				
				<div class="form-group">
					<label>Sijainti</label>
					<input type="text" class="form-control" name="location" value="<?= $receipt['location'] ?>" />
				</div>
				
				<div class="form-group">
					<label>Päivämäärä</label>
					<input type="text" class="form-control" name="date" value="<?= $receipt['date'] ?>" />
				</div>
				
				<div class="form-group">
					<label>Summa</label>
					<div class="input-group">
						<input type="text" class="form-control" name="sum" value="<?= $receipt['sum'] ?>" />
						<span class="input-group-addon">€</span>
					</div>
				</div>
			</div>
			
			<div class="container" style="margin-top: 20px;">
				<input type="submit" class="btn btn-success" value="Tallenna" />
				<a class="btn btn-warning" href="/view_receipt.php?id=<?= $receipt['id'] ?>">Peruuta</a>
			</div>
		</form>

<?php require_once 'footer.php'; ?>