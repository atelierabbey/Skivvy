<?php
if ( post_password_required() ) :
    echo '<p>This post is password protected. Enter the password to view any comments.</p>';
	return;
endif;

if ( have_comments() ) : ?>
    <!-- STARKERS NOTE: The following h3 id is left intact so that comments can be referenced on the page -->
    <h3 id="comments-title"><?php
    printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'twentyten' ),
    number_format_i18n( get_comments_number() ), '' . get_the_title() . '' );
    ?></h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <?php previous_comments_link( __( '&larr; Older Comments', 'twentyten' ) ); ?>
        <?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyten' ) ); ?>
    <?php endif; // check for comment navigation ?>

    <ol>
        <?php wp_list_comments( array( 'callback' => 'twentyten_comment' ) ); ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <?php previous_comments_link( __( '&larr; Older Comments', 'twentyten' ) ); ?>
        <?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyten' ) ); ?>
    <?php endif; // check for comment navigation ?>

<?php else :
		if ( ! comments_open() ) : // When comments are closed, echo note
			echo '<p></p>';
		endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>