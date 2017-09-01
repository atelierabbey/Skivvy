<?php // Template Name: iframe ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="iframe <?php if (function_exists('html_classes')){ html_classes(); } ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/func.css?ver=1" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/style.css?ver=1" type="text/css" />
</head>
<body>
<?php if ( have_posts() ) while ( have_posts() ) { the_post();
	the_content();
}; ?>
</body>
</html>