<?php $title = 'Reinitialiser le mot de passe' ?>
<?php ob_start() ?>

<h3 class="text-center"><?= $title ?></h3>
<div class="row">
	<div class="mx-auto col-sm-8 col-md-6 col-lg-4">
		<?php foreach($alerts as $alert) : ?>
		<div class="alert alert-<?= $alert['type'] ?>">
			<?= $alert['message'] ?>
		</div>
		<?php endforeach; ?>
		<form method="POST" class="clearfix">
			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input type="password" name="password" class="form-control" id="password">
			</div>
			<div class="form-group">
				<label for="repassword">Retapez le mdp</label>
				<input type="password" name="repassword" class="form-control" id="repassword">
			</div>
			<button type="submit" class="btn btn-primary float-right">Reinitialiser le mot de passe</button>
		</form>
	</div>
</div>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
