<?php if ( !class_exists( 'skivvy_home_meta' ) ) : class skivvy_home_meta {

/*	---- TUDEUX ----
#
#	# create public function to pull meta on front-page.php via object or array.
#
#
#
#	FUTURE :
#		Register widget to pull each meta type. 
#		Ability to rearrange elements rendering? Drag n Drop?
#
#
*/


	static $version = '11Feb14';


	function __construct() {
			add_action('admin_enqueue_scripts',  array( $this, 'admin_scripts_home_meta' ));
			add_action('add_meta_boxes', array( $this, 'register_home_meta' ) );
			add_action('save_post', array( $this, 'save_home_meta' ), 10, 2 );
			add_shortcode( 'homemeta', array( $this, 'home_meta_shortcode' ) );
			global $list_o_meta;
			if (! isset($list_o_meta)) {
				$list_o_meta = array(
					'Bucket 1',
					'Bucket 2',
					'Bucket 3',
					'Bucket 4',
				);
			}

	}



	public function register_home_meta( $post_type ) {

			global $post;
			$homeid = get_option( 'page_on_front' );

			if ( $homeid == $post->ID ) add_meta_box( 
				'skivvy_home_meta',
				'Home Meta',
				array( $this, 'render_home_meta' ),
				'page',
				'normal',
				'default'
			);

	}
	public function admin_scripts_home_meta() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}









/*
**		RENDER - Homemeta box
**
*/
	public function render_home_meta () {

			global $post;
			global $list_o_meta;
			$home_meta_data = get_post_meta( $post->ID );

			// Add an nonce field so we can check for it later.
			wp_nonce_field( basename( __FILE__ ), 'skivvy_home_meta_nonce' );

			echo '<input id="HomeMetaVersion" type="hidden" value="' . skivvy_home_meta::$version . '"> ';

			foreach ( $list_o_meta as $home_meta ) :
					$slug = '_home_meta_'.sanitize_title( $home_meta );?>
					<fieldset title="<?php echo $slug; ?>_group" class="home-meta-fieldset <?php echo $slug; ?>_group">
						<h4><?php echo $home_meta; ?></h4>
						<label for="<?php echo $slug; ?>_title">Title</label><input type="text"		class="home-meta-title"			id="<?php echo $slug; ?>_title"			name="<?php echo $slug; ?>_title"		value="<?php echo esc_attr( get_post_meta( $post->ID , "{$slug}_title" , TRUE) ); ?>"	size="25"	placeholder="Title">
						<div>
							<label for="<?php echo $slug; ?>_img">Image URL</label><?php
							if (get_post_meta( $post->ID , "{$slug}_img" , TRUE))
								echo '<img src="'. get_post_meta( $post->ID , "{$slug}_img" , TRUE) .'" width="32" height="32">'; ?><input type="text"		class="home-meta-img"			id="<?php echo $slug; ?>_img"			name="<?php echo $slug; ?>_img"			value="<?php echo esc_attr( get_post_meta( $post->ID , "{$slug}_img" , TRUE) ); ?>"		size="25"	placeholder="Image URL">
							<input type="button"	class="home-meta-img-button"	id="<?php echo $slug; ?>_img_button"	name="<?php echo $slug; ?>_img_button"	value="Upload" >
						</div>
						<label for="<?php echo $slug; ?>_link">Link URL</label><input type="text"		class="home-meta-link"			id="<?php echo $slug; ?>_link"			name="<?php echo $slug; ?>_link"		value="<?php echo esc_attr( get_post_meta( $post->ID , "{$slug}_link" , TRUE) ); ?>"	size="25"	placeholder="Link URL">
						<label for="<?php echo $slug; ?>_content">Text</label><textarea				class="home-meta-content"		id="<?php echo $slug; ?>_content"		name="<?php echo $slug; ?>_content"		col="63"	placeholder="Content"><?php echo esc_attr( get_post_meta( $post->ID , "{$slug}_content" , TRUE) ); ?></textarea>
						<script>jQuery(document).ready( function( $ ) {
							var _custom_media = true,
								_orig_send_attachment = wp.media.editor.send.attachment;

							$('#<?php echo $slug; ?>_img_button').click(function(e) {
								var send_attachment_bkp = wp.media.editor.send.attachment;
								var button = $(this);
								var id = button.attr('id').replace('_button', '');
								_custom_media = true;
								wp.media.editor.send.attachment = function(props, attachment){
									if ( _custom_media ) {
										$("#"+id).val(attachment.url);
									} else {
										return _orig_send_attachment.apply( this, [props, attachment] );
									};
							}

							wp.media.editor.open(button);
								return false;
							});

							$('.add_media').on('click', function(){
								_custom_media = false;
							});
						});</script>

					</fieldset>
			<?php
			endforeach;
	}
	public function save_home_meta ( $post_id, $post ) {
			global $list_o_meta;
			$is_autosave = wp_is_post_autosave( $post_id );
			$is_revision = wp_is_post_revision( $post_id );
			$is_valid_nonce = ( isset( $_POST[ 'skivvy_home_meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'skivvy_home_meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

			// Verify the nonce before proceeding.
			if ( $is_autosave || $is_revision || !$is_valid_nonce ) 
				return;
			
			foreach ( $list_o_meta as $home_meta ) {
				$slug = '_home_meta_'.sanitize_title( $home_meta );
				//update_post_meta($post_id, $meta_key, $meta_value, $prev_value)
				update_post_meta( $post_id, "{$slug}_title", sanitize_text_field( $_POST["{$slug}_title"] ) );
				update_post_meta( $post_id, "{$slug}_img", sanitize_text_field( $_POST["{$slug}_img"] ) );
				update_post_meta( $post_id, "{$slug}_link", sanitize_text_field( $_POST["{$slug}_link"] ) );
				update_post_meta( $post_id, "{$slug}_content", sanitize_text_field( $_POST["{$slug}_content"] ) );
			}
	}






















public function home_meta_shortcode ($atts ) {

	extract( shortcode_atts( array(
		'key' => '',
		'output' => '',
	), $atts ) );

	$slug = '_home_meta_'.sanitize_title( $key );
	switch ($output) {
		case 'title': //{$slug}_title
			$title = get_post_meta( get_option( 'page_on_front' ) , "{$slug}_title" , TRUE);
			if ($title) 
				$output = $title;
			else
				$output = $slug;
			break;
		case 'image': // {$slug}_img
			$output = get_post_meta( get_option( 'page_on_front' ) , "{$slug}_img" , TRUE);
			break;
		case 'link': // {$slug}_link
			$output = get_post_meta( get_option( 'page_on_front' ) , "{$slug}_link" , TRUE);
			break;
		case 'content' : // {$slug}_content
			$output = get_post_meta( get_option( 'page_on_front' ) , "{$slug}_content" , TRUE);
			break;
		default :
			$output = $key;
	}

	return $output;

}






} endif;?>