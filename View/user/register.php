<?php $title = 'S\'enregistrer' ?>
<?php ob_start() ?>

<h3 class="text-center">S'enregistrer</h3>
<div class="row">
	<div class="mx-auto col-sm-8 col-md-6 col-lg-4">
		<?php foreach($alerts as $alert) : ?>
		<div class="alert alert-<?= $alert['type'] ?>">
			<?= $alert['message'] ?>
		</div>
		<?php endforeach ?>
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
			<button type="submit" class="btn btn-primary float-right">S'enregistrer</button>
		</form>
	</div>
</div>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
