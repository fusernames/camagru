<?php $title = 'Connexion' ?>
<?php ob_start() ?>

<h3 class="text-center">Connexion</h3>
<div class="row">
	<div class="mx-auto col-sm-8 col-md-6 col-lg-4">
		<?php foreach($alerts as $alert) : ?>
		<div class="alert alert-<?= $alert['type'] ?>">
			<?= $alert['message'] ?>
		</div>
		<?php endforeach; ?>
		<form method="POST" class="clearfix">
			<div class="form-group">
				<label for="username">Nom d'utilisateur</label>
				<input type="text" name="username" class="form-control" id="username">
			</div>
			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input type="password" name="password" class="form-control" id="password">
			</div>
			<button type="submit" class="btn btn-primary float-right">Se connecter</button>
		</form>
	</div>
</div>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
