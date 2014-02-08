<?php if ( !class_exists( 'skivvy_home_meta' ) ) { class skivvy_home_meta {


	static $list_o_meta = array(
			'Bucket 1',
			'Bucket 2',
			'Bucket 3',
			'Bucket 4',
	);















	/////// [ Belt line ] //////  Not touching below the belt, keep it PG.



		# Fix save Function
		# create public function to pull meta on front-page.php
		# create image upload - http://tommcfarlin.com/wordpress-upload-meta-box/


		## http://codex.wordpress.org/Function_Reference/add_meta_box



	static $version = '7Feb14';


	function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'register_home_meta' ) );
			add_action( 'save_post', array( $this, 'save_home_meta' ) );
	}



	public function register_home_meta( $post_type ) {

			global $post;

			$homeid = get_option( 'page_on_front' );

			$home_meta = 'Home Meta';

			if ( $homeid == $post->ID ) {
				$slug = esc_attr( $home_meta );
				add_meta_box( 
					$slug,
					$home_meta,
					array( $this, 'render_home_meta' ),
					'page',
					'normal',
					'default'
				);
			}

	}

	public function render_home_meta ( $home_meta ) {

		global $post;

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		
		foreach ( skivvy_home_meta::$list_o_meta as $home_meta ) {
				$slug = 'home_meta_'.sanitize_title( $home_meta );?>
				<fieldset title="<?php echo $slug; ?>_group" class="home-meta-fieldset <?php echo $slug; ?>_group">
					<h4><?php echo $home_meta; ?></h4>
					<input type="text" class="home-meta-title" id="<?php echo $slug; ?>_title" name="<?php echo $slug; ?>_title" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_title" , true ) ); ?>" size="25" placeholder="Title"><br>
					<input type="text" class="home-meta-img" id="<?php echo $slug; ?>_img" name="<?php echo $slug; ?>_img" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_img" , true ) ); ?>" size="25" placeholder="Image"><br>
					<input type="text" class="home-meta-link" id="<?php echo $slug; ?>_link" name="<?php echo $slug; ?>_link" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_link" , true ) ); ?>" size="25" placeholder="Link"><br>
					<textarea class="home-meta-content" id="<?php echo $slug; ?>_content" name="<?php echo $slug; ?>_content" value="<?php echo esc_attr( get_post_meta( $post->ID, "{$slug}_content" , true ) ); ?>" col="63" placeholder="Content"></textarea>
				</fieldset>
		<?php }

	}




		
	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_home_meta ( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['myplugin_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['myplugin_new_field'] );

		// Update the meta field.
		update_post_meta( $post_id, '_my_meta_value_key', $mydata );
	}



}}?>