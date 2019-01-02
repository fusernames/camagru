<?php $title = 'Reinitialiser le mot de passe' ?>
<?php ob_start() ?>

<form method="POST" class="clearfix">
	<div class="form-group">
		<label for="password">Mot de passe</label>
		<input type="password" name="password" class="form-control" id="password">
	</div>
	<div class="form-group">
		<label for="repassword">Retapez le mdp</label>
		<input type="password" name="repassword" class="form-control" id="repassword">
	</div>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<button type="submit" class="btn btn-primary float-right">Reinitialiser le mot de passe</button>
</form>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
