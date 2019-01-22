<?php $title = 'Prendre une photo' ?>
<?php ob_start() ?>
<script src="public/js/snapshot.js"></script>
<?php $scripts = ob_get_clean() ?>
<?php ob_start() ?>

<form method="POST" class="clearfix" enctype="multipart/form-data">
	<div class="form-group">
		<label>Prendre une photo</label>
		<div style="position:relative; width:400px; height:300px;">
			<video class="d-block" width="400px" height="300px" autoplay></video>
			<canvas style="display:none;" width="400px" height="300px" id="my_canvas"></canvas>
			<img style="position:absolute; top:0; left:0;" class="d-block" id="video_preview">
		</div>
		<div id="snapshot_div" style="position:relative; display:none; width:400px; height:300px;">
			<img style="position:absolute; top:0; left:0;" class="d-block" id="snapshot_img">
			<img style="position:absolute; top:0; left:0;" class="d-block" id="snapshot_preview">
		</div>
		<br>
		<button type="button" onclick="takeSnapshot();" class="btn btn-primary">Prendre une photo</button>
		<input id="snapshot_input" type="hidden" name="snapshot"/>
	</div>
	<div class="form-group" id="send_img">
		<div class="custom-file">
			<input name="pic" type="file" class="custom-file-input">
			<label class="custom-file-label" for="customFile">Choisir une image</label>
		</div>
	</div>
	<div class="form-group">
		<div><label>Filtres</label></div>
		<label class="radio-inline mr-3">
			<input onclick="previewFilter(this)" class="form-check-input" type="radio" name="src" value="trump.png">
			<img src="public/filters/trump.png" height="100px"/>
		</label>
		<label class="radio-inline mr-3">
			<input onclick="previewFilter(this)" class="form-check-input" type="radio" name="src" value="poutine.png">
			<img src="public/filters/poutine.png" height="100px"/>
		</label>
		<label class="radio-inline mr-3">
			<input onclick="previewFilter(this)" class="form-check-input" type="radio" name="src" value="bush.png">
			<img src="public/filters/bush.png" height="100px"/>
		</label>
		<label class="radio-inline mr-3">
			<input onclick="previewFilter(this)" class="form-check-input" type="radio" name="src" value="macron.png">
			<img src="public/filters/macron.png" height="100px"/>
		</label>
	</div>
	<div class="form-group">
		<label>Description (facultatif)</label>
		<textarea name="description" class="form-control"></textarea>
	</div>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<button type="submit" class="btn btn-primary float-right">Envoyer</button>
</form>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
