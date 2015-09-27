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

$user = $userClass->getCurrentUser();

$receiptClass = new Receipt($db);
$receipts = $receiptClass->getAllReceipts($user['id']);

$active = 'receipts';
require_once 'header.php';

?>

		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Sijainti</th>
					<th>Päivämäärä</th>
					<th>Summa</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($receipts as $receipt): ?>
				<tr>
					<td>
						<a href="/view_receipt.php?id=<?= $receipt['id'] ?>"><?= $receipt['id'] ?></a>
					</td>
					
					<td><?= $receipt['location'] ?></td>
					<td><?= $receipt['date'] ?></td>
					<td><?= $receipt['sum'] ?>€</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

<?php require_once 'footer.php'; ?>