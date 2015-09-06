<?php

require_once 'config.php';

echo 'PHP-tuki: <span style="color: green;">on</span><br />';
echo 'MySQL yhteys: ';

$db = new MySQLi(
	$config['database']['host'],
	$config['database']['username'],
	$config['database']['password'],
	$config['database']['database'],
);

if ($db->connect_errno) {
	echo '<span style="color: red;">ei</span>';
} else {
	echo '<span style="color: green;">on</span>';
}
