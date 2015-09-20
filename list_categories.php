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
					<li><a href="/list_receipts.php">Kuitit</a></li>
					<li class="active"><a href="/list_categories.php">Kategoriat</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="container">
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
				<tr>
					<td><a href="/view_category.php">123</a></td>
					<td>Sekalaiset</td>
					<td>7.80€</td>
					<td><a href="/view_category.php">Katsele</a></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>