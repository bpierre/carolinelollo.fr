
<div id="content">
	<?php foreach ($projects as $project): ?>
	<?php $thumbnail = $project->thumbnail(270) ?>
	<div class="thumb">
		<a href="/<?= $project->name ?>">
			<img width="<?= $thumbnail->width ?>" height="<?= $thumbnail->height ?>" src="<?= $thumbnail->url ?>" class="attachment-medium wp-post-image">
		</a>
	</div>
	<?php endforeach ?>
</div>

<div id="blackBar" class="opened"></div>

<!-- Gifsy Kings -->
<div id="gkLogoContainer">
	<div id="gkLogo">
		<a href="http://gifsykings.carolinelollo.fr/">
			<img src="http://27.media.tumblr.com/tumblr_llimoxB9K21qzgwljo1_400.gif"/>
			<p>Gifsy Kings</p>
			<div id="warped">
				<span class="w0">G</span><span class="w1">I</span><span class="w2">F</span><span class="w3">S</span><span class="w4">Y</span><span class="w5">K</span><span class="w6">I</span><span class="w7">N</span><span class="w8">G</span><span class="w9">S</span>
			</div>
		</a>
	</div>
</div>
<div id="side">
	<a href="http://gifsykings.carolinelollo.fr/"></a>
	<div id="gkPosts">
		<h2></h2><div id="tumblr_recent_photos"><ul><a href="http://gifsykings.carolinelollo.fr/post/26016170596" target="_blank" ><img src="http://25.media.tumblr.com/tumblr_m6aiw3Zfiz1qzgwljo1_100.gif" border="0" alt="http://gifsykings.carolinelollo.fr/post/26016170596" style="" /></a><a href="http://gifsykings.carolinelollo.fr/post/26016147341" target="_blank" ><img src="http://25.media.tumblr.com/tumblr_m6aivgMVQg1qzgwljo1_100.gif" border="0" alt="http://gifsykings.carolinelollo.fr/post/26016147341" style="" /></a><a href="http://gifsykings.carolinelollo.fr/post/26016118422" target="_blank" ><img src="http://25.media.tumblr.com/tumblr_m6aiuouXZL1qzgwljo1_100.gif" border="0" alt="http://gifsykings.carolinelollo.fr/post/26016118422" style="" /></a></ul></div><br clear="all" /> <p class="more"><a href="http://gifsykings.carolinelollo.fr/" title="Go to Gifsy Kings">+</a></p>
	</div>
</div>
