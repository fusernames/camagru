<?php $title = 'Editer '.htmlspecialchars($user->username) ?>
<?php ob_start() ?>

<form method="POST" class="clearfix">
	<div class="form-group">
		<label for="email">Adresse email</label>
		<input id="email" type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($user->email) ?>">
	</div>
	<div class="form-group">
		<label for="username">Nom d'utilisateur</label>
		<input type="text" name="username" class="form-control" id="username" value="<?= htmlspecialchars($user->username) ?>">
	</div>
	<?php if (Services\Security::user($user, 'edit_role')) : ?>
		<div class="form-group">
			<label for="role">Role</label>
			<select id="role" class="form-control" name="role">
				<option value="user">USER</option>
				<option value="admin"<?php if ($user->role == 'admin') { ?>selected<?php } ?>>ADMIN</option>
			</select>
		</div>
	<?php endif; ?>
	<div class="form-row">
		<div class="form-group col-lg-6">
			<label for="password">Nouveau mot de passe (optionel)</label>
			<input type="password" name="password" class="form-control" id="password">
		</div>
		<div class="form-group col-lg-6">
			<label for="repassword">Retapez mdp</label>
			<input type="password" name="repassword" class="form-control" id="repassword">
		</div>
	</div>
	<div class="form-check form-check-inline">
  	<input class="form-check-input" name="alert" type="checkbox" id="check" <?php if ($user->alert) { echo 'checked'; } ?>>
  	<label class="form-check-label" for="check">Alertes sur les nouveaux commentaires</label>
	</div>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<button type="submit" class="btn btn-primary float-right">Editer</button>
</form>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
