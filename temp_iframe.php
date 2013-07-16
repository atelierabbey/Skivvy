<?php // Template Name: iframe ?>
<!DOCTYPE html><html class="<?php if (function_exists('css_browser_selector')) { echo css_browser_selector(); } else { echo 'off'; } ?>"  dir="ltr" lang="en-US"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><?php $ct = wp_get_theme(); ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php bloginfo('stylesheet_directory');?>/img/favicon.ico?v=<?php echo $ct->Version; ?>" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/inc/func.css?ver=<?php echo $ct->Version; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/style.css?ver=<?php echo $ct->Version; ?>" type="text/css" />
</head>
<body class="iframe">
<?php if ( have_posts() ) while ( have_posts() ) { the_post();
	the_content();
}; ?>
</body>
</html>