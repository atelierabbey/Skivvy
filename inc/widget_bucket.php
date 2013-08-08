<?php #8Aug13
class Bucket_Widget extends WP_Widget {
	/*
	 * Setup widget options.
	 */
	function __construct( $id_base = false, $name = false, $widget_options = array(), $control_options = array() ) {
		$id_base = ( $id_base ) ? $id_base : 'bucket'; // Legacy ID.
		$name = ( $name ) ? $name : __( 'Bucket', 'bucketwidget' );
		$widget_options = wp_parse_args( $widget_options, array(
			'classname'   => 'widget_bucket', // Legacy class name.
			'description' => __( 'Display an image, text, and link', 'bucketwidget' ),
		) );
		$control_options = wp_parse_args( $control_options, array(
			'width' => 300
		) );
		parent::__construct( $id_base, $name, $widget_options, $control_options );
		// Flush widget group cache when an attachment is saved, deleted, or the theme is switched.
		add_action( 'save_post', array( $this, 'flush_group_cache' ) );
		add_action( 'delete_attachment', array( $this, 'flush_group_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_group_cache' ) );
	}
	/**
	 * Default widget front end display method.
	 *
	 * Filters the instance data, fetches the output, displays it, then caches
	 * it. Overload or filter the render() method to modify output.
	 *
	 * @since 3.0.0
	 */
	function widget( $args, $instance ) {
		$cache = (array) wp_cache_get( 'bucket_widget', 'widget' );
		if ( isset( $cache[ $this->id ] ) ) {
			echo $cache[ $this->id ];
			return;
		}
		// Copy the original title so it can be passed to hooks.
		$instance['title_raw'] = $instance['title'];
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		// Copy the original text so it can be passed to hooks.
		$instance['text_raw'] = $instance['text'];
		$instance['text'] = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance, $this->id_base );
		// Start building the output.
		$output = '';
		// Make sure the image ID is a valid attachment.
		if ( ! empty( $instance['image_id'] ) ) {
			$image = get_post( $instance['image_id'] );
			if ( ! $image || 'attachment' != get_post_type( $image ) ) {
				$output = '<!-- Image Widget Error: Invalid Attachment ID -->';
			}
		}
		if ( empty( $output ) ) {
			$output = $this->render( $args, $instance );
		}
		echo $output;
		$cache[ $this->id ] = $output;
		wp_cache_set( 'bucket_widget', array_filter( $cache ), 'widget' );
	}
	/**
	 * Generate the widget output.
	 *
	 * This is typically done in the widget() method, but moving it to a
	 * separate method allows for the routine to be easily overloaded by a
	 * class extending this one without having to reimplement all the caching
	 * and filtering, or resorting to adding a filter, calling the parent
	 * method, then removing the filter.
	 *
	 * @since 3.0.0
	 */
	function render( $args, $instance ) {
		$instance['link_open'] = '';
		$instance['link_close'] = '';
		if ( ! empty ( $instance['link'] ) ) {
			$target = ( empty( $instance['new_window'] ) ) ? '' : ' target="_blank"';
			$instance['link_open'] = '<a href="' . esc_url( $instance['link'] ) . '"' . $target . '>';
			$instance['link_close'] = '</a>';
		}
		$output = $args['before_widget'];
			// Allow custom output to override the default HTML.
			if ( $inside = apply_filters( 'bucket_widget_output', '', $args, $instance, $this->id_base ) ) {
				$output .= $inside;
			} else {
				$output .= '<div class="bucket">';
					// Add a Title
					if($instance['title']){ $output .= $args['before_title']. $instance['title'] . $args['after_title']; }
					// Add the image.
					if ( ! empty( $instance['image_id'] ) ) {
						$image_size = ( ! empty( $instance['image_size'] ) ) ? $instance['image_size'] : apply_filters( 'bucket_widget_output_default_size', 'medium', $this->id_base );
						$output .= sprintf( '<div class="bucketimg">%s%s%s</div>',
							$instance['link_open'],
							wp_get_attachment_image( $instance['image_id'], $image_size ),
							$instance['link_close']
						);

					} elseif ( ! empty( $instance['image'] ) ) {
						// Legacy output.
						$output .= sprintf( '%s<img src="%s" alt="%s">%s',
							$instance['link_open'],
							esc_url( $instance['image'] ),
							( empty( $instance['alt'] ) ) ? '' : esc_attr( $instance['alt'] ),
							$instance['link_close']
						);
					}
					$output .= '<div class="bucketcont">';
						// Add the text.
						if ( ! empty( $instance['text'] ) ) {
							$output .= '<div class="buckettxt">' . apply_filters( 'the_content', $instance['text'] ) . '</div>';
						}
						// Add a more link.
						if ( ! empty( $instance['link_open'] ) && ! empty( $instance['link_text'] ) ) {
							$output .= '<div class="bucketlnk">' . $instance['link_open'] . $instance['link_text'] . $instance['link_close'] . '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
			}
		$output .= $args['after_widget'];
		return $output;
	}
	/**
	 * Form for modifying widget settings.
	 *
	 * @since 3.0.0
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'alt'        => '', // Legacy.
			'image'      => '', // Legacy URL field.
			'image_id'   => '',
			'image_size' => 'full',
			'link'       => '',
			'link_text'  => '',
			'new_window' => '',
			'title'      => '',
			'text'       => '',
		) );
		$instance['image_id'] = absint( $instance['image_id'] );
		$instance['title'] = wp_strip_all_tags( $instance['title'] );
		$button_class = array( 'button', 'button-hero', 'bucketwidget-control-choose' );
		$image_id = $instance['image_id'];
		// The order of fields can be modified, new fields can be registered, or existing fields can be removed here.
		$fields = (array) apply_filters( 'bucket_widget_fields', $this->form_fields(), $this->id_base );
		?>
		<div class="bucketwidget-form">
			<?php do_action( 'bucket_widget_form_before', $instance, $this->id_base ); ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bucketwidget' ); ?></label>
				<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat">
			</p>
            <p class="bucketwidget-control<?php echo ( $image_id ) ? ' has-image' : ''; ?>"
                data-title="<?php esc_attr_e( 'Choose an Image for the Widget', 'bucketwidget' ); ?>"
                data-update-text="<?php esc_attr_e( 'Update Image', 'bucketwidget' ); ?>"
                data-target=".image-id">
                <?php
                if ( $image_id ) {
                    echo wp_get_attachment_image( $image_id, 'medium', false );
                    unset( $button_class[ array_search( 'button-hero', $button_class ) ] );
                }
                ?>
                <input type="hidden" name="<?php echo $this->get_field_name( 'image_id' ); ?>" id="<?php echo $this->get_field_id( 'image_id' ); ?>" value="<?php echo $image_id; ?>" class="image-id bucketwidget-control-target">
                <a href="#" class="<?php echo join( ' ', $button_class ); ?>"><?php _e( 'Choose an Image', 'bucketwidget' ); ?></a>
            </p>
			<?php /* if ( empty( $instance['image'] ) ) : ?>
				<div class="bucketwidget-legacy-fields">
					<p>
						<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image URL:', 'bucketwidget' ); ?></label>
						<input type="text" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php echo esc_url( $instance['image'] ); ?>" class="widefat">
					</p>
					<p>
						<label for="<?php echo $this->get_field_id( 'alt' ); ?>"><?php _e( 'Alternate Text:', 'bucketwidget' ); ?></label>
						<input type="text" name="<?php echo $this->get_field_name( 'alt' ); ?>" id="<?php echo $this->get_field_id( 'alt' ); ?>" value="<?php echo esc_attr( $instance['alt'] ); ?>" class="widefat">
					</p>
				</div>
			<?php endif; //*/?>
			<?php
			if ( ! empty( $fields ) ) {
				foreach ( $fields as $field ) {
					switch ( $field ) {
						case 'image_size' :
							$sizes = $this->get_image_sizes( $image_id );
							?>
							<p>
								<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Size:', 'bucketwidget' ); ?></label>
								<select name="<?php echo $this->get_field_name( 'image_size' ); ?>" id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="widefat image-size"<?php echo ( sizeof( $sizes ) < 2 ) ? ' disabled="disabled"' : ''; ?>>
									<?php
									foreach ( $sizes as $id => $label ) {
										printf( '<option value="%s"%s>%s</option>',
											esc_attr( $id ),
											selected( $instance['image_size'], $id, false ),
											esc_html( $label )
										);
									}
									?>
								</select>
							</p>
							<?php
							break;
						case 'link' :
							?>
							<p style="margin-bottom: 0.25em">
								<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'bucketwidget' ); ?></label>
								<input type="text" name="<?php echo $this->get_field_name( 'link' ); ?>" id="<?php echo $this->get_field_id( 'link' ); ?>" value="<?php echo esc_url( $instance['link'] ); ?>" class="widefat">
							</p>
							<p style="padding-left: 2px">
								<label for="<?php echo $this->get_field_id( 'new_window' ); ?>">
									<input type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" id="<?php echo $this->get_field_id( 'new_window' ); ?>" <?php checked( $instance['new_window'] ); ?>>
									<?php _e( 'Open in new window?', 'bucketwidget' ); ?>
								</label>
							</p>
							<?php
							break;
						case 'link_text' :
							?>
							<p>
								<label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link Text:', 'bucketwidget' ); ?></label>
								<input type="text" name="<?php echo $this->get_field_name( 'link_text' ); ?>" id="<?php echo $this->get_field_id( 'link_text' ); ?>" value="<?php echo esc_attr( $instance['link_text'] ); ?>" class="widefat">
							</p>
							<?php
							break;
						case 'text' :
							?>
							<p>
								<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:', 'bucketwidget' ); ?></label>
								<textarea name="<?php echo $this->get_field_name( 'text' ); ?>" id="<?php echo $this->get_field_id( 'text' ); ?>" rows="4" class="widefat"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
							</p>
							<?php
							break;
						default :
							// Custom fields can be added using this action.
							do_action( 'bucket_widget_field-' . sanitize_key( $field ), $instance, $this );
					}
				}
			}
			do_action( 'bucket_widget_form_after', $instance, $this->id_base );
			?>
		</div>
		<?php
	}
	/**
	 * The list of extra fields that should be shown in the widget form.
	 *
	 * Can be easily overloaded by a child class.
	 *
	 * @since 3.0.0
	 */
	function form_fields() {
		return array( 'image_size', 'link', 'link_text', 'text' );
	}
	/**
	 * Save widget settings.
	 *
	 * @since 3.0.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( $new_instance, $old_instance );
		$instance = apply_filters( 'bucket_widget_instance', $instance, $new_instance, $old_instance, $this->id_base );
		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );
		$instance['image_id'] = absint( $new_instance['image_id'] );
		$instance['link'] = esc_url_raw( $new_instance['link'] );
		$instance['link_text'] = wp_kses_data( $new_instance['link_text'] );
		$instance['new_window'] = isset( $new_instance['new_window'] );
		$instance['text'] = wp_kses_data( $new_instance['text'] );
		$instance['image'] = esc_url_raw( $new_instance['image'] ); // Legacy image URL.
		if ( empty( $instance['image'] ) ) {
			unset( $instance['image'] );
		}
		$instance['alt'] = wp_strip_all_tags( $instance['alt'] ); // Legacy alt text.
		if ( empty( $instance['alt'] ) ) {
			unset( $instance['alt'] );
		}
		$this->flush_widget_cache();
		return $instance;
	}
	/**
	 * Get the various sizes of an images.
	 *
	 * @since 3.0.0
	 *
	 * @param int $image_id Image attachment ID.
	 * @return array List of image size keys and their localized labels.
	 */
	function get_image_sizes( $image_id ) {
		$sizes = array( 'full' => __( 'Full Size', 'bucketwidget' ) );
		$imagedata = wp_get_attachment_metadata( $image_id );
		if ( isset( $imagedata['sizes'] ) ) {
			$size_names = Bucket_Widget_Loader::get_image_size_names();
			$sizes['full'] .= ( isset( $imagedata['width'] ) && isset( $imagedata['height'] ) ) ? sprintf( ' (%d&times;%d)', $imagedata['width'], $imagedata['height'] ) : '';
			foreach( $imagedata['sizes'] as $_size => $data ) {
				$label  = ( isset( $size_names[ $_size ] ) ) ? $size_names[ $_size ] : ucwords( $_size );
				$label .= sprintf( ' (%d&times;%d)', $data['width'], $data['height'] );
				$sizes[ $_size ] = $label;
			}
		}
		return $sizes;
	}
	/**
	 * Remove a single image widget from the cache.
	 *
	 * @since 3.0.0
	 */
	function flush_widget_cache() {
		$cache = (array) wp_cache_get( 'bucket_widget', 'widget' );
		if ( isset( $cache[ $this->id ] ) ) {
			unset( $cache[ $this->id ] );
		}
		wp_cache_set( 'bucket_widget', array_filter( $cache ), 'widget' );
	}
	/**
	 * Flush the cache for all image widgets.
	 *
	 * @since 3.0.0
	 */
	function flush_group_cache( $post_id = null ) {
		if ( 'save_post' == current_filter() && 'attachment' != get_post_type( $post_id ) ) {
			return;
		}
		wp_cache_delete( 'bucket_widget', 'widget' );
	}
}





/*
 * Load the plugin when plugins are loaded.
 */
add_action( 'widgets_init', array( 'Bucket_Widget_Loader', 'load' ) );

/*
 * The main plugin class for loading the widget and attaching necessary hooks.
 */
class Bucket_Widget_Loader {
	/*
	 * Setup functionality needed by the widget.
	 */
	public static function load() {
		add_action( 'widgets_init', array( __CLASS__, 'register_widget' ) );
		add_action( 'init', array( __CLASS__, 'init' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
		add_action( 'admin_head-widgets.php', array( __CLASS__, 'admin_head_widgets' ) );
		add_action( 'admin_footer-widgets.php', array( __CLASS__, 'admin_footer_widgets' ) );
	}
	
	
	/*
	 * Register and localize generic script libraries.
	 */
	public static function init() {
		wp_register_script( 'bucketwidget', plugin_dir_url( __FILE__ ) . 'js/bucketwidget.js', array( 'media-upload', 'media-views' ) );
		
		wp_localize_script( 'bucketwidget', 'SimpleImageWidget', array(
			'frameTitle'      => __( 'Choose an Attachment', 'bucketwidget' ),
			'frameUpdateText' => __( 'Update Attachment', 'bucketwidget' ),
			'fullSizeLabel'   => __( 'Full Size', 'bucketwidget' ),
			'imageSizeNames'  => self::get_image_size_names()
		) );
	}
	
	/**
	 * Register the image widget.
	 *
	 * @since 3.0.0
	 */
	public static function register_widget() {
		register_widget( 'Bucket_Widget' );
	}
	
	/**
	 * Enqueue scripts needed for selecting media.
	 *
	 * @since 3.0.0
	 */
	public static function admin_scripts( $hook_suffix ) {
		if ( 'widgets.php' == $hook_suffix ) {
			wp_enqueue_media();
			wp_enqueue_script( 'bucketwidget' );
		}
	}
	
	/**
	 * Output CSS for styling the image widget in the dashboard.
	 *
	 * @since 3.0.0
	 */
	public static function admin_head_widgets() {
		?>
		<style type="text/css">
		.widget .widget-inside .bucketwidget-form .bucketwidget-control { padding: 20px 0; text-align: center; border: 1px dashed #aaa;}
		.widget .widget-inside .bucketwidget-form .bucketwidget-control.has-image { padding: 10px; text-align: left; border: 1px dashed #aaa;}
		.widget .widget-inside .bucketwidget-form .bucketwidget-control img { display: block; margin-bottom: 10px; max-width: 100%; height: auto;}
		
		.bucketwidget-legacy-fields { margin-bottom: 1em; padding: 10px; background-color: #e0e0e0; border-radius: 3px;}
		.bucketwidget-legacy-fields p:last-child { margin-bottom: 0;}
		</style>
		<?php
	}
	
	/**
	 * Output custom handler for when an image is selected in the media manager.
	 *
	 * @since 3.0.0
	 */
	public static function admin_footer_widgets() {
		?>
		<script type="text/javascript">
		jQuery(function($) {
			$('#wpbody').on('selectionChange.bucketwidget', '.bucketwidget-control', function( e, selection ) {
				var $control = $( e.target ),
					$sizeField = $control.closest('.bucketwidget-form').find('select.image-size'),
					model = selection.first(),
					sizes = model.get('sizes'),
					size, image;
				
				if ( sizes ) {
					// The image size to display in the widget.
					size = sizes['post-thumbnail'] || sizes.medium;
				}
				
				if ( $sizeField.length ) {
					// Builds the option elements for the size dropdown.
					SimpleImageWidget.updateSizeDropdownOptions( $sizeField, sizes );
				}
				
				size = size || model.toJSON();
				
				image = $( '<img />', { src: size.url, width: size.width } );
						
				$control.find('img').remove().end()
					.prepend( image )
					.addClass('has-image')
					.find('a.bucketwidget-control-choose').removeClass('button-hero');
			});
		});
		var SimpleImageWidget;
		
		(function($) {
			SimpleImageWidget.updateSizeDropdownOptions = function( field, sizes ) {
				var currentValue = field.val(),
					options;
				
				if ( sizes ) {
					$.each( sizes, function( key, size ) {
						var name;
						
						if ( key in SimpleImageWidget.imageSizeNames ) {
							name = SimpleImageWidget.imageSizeNames[ key ];
						}
						
						options += '<option value="' + key + '">' + name + ' (' + size.width + '&times;' + size.height + ')</option>';
					});
				}
				
				if ( ! options ) {
					name = SimpleImageWidget.imageSizeNames['full'] || SimpleImageWidget.fullSizeLabel;
					options = '<option value="full">' + name + '</option>';
				}
				
				// Try to maintain the previously selected size if it still exists.
				field.html( options ).val( currentValue ).removeAttr('disabled');
			};
		})(jQuery);
		
		/**
		 * Media control frame popup.
		 */
		jQuery(function($) {
			var Attachment = wp.media.model.Attachment,
				$control, $controlTarget, mediaControl;
				
			mediaControl = {
				// Initialize a new media manager or return an existing frame.
				// @see wp.media.featuredImage.frame()
				frame: function() {
					if ( this._frame )
						return this._frame;
		
					this._frame = wp.media({
						title: $control.data('title') || SimpleImageWidget.frameTitle,
						library: {
							type: $control.data('media-type') || 'image'
						},
						button: {
							text: $control.data('update-text') || SimpleImageWidget.frameUpdateText
						},
						multiple: $control.data( 'select-multiple' ) || false
					});
					
					this._frame.on( 'open', this.updateLibrarySelection ).state('library').on( 'select', this.select );
					
					return this._frame;
				},
				
				// Update the control when an image is selected from the media library.
				select: function() {
					var selection = this.get('selection'),
						returnProperty = $control.data('return-property') || 'id';
					
					// Insert the selected attachment ids into the target element.
					if ( $controlTarget.length ) {
						$controlTarget.val( selection.pluck( returnProperty ) );
					}
					
					// Trigger an event on the control to allow custom updates.
					$control.trigger( 'selectionChange.bucketwidget', [ selection ] );
				},
				
				// Update the selected image in the media library based on the image in the control.
				updateLibrarySelection: function() {
					var selection = this.get('library').get('selection'),
						attachment, selectedIds;
					
					if ( $controlTarget.length ) {
						selectedIds = $controlTarget.val();
						if ( selectedIds && '' !== selectedIds && -1 !== selectedIds && '0' !== selectedIds ) {
							attachment = Attachment.get( selectedIds );
							attachment.fetch();
						}
					}
					
					selection.reset( attachment ? [ attachment ] : [] );
				},
				
				init: function() {
					$('#wpbody').on('click', '.bucketwidget-control-choose', function(e) {
						var targetSelector;
						
						e.preventDefault();
						
						$control = $(this).closest('.bucketwidget-control');
						
						targetSelector = $control.data('target') || '.bucketwidget-control-target';
						if ( 0 === targetSelector.indexOf('#') ) {
							// Context doesn't matter if the selector is an ID.
							$controlTarget = $( targetSelector );
						} else {
							// Search for other selectors within the context of the control.
							$controlTarget = $control.find( targetSelector );
						}
						
						mediaControl.frame().open();
					});
				}
			};
			
			mediaControl.init();
		});
				</script>
		<?php	
	}
	
	/**
	 * Get localized image size names.
	 *
	 * The 'image_size_names_choose' filter exists in core and should be
	 * hooked by plugin authors to provide localized labels for custom image
	 * sizes added using add_image_size().
	 *
	 * @see image_size_input_fields()
	 * @see http://core.trac.wordpress.org/ticket/20663
	 *
	 * @since 3.0.0
	 */
	public static function get_image_size_names() {
		return apply_filters( 'image_size_names_choose', array(
			'thumbnail' => __( 'Thumbnail', 'bucketwidget' ),
			'medium'    => __( 'Medium', 'bucketwidget' ),
			'large'     => __( 'Large', 'bucketwidget' ),
			'full'      => __( 'Full Size', 'bucketwidget' )
		) );
	}
}
?>