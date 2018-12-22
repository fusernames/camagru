<?php $title = 'Mot de passe oublie' ?>
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
				<label for="email">Email</label>
				<input type="email" name="email" class="form-control" id="email">
			</div>
			<button type="submit" class="btn btn-primary float-right">Envoyer un mail</button>
		</form>
	</div>
</div>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
