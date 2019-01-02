<!DOCTYPE HTML>
<html>
<head>
 	<meta charset="utf-8">
 	<title>Camagru · <?= $title ?></title>
 	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<?php if (isset($scripts)) : ?>
	<?= $scripts ?>
	<?php endif; ?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-faded">
		<a class="navbar-brand" href="index.php">Camagru</a>
			<ul class="navbar-nav mr-auto">
				<?php if (!$APP->user) : ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php?action=login">Connexion</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php?action=register">S'enregistrer</a>
				</li>
				<?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Galerie</a>
        </li>
				<li class="nav-item">
					<a class="nav-link" href="index.php?action=take">Photo</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php?action=user_edit&id=<?= $APP->user->id ?>">Editer</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php?action=logout">Deconnexion</a>
				</li>
				<?php endif; ?>
			</ul>
	</nav>
	</div>
	<div class="container mt-3">
    <?php foreach($alerts as $alert) : ?>
    <div class="alert alert-<?= $alert['type'] ?>">
      <?= $alert['message'] ?>
    </div>
    <?php endforeach; ?>
    <h4 class="text-center"><?= $title ?></h4>
    <?= $content ?>
  </div>
</body>
</html>
