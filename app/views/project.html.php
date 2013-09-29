<div id="content" class="single">
	<div id="postnav">
		<?php if ($prev_project): ?>
		<a href="<?= $prev_project->url() ?>" rel="prev">⇠</a>
		<?php endif ?>
		<?php if ($next_project): ?>
		<a href="<?= $next_project->url() ?>" rel="next">⇢</a>
		<?php endif ?>
	</div>
	<?php
		$classes = '';
		$metas = $project->metas();
		if (isset($metas['classes'])) $classes = $metas['classes'];
	?>
	<div class="post type-post hentry post <?= $classes ?>">
		<article>
			<div id="desc">
				<?= $project->html() ?>
			</div>
			<div class="images">
<?php $images = $project->images() ?>
<?php foreach($images as $image): ?>
				<img width="<?= $image->width ?>" height="<?= $image->height ?>" src="<?= $image->url ?>" class="attachment-large" alt="" />
<?php endforeach ?>
			</div>
		</article>
	</div>
</div>

