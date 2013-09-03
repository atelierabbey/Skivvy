<?php // Template Name: iframe ?>
<!DOCTYPE html>
<html class="<?php if (function_exists('css_browser_selector')) { echo css_browser_selector(); } ?>"  dir="ltr" lang="en-US">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title><?php wp_title( '|', true, 'right' ); ?></title>
   <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/func.css?ver=1?>" type="text/css" />
   <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/style.css?ver=1 ?>" type="text/css" />
</head>
<body class="iframe">
<?php if ( have_posts() ) while ( have_posts() ) { the_post();
	the_content();
}; ?>
</body>
</html>
