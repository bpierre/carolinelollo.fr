<div id="content">
	<div id="postnav">
		<?php if ($prev_project): ?>
		<a href="/<?= $prev_project->name ?>" rel="prev">⇠</a>
		<?php endif ?>
		<?php if ($next_project): ?>
		<a href="/<?= $next_project->name ?>" rel="next">⇢</a>
		<?php endif ?>
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

