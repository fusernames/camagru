<?php $title = 'S\'enregistrer' ?>
<?php ob_start() ?>

<form method="POST" class="clearfix">
	<div class="form-group">
		<label for="email">Adresse email</label>
		<input id="email" type="email" name="email" class="form-control" id="email">
	</div>
	<div class="form-group">
		<label for="username">Nom d'utilisateur</label>
		<input type="text" name="username" class="form-control" id="username">
	</div>
	<div class="form-row">
		<div class="form-group col-lg-6">
			<label for="password">Mot de passe</label>
			<input type="password" name="password" class="form-control" id="password">
		</div>
		<div class="form-group col-lg-6">
			<label for="repassword">Retapez mdp</label>
			<input type="password" name="repassword" class="form-control" id="repassword">
		</div>
	</div>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<button type="submit" class="btn btn-primary float-right">S'enregistrer</button>
</form>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
