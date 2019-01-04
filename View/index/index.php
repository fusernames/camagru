<?php $title = 'Galerie' ?>
<?php ob_start() ?>

<?php foreach($pictures as $picture) : ?>
<a href="index.php?action=picture_show&id=<?= $picture->id ?>">
	<img src="Public/pictures/<?= $picture->filename ?>" height="200px"/>
</a>
<?php endforeach; ?>
<nav class="mt-4">
	<ul class="pagination justify-content-end">
		<?php if ($page > 1) : ?>
			<li class="page-item"><a class="page-link" href="index.php?page=<?= $page - 1 ?>">Previous</a></li>
		<?php endif; ?>
		<?php for ($i = $page - 2; $page > $i; $i++) : ?>
			<?php if ($i > 0) : ?>
 				<li class="page-item"><a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a></li>
			<?php endif; ?>
		<?php endfor; ?>
		<li class="page-item active"><a class="page-link" href="#"><?= $page ?></a></li>
		<?php for ($i = $page + 1; $i <= $page + 2; $i++) : ?>
			<?php if ($i > 1 && $i <= $nbPages) : ?>
 				<li class="page-item"><a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a></li>
			<?php endif; ?>
		<?php endfor; ?>
		<?php if ($page < $nbPages) : ?>
			<li class="page-item"><a class="page-link" href="index.php?page=<?= $page + 1 ?>">Next</a></li>
		<?php endif; ?>
	</ul>
</nav>

<?php $content = ob_get_clean() ?>
<?php require DIR_VIEW.'base.php' ?>
