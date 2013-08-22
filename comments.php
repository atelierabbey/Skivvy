<?php
if ( post_password_required() ) :
    echo '<p>This post is password protected. Enter the password to view any comments.</p>';
	return;
endif;

if ( have_comments() ) : ?>
    <h3 id="comments-title"><?php
    printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'skivvy' ),
    number_format_i18n( get_comments_number() ), '' . get_the_title() . '' );
    ?></h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <?php previous_comments_link( '&larr; Older Comments'); ?>
        <?php next_comments_link('Newer Comments &rarr;' ); ?>
    <?php endif; // check for comment navigation ?>

    <ol>
        <?php wp_list_comments( array( 'callback' => 'skivvy_comment' ) ); ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <?php previous_comments_link( '&larr; Older Comments', 'skivvy'); ?>
        <?php next_comments_link( 'Newer Comments &rarr;'); ?>
    <?php endif; // check for comment navigation ?>

<?php else :
		if ( ! comments_open() ) : // When comments are closed, echo note
			echo '<p></p>';
		endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>