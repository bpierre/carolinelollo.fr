<!DOCTYPE html>
<html lang="en" class="<?= $html_classes ?>">
<head>
	<title>Caroline Lollo</title>
	<meta charset="utf-8" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic">
	<link rel="stylesheet" href="/styles/index.css" />
	<meta name="viewport" content="width=device-width; initial-scale=1"/>
</head>
<body>
	<div id="main">
		<div class="doubleHeader" id="header">
			<header>
				<?php if (isset($home_header) && $home_header === TRUE): ?>
				<h1>
					<a class="fat" href="/">Caroline Lollo</a>
				</h1>
				<div class="menu-lollo-container">
					<ul id="menu-lollo" class="menu">
						<li id="menu-item-287" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-287">
							<a href="/about">About</a>
						</li>
					</ul>
				</div>
				<?php else: ?>
				<a class="fat" href="/">back</a>
				<?php endif ?>
			</header>
		</div>
		<div class="container">
			<?= $yield ?>
		</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="/scripts/index.js"></script>
</body>
</html>

