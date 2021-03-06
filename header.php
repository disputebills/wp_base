<!DOCTYPE html>
<!--[if lt IE 9]>         <html class="no-js oldie" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]>         <html class="no-js ie" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]><!--> <html class="no-js" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" />
	<?php } ?>

	<title><?php wp_title(''); ?></title>
	<!-- <meta name="google-site-verification" content=""> -->
	<meta name="viewport" content="width=device-width">

	<!-- <link rel="apple-touch-icon" href="/touchicon.png"> -->
	<link rel="icon" href="/favicon.png">
	<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
	<!-- or, set /favicon.ico for IE10 win -->
	<meta name="msapplication-TileColor" content="#bada55">
	<!-- <meta name="msapplication-TileImage" content="/tileicon.png">  -->

	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script>

<!-- Typekit
	<script src="//use.typekit.net/xdb0ddk.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
-->

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
	<![endif]-->

</head>
<body <?php body_class(); ?>>
	<?php get_template_part('parts/svg-defs'); ?>
	<!--[if lt IE 9]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->

		<header class="site__header">
			<div class="container">
				<div class="row">
					<a class="site__logo" href="<?php home_url(); ?>/">
						<img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?>" />
					</a>
					<nav class="site__nav" role="navigation">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'main-nav',
									'menu_class'     => 'menu main__nav',
									'container'      => '',
									'walker'         => new base_nav_walker()
								)
							);
						?>
						<?php get_template_part('parts/header-utils'); ?>
					</nav>
				</div>
			</div>
		</header>

		<main class="site__content" role="main">
