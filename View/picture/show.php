<?php use Model\Security; ?>
<?php $title = 'Photo de '.htmlspecialchars($picture->authorObject->username) ?>
<?php ob_start() ?>

<div class="text-center">
	<img style="max-width:700px; width=100%" src="Public/pictures/<?= htmlspecialchars($picture->filename) ?>"/>
	<br><br>
	<?php if ($picture->description) : ?>
	<em><?= $picture->description ?></em><br><br>
	<?php endif; ?>
	Auteur : <b><?= $picture->authorObject->username ?></b> | <?= $picture->creation_date ?>
	<?php if (Security::picture($picture, 'remove')) : ?>
	<br><a href="index.php?action=picture_remove&id=<?= $picture->id ?>&token=<?= $_SESSION['token'] ?>">Supprimer</a>
	<?php endif; ?>
</div>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
