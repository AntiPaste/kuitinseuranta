<?php

require_once 'config.php';
require_once './lib/alert.class.php';
require_once './lib/user.class.php';

$db = new MySQLi(
	$config['database']['host'],
	$config['database']['username'],
	$config['database']['password'],
	$config['database']['database']
);

$headerLoginCheck = new User($db);
$alertClass = new Alert();

$headerAlerts = $alertClass->getAlerts();
$alertClass->clearAlerts();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	
	<link href="/css/bootstrap.min.css" rel="stylesheet" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="/">Kuittiseuranta</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li<?= ($active === 'index' ? ' class="active"' : '') ?>><a href="/">Etusivu</a></li>
					<?php if ($headerLoginCheck->isLoggedIn()): ?>
					<li<?= ($active === 'receipts' ? ' class="active"' : '') ?>><a href="/list_receipts.php">Kuitit</a></li>
					<li<?= ($active === 'categories' ? ' class="active"' : '') ?>><a href="/list_categories.php">Kategoriat</a></li>
					<?php endif; ?>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<?php if ($headerLoginCheck->isLoggedIn()): ?>
					<li><a href="#"><?= $headerLoginCheck->getCurrentUser()['username'] ?></a></li>
					<li><a href="/logout.php">Kirjaudu ulos</a></li>
					<?php else: ?>
					<li><a href="/login.php">Kirjaudu sisään</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
	
	<?php if (!empty($headerAlerts)): ?>
	<div class="container">
		<?php foreach ($headerAlerts as $alert): ?>
		<div class="alert alert-<?= ($alert['type'] === 'error' ? 'danger' : 'success') ?>">
			<?= $alert['message'] ?>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	
	<div class="container">