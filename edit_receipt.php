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
					<li><a href="/list_categories.php">Kategoriat</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="container">
		<div>
			<div class="form-group">
				<label>ID</label>
				<input type="text" class="form-control" placeholder="123" disabled="disabled" />
			</div>
			
			<div class="form-group">
				<label>Sijainti</label>
				<input type="text" class="form-control" placeholder="UniCafe" />
			</div>
			
			<div class="form-group">
				<label>Päivämäärä</label>
				<input type="text" class="form-control" placeholder="18.9.2015" />
			</div>
			
			<div class="form-group">
				<label>Summa</label>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="2.60" />
					<span class="input-group-addon">€</span>
				</div>
			</div>
		</div>
		
		<div class="container" style="margin-top: 20px;">
			<a class="btn btn-success" href="#">Tallenna</a>
			<a class="btn btn-warning" href="#">Peruuta</a>
		</div>
	</div>
</body>
</html>