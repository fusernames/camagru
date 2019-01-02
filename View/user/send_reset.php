<?php $title = 'Mot de passe oublie' ?>
<?php ob_start() ?>

<form method="POST" class="clearfix">
	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" name="email" class="form-control" id="email">
	</div>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<button type="submit" class="btn btn-primary float-right">Envoyer un mail</button>
</form>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
