<?php $title = 'Prendre une photo' ?>
<?php ob_start() ?>
<script src=""></script>
<?php $scripts = ob_get_clean() ?>
<?php ob_start() ?>

<form method="POST" class="clearfix" enctype="multipart/form-data">
	<div class="form-group">
		<label>Envoyer une image</label>
		<input name="pic" type="file" class="form-control-file">
	</div>
	<div class="form-group">
		<label>Description (optionel)</label>
		<textarea name="description" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<div><label>Filtre</label></div>
		<label class="radio-inline mr-3">
			<input class="form-check-input" type="radio" name="src" value="trump.png">
			<img src="public/filters/trump.png" height="100px"/>
		</label>
		<label class="radio-inline mr-3">
			<input class="form-check-input" type="radio" name="src" value="poutine.png">
			<img src="public/filters/poutine.png" height="100px"/>
		</label>
		<label class="radio-inline mr-3">
			<input class="form-check-input" type="radio" name="src" value="bush.png">
			<img src="public/filters/bush.png" height="100px"/>
		</label>
	</div>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<button type="submit" class="btn btn-primary float-right">Envoyer</button>
</form>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
