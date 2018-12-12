<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>Camagru · <?= $title ?></title>
 	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="index.php">Camagru</a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="">Galerie</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="">Connexion</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php?action=register">S'enregistrer</a>
				</li>
				<?php if ($APP->user) : ?>
				<li class="nav-item">
					<a class="nav-link" href="">Deconnexion</a>
				</li>
				<?php endif; ?>
			</ul>
	</nav>
	</div>
	<div class="container-fluid">
	<?= $content ?>
	</div>
</body>
</html>
