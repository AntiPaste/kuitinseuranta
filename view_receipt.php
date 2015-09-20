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
		<div id="names" class="pull-left">
			<div class="text-info">Kuitin ID:</div>
			<div class="text-info">Ostotapahtuman sijainti:</div>
			<div class="text-info">Ostotapahtuman päivämäärä:</div>
			<div class="text-info">Ostosten summa:</div>
		</div>
		
		<div id="data" class="pull-left" style="margin-left: 20px;">
			<div>123</div>
			<div>UniCafe</div>
			<div>18.9.2015 12:00</div> 
			<div>2.60€</div>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="container" style="margin-top: 20px;">
			<a class="btn btn-warning" href="/edit_receipt.php">Muokkaa tietoja</a>
			<a class="btn btn-danger" href="#">Poista kuitti</a>
		</div>
	</div>
</body>
</html>