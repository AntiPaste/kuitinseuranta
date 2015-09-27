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

$user = $userClass->getCurrentUser();

$categoryClass = new Category($db);
$categories = $categoryClass->getAllCategories($user['id']);

$active = 'categories';
require_once 'header.php';

?>

		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nimi</th>
					<th>Kokonaissumma</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($categories as $category): ?>
				<tr>
					<td><a href="/view_category.php?id=<?= $category['id'] ?>"><?= $category['id'] ?></a></td>
					<td><?= $category['name'] ?></td>
					<td><?= $category['total_sum'] ?>€</td>
					<td><a href="/view_category.php?id=<?= $category['id'] ?>">Katsele</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

<?php require_once 'footer.php'; ?>