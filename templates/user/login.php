<?php $title = 'Connexion' ?>
<?php ob_start() ?>

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
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
</form>
<a href="index.php?action=user_send_reset">Mot de passe oublie ?</a>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
