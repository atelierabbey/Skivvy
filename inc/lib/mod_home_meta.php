<?php if ( !class_exists( 'skivvy_home_meta' ) ) : class skivvy_home_meta {

/*	---- TUDEUX ----
#
#	# Fix save Function
#	# create public function to pull meta on front-page.php via object or array.
#	# create image upload - http://tommcfarlin.com/wordpress-upload-meta-box/
#
#
#	-- http://codex.wordpress.org/Function_Reference/add_meta_box
#
#	FUTURE :
#		Register widget to pull each meta type. 
#		Ability to rearrange elements rendering? Drag n Drop?
#
#
*/


	static $version = '11Feb14';


	function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'register_home_meta' ) );
			add_action( 'save_post', array( $this, 'save_home_meta' ) );

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





	public function render_home_meta () {

			global $post;
			global $list_o_meta;

			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'skivvy_home_meta_box', 'skivvy_home_meta_nonce' );
			echo '<input id="HomeMetaVersion" type="hidden" value="' . skivvy_home_meta::$version . '"> ';
			foreach ( $list_o_meta as $home_meta ) {
					$slug = '_home_meta_'.sanitize_title( $home_meta );?>
					<fieldset title="<?php echo $slug; ?>_group" class="home-meta-fieldset <?php echo $slug; ?>_group">
						<h4><?php echo $home_meta; ?></h4>
						<input type="text" class="home-meta-title" id="<?php echo $slug; ?>_title" name="<?php echo $slug; ?>_title" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_title" , true ) ); ?>" size="25" placeholder="Title"><br>
						<input type="text" class="home-meta-img" id="<?php echo $slug; ?>_img" name="<?php echo $slug; ?>_img" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_img" , true ) ); ?>" size="25" placeholder="Image URL"><br>
						<input type="text" class="home-meta-link" id="<?php echo $slug; ?>_link" name="<?php echo $slug; ?>_link" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_link" , true ) ); ?>" size="25" placeholder="Link"><br>
						<textarea class="home-meta-content" id="<?php echo $slug; ?>_content" name="<?php echo $slug; ?>_content" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_content" , true ) ); ?>" col="63" placeholder="Content"></textarea>
					</fieldset>
			<?php }

	}





	public function save_home_meta ( $post_id ) {

			// Check if our nonce is set.
				if ( ! isset( $_POST['skivvy_home_meta_nonce'] ) ) return $post_id;

				$nonce = $_POST['skivvy_home_meta_nonce'];

			// Verify that the nonce is valid.
				if ( ! wp_verify_nonce( $nonce, 'skivvy_home_meta_box' ) ) return $post_id;

			// If this is an autosave, our form has not been submitted,
					// so we don't want to do anything.
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

			// Check the user's permissions.
				if ( 'page' == $_POST['post_type'] ) {
					if ( ! current_user_can( 'edit_page', $post_id ) ) return $post_id;
				} else {
					if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
				}

			// Sanitize the user input.
				$mydata = sanitize_text_field( $_POST['skivvy_home_meta'] );

			// Update the meta field.
				update_post_meta( $post_id, '_my_meta_value_key', $mydata );

	}



} endif;?>