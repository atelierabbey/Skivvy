<?php
	if (   ! is_active_sidebar( 'first-footer-widget-area'  )
		&& ! is_active_sidebar( 'second-footer-widget-area' )
		&& ! is_active_sidebar( 'third-footer-widget-area'  )
		&& ! is_active_sidebar( 'fourth-footer-widget-area' )
	)
		return;



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