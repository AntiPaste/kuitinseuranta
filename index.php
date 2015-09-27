<?php

require_once './config.php';

$db = new MySQLi(
	$config['database']['host'],
	$config['database']['username'],
	$config['database']['password'],
	$config['database']['database']
);

if ($db->connect_errno) {
	die('Ei tietokantayhteyttä.');
}

$active = 'index';
require_once 'header.php';

?>

		<div class="jumbotron">
			<h1>Kuittiseuranta</h1>
			<p>Tähän jotain sepostusta käyttötarkoituksista jne.</p>
		</div>

<?php require_once 'footer.php'; ?>