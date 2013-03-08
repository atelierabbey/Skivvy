<ul class="xoxo sidebar-1">
	<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : 
        // This area is for if the widget area is empty. 
        endif; // end primary widget area ?>
</ul>

<?php // A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
        <ul class="xoxo sidebar-2">
            <?php dynamic_sidebar( 'secondary-widget-area' ); ?>
        </ul>
<?php endif; ?>