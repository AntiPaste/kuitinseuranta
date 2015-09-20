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
					<li><a href="/">Etusivu</a></li>
					<li class="active"><a href="/list_receipts.php">Kuitit</a></li>
					<li><a href="/list_categories.php">Kategoriat</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="container">
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
				<tr>
					<td><a href="/view_receipt.php">123</a></td>
					<td>UniCafe</td>
					<td>18.9.2015</td>
					<td>2.60€</td>
				</tr>
				<tr>
					<td><a href="/view_receipt.php">124</a></td>
					<td>UniCafe</td>
					<td>19.9.2015</td>
					<td>2.60€</td>
				</tr>
				<tr>
					<td><a href="/view_receipt.php">125</a></td>
					<td>UniCafe</td>
					<td>20.9.2015</td>
					<td>2.60€</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>