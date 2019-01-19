<?php use Services\Security; ?>
<?php $title = 'Photo de '.htmlspecialchars($picture->user->username) ?>
<?php ob_start() ?>

<div class="text-center">
	<img style="max-width:700px; width=100%" src="public/pictures/<?= htmlspecialchars($picture->filename) ?>"/>
	<br><br>
	<?php if ($picture->description) : ?>
	<em><?= $picture->description ?></em><br><br>
	<?php endif; ?>
	Auteur : <b><?= htmlspecialchars($picture->user->username) ?></b> | <?= $picture->creation_date ?>
	<?php if (Security::picture($picture, 'remove')) : ?>
	<br><a href="index.php?action=picture_remove&id=<?= $picture->id ?>&token=<?= $_SESSION['token'] ?>">Supprimer</a>
	<?php endif; ?>
</div>

<form method="POST" action="index.php?action=picture_comment_create" class="clearfix">
	<div class="form-group">
		<label for="comment">Commentaire</label>
		<textarea class="form-control" name="comment"></textarea>
	</div>
	<button type="submit" class="btn btn-primary float-right">Envoyer</button>
	<input type="hidden" name="id_picture" value="<?= $picture->id ?>"/>
	<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
</form>

<?php foreach($comments as $comment) : ?>
<div>
	<b><?= htmlspecialchars($comment->user->username) ?></b><br>
	<p>
		<?= htmlspecialchars($comment->comment) ?>
	</p>
	<div class="text-right">
		<?php if (Security::comment($comment, 'remove')) : ?>
		<a href="index.php?action=picture_comment_remove&id=<?= $comment->id ?>">Supprimer</a> 	| 
		<?php endif ?>
		<?php if (Security::comment($comment, 'like')) : ?>
		<a href="index.php?action=picture_comment_like&id=<?= $comment->id ?>&token=<?= $_SESSION['token'] ?>">J'aime (<?= $comment->nb_likes ?>)</a>
		<?php elseif (Security::comment($comment, 'unlike')) : ?>
		<a href="index.php?action=picture_comment_unlike&id=<?= $comment->id ?>&token=<?= $_SESSION['token'] ?>">Je n'aime plus (<?= $comment->nb_likes ?>)</a>
		<?php else : ?>
			<?= $comment->nb_likes ?> aiment ca
		<?php endif ?>
	</div>

</div>
<?php endforeach; ?>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
