<?php

require_once './config.php';
require_once './lib/alert.class.php';
require_once './lib/user.class.php';

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

if (!empty($_POST)) {
	if (empty($_POST['username'])) $alertClass->addAlert('Käyttäjätunnus oli tyhjä', 'error');
	if (empty($_POST['password'])) $alertClass->addAlert('Salasana oli tyhjä', 'error');
	
	if ($alertClass->hasErrors()) $alertClass->redirect('/login.php');
	
	$result = $userClass->authenticate($_POST['username'], $_POST['password']);
	if ($result === null) {
		$alertClass->addAlert('Väärä käyttäjätunnus tai salasana', 'error');
	}
	
	$alertClass->addAlert('Kirjautuminen onnistui!', 'success');
	$alertClass->redirect('/index.php');
}

require_once 'header.php';

?>

		<h3 style="margin-bottom: 20px;">Kirjaudu sisään</h3>
		
		<form class="container" action="" method="post">
			<div class="form-group">
				<label>Username</label>
				<input type="text" class="form-control" name="username" placeholder="Username" />
			</div>
			
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password" />
			</div>
			
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="Kirjaudu" />
			</div>
		</form>

<?php require_once 'footer.php'; ?>