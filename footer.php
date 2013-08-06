<?php
	if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
        <ul class="xoxo footsidebar-1">
            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
        </ul>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
        <ul class="xoxo footsidebar-2">
            <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
        </ul>
    <?php endif; ?>

	<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
        <ul class="xoxo footsidebar-3">
            <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
        </ul>
    <?php endif; ?>

	<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
        <ul class="xoxo footsidebar-4">
            <?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
        </ul>
    <?php endif; ?>
<div class="footer-copyright">
	Copyright &copy; <?php echo date("Y"); ?>
    <a href="<?php echo home_url('/') ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>.
    All Rights Reserved.
    <a href="http://www.d4webdesign.com/" alt="Reno Web Design" target="_blank">Web Design</a> by D4
</div>
<?php include('analytics.php'); wp_footer(); ?>
</body>
</html>