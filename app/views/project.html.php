<div id="content">
	<div id="postnav">
		<a href="/the-fat-fat-club" rel="prev">⇠</a>
	</div>
	<div class="post type-post status-publish format-standard hentry category-non-classe post">
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

