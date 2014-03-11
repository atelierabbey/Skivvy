<?php if ( ! class_exists( 'skivvy_websiteoptions' ) ) { class skivvy_websiteoptions {

/*
**
**		Initialization functions
**
*/

		static $version = '27Feb13';

		function __construct() {
				add_action( 'admin_init', 'skivvy_websiteoptions::theme_options_init');
				add_action( 'admin_menu', 'skivvy_websiteoptions::theme_options_add_page'); 
				add_action('wp_before_admin_bar_render', 'skivvy_websiteoptions::theme_options_admin_bar', 0); // Adds Menu item under site name
				add_action( 'wp_enqueue_scripts', 'skivvy_websiteoptions::socialbox_styles' ); // enqueues front-end style
				add_action( 'admin_enqueue_scripts', 'skivvy_websiteoptions::socialbox_styles' ); // enqueues admin style
				add_shortcode( 'socialbox', 'skivvy_websiteoptions::socialbox_shortcode');
				global $list_o_social;
					if (!isset( $list_o_social ))	$list_o_social = array( 'RSS', 'Etsy', 'Facebook', 'Flickr', 'Google Plus', 'Instagram', 'LinkedIn', 'Pinterest', 'Twitter', 'Vimeo', 'Youtube' );
				global $icon_location;
					if (!isset( $icon_location ))	$icon_location = get_bloginfo('template_url').'/img/social/';
		}

	// Register the Options group
		static function theme_options_init() {
			register_setting( 'skivvy_options', 'clientcms_options');
		}

	// Register the Options page
		static function theme_options_add_page() {
			add_theme_page(
				'Website Options', // Page Title
				'Website Options', // Menu Title
				'edit_theme_options', // Capability
				'website_options', // menu slug
				'skivvy_websiteoptions::render_website_options'
			);
		}

	// Register 'socialbox.css'
		public function socialbox_styles() {
			global $version;
			wp_register_style( 'socialbox_style', get_bloginfo('template_url').'/css/socialbox.css', false, $version );
			wp_enqueue_style( 'socialbox_style' );
		}

	// Add menu item to admin bar
		static function theme_options_admin_bar() {
			global $wp_admin_bar;
			$wp_admin_bar->add_menu( array(
				'parent' => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
				'id' => 'website_options', // link ID, defaults to a sanitized title value
				'title' => __('Website Options'), // link title
				'href' => admin_url( 'themes.php?page=website_options'), // name of file
				'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
			));
		}




















/*
**
**		Render Website Options Page
**
*/
function render_website_options() {

				global $select_options;
				global $list_o_social;
				global $version;
				$options = get_option( 'clientcms_options' );

				echo('
					<style>/* Website options */
						.skivvy-optionsupdate h3 {
							background: none repeat scroll 0 0 #008000;
							border-radius: 5px;
							color: #FFFFFF;
							padding: 5px;
							text-align: center;
							width: 250px;
						}
						.skivvy-optionrow {
							line-height: 42px;
						}
						.skivvy-optionrow span {
							display: block;
							float: left;
						}
						.skivvy-optionrow .name {
							display: inline-block;
							width: 80px;
						}
						.skivvy-weboptions-admin-fields input {
							text-align: center;
							border-radius: 5px;
							padding: 0px;
						}
						.skivvy-option-addr .input input {
							width: 600px;
					}
					</style>');

				echo '<div class="wrap skivvy-websiteoptions">';
					screen_icon();
					echo '<h2>Website Options</h2>';



					if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;
					if ( false !== $_REQUEST['settings-updated'] ) echo '<div class="skivvy-optionsupdate"><h3>Options saved</h3></div>';




					echo '<form method="post" action="options.php">';
						settings_fields( 'skivvy_options' );



						echo '<h2>Contact Information</h2>';




					// Set number of Phones, Faxes, Emails, & Addresses

						if ( $options["number_of_phone"]   ) { $total_phone = $options["number_of_phone"]; } else { $total_phone = 2; }
						if ( $options["number_of_fax"]     ) { $total_fax = $options["number_of_fax"]; } else { $total_fax = 1; }
						if ( $options["number_of_email"]   ) { $total_email = $options["number_of_email"]; } else { $total_email = 2; }
						if ( $options["number_of_address"] ) { $total_addr = $options["number_of_address"]; } else { $total_addr = 2; }

						if ( current_user_can('edit_themes') ) {
							echo (
									'<div class="skivvy-weboptions-admin-fields">'.
										'Phones: <input id="clientcms_options[number_of_phone]" type="text" name="clientcms_options[number_of_phone]" value="'.$total_phone.'"  size="2"> | '.
										'Faxes: <input id="clientcms_options[number_of_fax]" type="text" name="clientcms_options[number_of_fax]" value="'.$total_fax.'"  size="2"> | '.
										'Emails: <input id="clientcms_options[number_of_email]" type="text" name="clientcms_options[number_of_email]" value="'.$total_email.'"  size="2"> | '.
										'Addresses: <input id="clientcms_options[number_of_address]" type="text" name="clientcms_options[number_of_address]" value="'.$total_addr.'"  size="2">'.
									'<div class="clear"></div></div>'
								);
						}


							// PHONES
								echo '<h3>Phone</h3>'.'<small>Please use spaces to seperate the sections of digits; (i.e. "1 555 444 7777" )</small>';
								for( $i = 1; $i <= $total_phone; $i++ ) {

									$option_value = self::optionafier( "phone{$i}" );

									if ( 1 == $options[$option_value['add_value']] && $options[ $option_value['slug_value']] ) { $checked = 'checked="checked"'; } else { $checked = ''; }

									echo (
										'<div class="skivvy-optionrow skivvy-option-phone skivvy-contact-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options['. $option_value['add_value'] .']" type="checkbox" value="1" name="clientcms_options['. $option_value['add_value'] .']"'. $checked .'></span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='png']").'</span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='svg']").'</span>'.
											'<span class="name">'. $option_value['display'] .'</span>'.
											'<span class="input"><input id="clientcms_options['.  $option_value['slug_value'] .']" type="text" name="clientcms_options['.  $option_value['slug_value'] .']" placeholder="1 222 333 4444" value="'.esc_attr( $options[ $option_value['slug_value'] ] ).'" ></span>'.
										'<div class="clear"></div></div>'
									);
								}


							// FAX
								echo '<h3>FAX</h3><small>Please use spaces to seperate the sections of digits; (i.e. "1 555 444 7777" )</small>';
								for( $i = 1; $i <= $total_fax; $i++ ) {

									$option_value = self::optionafier( "fax{$i}" );

									if ( 1 == $options[ $option_value['add_value'] ] && $options[ $option_value['slug_value'] ] ) { $checked = 'checked="checked"'; } else { $checked = '';}

									echo (
										'<div class="skivvy-optionrow skivvy-option-fax skivvy-contact-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options['. $option_value['add_value'] .']" type="checkbox" value="1" name="clientcms_options['. $option_value['add_value'] .']"'. $checked .'></span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='png']").'</span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='svg']").'</span>'.
											'<span class="name">'. $option_value['display'] .'</span>'.
											'<span class="input"><input id="clientcms_options['. $option_value['slug_value'] .']" type="text" name="clientcms_options['. $option_value['slug_value'] .']" placeholder="1 222 333 4444" value="'.esc_attr( $options[ $option_value['slug_value'] ] ).'" ></span>'.
										'<div class="clear"></div></div>'
									);
								}


							// EMAILS
								echo '<h3>Email</h3>';
								for( $i = 1; $i <= $total_email; $i++ ) {

									$option_value = self::optionafier( "email{$i}" );

									if ( 1 == $options[$option_value['add_value']] && $options[$option_value['slug_value']] ) { $checked = 'checked="checked"'; } else { $checked = ''; }

									echo (
										'<div class="skivvy-optionrow skivvy-option-email skivvy-contact-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options['. $option_value['slug_value'] .']" type="checkbox" value="1" ' . $checked . ' name="clientcms_options['. $option_value['add_value'] .']"></span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='png']").'</span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='svg']").'</span>'.
											'<span class="name">'. $option_value['display'] . '</span>'.
											'<span class="input"><input id="clientcms_options['. $option_value['slug_value'] .']" type="text" name="clientcms_options['. $option_value['slug_value'] .']" value="' . esc_attr( $options[ $option_value['slug_value'] ] ) . '" ></span>'.
										'<div class="clear"></div></div>'
									);
								}


							// ADDRESSES
								echo '<h3>Address</h3><small>Please use commas to seperate the address sections; (i.e. "123 Te St., Testington, Testonia, 555555, USA" )</small>';
								for( $i = 1; $i <= $total_addr; $i++ ) {

									$option_value = self::optionafier( "addr{$i}" );

									if ( 1 == $options[$option_value['add_value']] ) { $checked = 'checked="checked"'; } else { $checked = '';}

									echo (
										'<div class="skivvy-optionrow skivvy-option-addr skivvy-contact-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options[' . $option_value['add_value'] . ']" type="checkbox" value="1" ' . $checked . ' name="clientcms_options[' . $option_value['add_value'] . ']"></span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='png']").'</span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='svg']").'</span>'.
											'<span class="name">'. $option_value['display'] .'</span>'.
											'<span class="input">'. 
												'<input id="clientcms_options['. $option_value['slug_value'] .']" type="text" name="clientcms_options['. $option_value['slug_value'] .']" value="' . esc_attr( $options[$option_value['slug_value']] ) . '" >'.
											'</span>'.
										'<div class="clear"></div></div>'
									);
								}







						echo '<hr>'.
							 '<h3>Social Media</h3>';

							//SOCIAL
								foreach($list_o_social as $social){

									$option_value = self::optionafier( $social );

									if ( 1 == $options[$option_value['add_value']] && $options[$option_value['slug_value']] ) { $checked = 'checked="checked"'; } else { $checked = ''; }

									$readonly = '';
									$message = '';
									if ( $option_value['slug'] == 'rss'  ) {
										if ( $options[$option_value['slug_value']] == '') { $options[$option_value['slug_value']] = get_bloginfo('rss2_url'); }
										//$readonly = 'readonly'
										$message = ' <small>Note: Changing RSS does not change the default RSS value. If erased, returns to default rss 2</small>';
									}

									echo (
										'<div class="skivvy-optionrow skivvy-optionsocial skivvy-social-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options['.$option_value['add_value'].']" type="checkbox" value="1" '.$checked.' name="clientcms_options['.$option_value['add_value'].']"></span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='png']").'</span>'.
											'<span class="icon">'.do_shortcode("[socialbox key='{$option_value['slug']}' style='svg']").'</span>'.
											'<span class="name">'.$option_value['display'].'</span>'.
											'<span class="input"><input id="clientcms_options['.$option_value['slug_value'].']" type="text" size="50" name="clientcms_options['.$option_value['slug_value'].']" value="'. esc_attr( $options[$option_value['slug_value']] ) .'" '. $readonly. '>'.$message.'</span>'.
										'<div class="clear"></div></div>'
										);

								}




						submit_button();

					echo '</form>';
					echo '<div>Website Options Version: ' . self::$version . '</div>';
				echo '</div>';


}




















/*
**
**
**	Shortcodes - [socialbox]
**		Variables
**			// Shortcode options
**					@	$key				- comma seperated values of which items to render
**					@	$style				- Options : 'png' | 'svg' | 'text' = outputs only text, no link. | 'link', nolist
**					@	$class				- Custom class attributes
**					@	$custom				- Examples: for phone = +$a,$b/$c*$d  |  for addr = $street1, $street2 <br> $city, $state <br> $zip  | for others =>
**					@	$delimiter			- any character to delimit. Works only with phone, fax, or address
**			// Global variables
**					@	$list_o_social		- array of social items
**			// Locally defined Variables
**					@	$options_object		- array of all set options
**					@	$total_phone		- Limits the number of generated phone output, if set in Website Options, use saved value, default = 2
**					@	$total_fax			- Limits fax, default 1
**					@	$total_email		- Limits email, default 2
**					@	$total_addr			- Limits addresses, default 2
**			// Generated variables
**					@	$socialbox_types	- array of possible outputs. Defined via $key if not empty, else generates all
**					@	$option_output		- array of arrays. DEFINED by optionafier() each $socialbox_types
**					@	$style_class		- DEFINED by $style, if empty, defaults to 'social_icon'
**					@	$socialbox_result	- Generated result of all items
**
*/
function socialbox_shortcode( $atts ){


	// Shortcode attributes
		extract( shortcode_atts( array(
			'key' => '',
			'style' => 'png',
			'class' => '',
			'custom' => '',
			'delimiter' => ''
		), $atts ) );


	//	Get list of max options
		global $list_o_social;
		$options_object = get_option( 'clientcms_options' );
		if ( $options["number_of_phone"]   ) { $total_phone = $options["number_of_phone"]; } else { $total_phone = 2; }
		if ( $options["number_of_fax"]     ) { $total_fax = $options["number_of_fax"]; } else { $total_fax = 1; }
		if ( $options["number_of_email"]   ) { $total_email = $options["number_of_email"]; } else { $total_email = 2; }
		if ( $options["number_of_address"] ) { $total_addr = $options["number_of_address"]; } else { $total_addr = 2; }

	// Icon Location
		global $icon_location;

	// Create Option array
		if ( !empty($key) ) {
			$socialbox_types = explode(",", $key);
		} else {
			$socialbox_types = array();
			foreach( $list_o_social as $social    ) $socialbox_types[] = $social;
			for( $x = 1; $x <= $total_addr;  $x++ ) $socialbox_types[] = "Addr {$x}";
			for( $x = 1; $x <= $total_email; $x++ ) $socialbox_types[] = "Email {$x}";
			for( $x = 1; $x <= $total_fax;   $x++ ) $socialbox_types[] = "Fax {$x}";
			for( $x = 1; $x <= $total_phone; $x++ ) $socialbox_types[] = "Phone {$x}";
		}
		$option_output = array();
		foreach ($socialbox_types as $type)
				$option_output[] = self::optionafier( $type );





	/*
	**
	**		RENDER SOCIALBOX
	**
	*/
		// RENDER each Item
		$item_number = 1;
		foreach( $option_output as $option_item ) :
			// Item Variables
				$item_slug = $option_item['slug'];
				$item_type = $option_item['option_type']; // phone, fax, addr, email, or social
				$item_value = $options_object[ $option_item['slug_value'] ];
				$item_display = $option_item['display']; 
				$item_href = '#';
				$item_title_alt = $formatted = $item_middle = $item_display;

				if ( !empty($key) OR $item_value AND $options_object[$option_item['add_value']] ) :


							// ------ PHONE & FAX ------ //
								if ( $item_value && $item_type == 'phone' || $item_type == 'fax' ) :
											$phone = explode(" ", $item_value);
											if     ($custom)	: $formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
											elseif ($delimiter)	: $formatted = $phone[0].$delimiter.$phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
											else				: $formatted = $phone[0].' ('.$phone[1].') '.$phone[2].'-'.$phone[3];
											endif;
											if ( $item_type == 'fax') {
												$item_href ='fax:+';
												$item_title_alt ='Facsimile - ';
											} else {
												$item_href = 'tel:+';
												$item_title_alt = "Telephone - ";
											};
											$item_href .= $phone[0].$phone[1].$phone[2].$phone[3];
											$item_title_alt .= "{$formatted}";
								endif; // End PHONE & FAX



							// ------ ADDRESSES ------ //
								if ( $item_value && $item_type == 'addr' ) :
											$address = explode(",", $item_value);
											$str = $formatted = '';
											foreach ($address as $addr){
												$str .= $addr;
											}
										// Custom Format
											if ($custom) {
													$formatted = str_replace(array('$a','$b','$c','$d','$e','$f','$g','$h'), $address, $custom );
										// Delimited format
											} elseif ($delimiter) {
													$i = 0;
													foreach ($address as $addr){
																$formatted .= $addr;
																if ( $i++ !== count($address)-1 )
																	$formatted .= $delimiter;
													}
										// Standard Format
											} else {
												$formatted  = $address[0]; // Street
												$formatted .= '<br>';
												$formatted .= $address[1]; // City
												$formatted .= ', ';
												$formatted .= $address[2]; // State
												$formatted .= $address[3]; // Zip
											}
											$item_href = 'https://maps.google.com/?q='.$str;
											$item_title_alt = "Map it - {$item_value}";
								endif; // End ADDRESSES



							// ------ EMAIL ------ //
								if ( $item_type == 'email' ) :
											$item_href = "mailto:{$item_value}";
											$item_title_alt = "Email - {$item_value}";
											$formatted = $item_value;
								endif; // End EMAIL



							// ------ SOCIAL ------ //
								if ($item_type == 'social' ) :
										$item_title_alt = "Follow on {$item_display}";
										$formatted = $item_display;
										if ( $item_value )
												$item_href = "{$item_value}";
								endif; // End SOCIAL



						// OUTPUT - Item
							$item_start = '<a href="'. $item_href .'" target="_blank" title="' . esc_attr($item_title_alt) . '">';
							$item_end = '</a>';
							switch ($style) {
									case 'link':
												$style_class = 'social_text social_link';
												$item_middle = $formatted;
												break;
									case 'text':
												$style_class = 'social_text social_txt';
												$item_middle = $formatted;
												$item_start = '<span>';
												$item_end = '</span>';
												break;
									case 'svg':
												$style_class = 'social_icon social_svg';

												// Get SVG icon w/ fallback PNG
													$slug_svg = $icon_location.$item_slug.'.svg';
													$type_svg = $icon_location.$item_type.'.svg';
													$slug_png = $icon_location.$item_slug.'.png';
													$type_png = $icon_location.$item_type.'.png';
													if ( file_exists ( $slug_file ) || $item_type === 'social' ) {
														$output = stream_get_contents(fopen($slug_svg,"r") );
													} else {
														$output = stream_get_contents(fopen($type_svg,"r") );
													}
													if (file_exists ( $slug_png ) || $item_type === 'social' ) {
														$fallback = '<foreignObject><img src="'.$slug_png.'" alt="'.$item_type.'"></foreignObject></svg>';
													} else {
														$fallback = '<foreignObject><img src="'.$type_png.'" alt="'.$item_type.'"></foreignObject></svg>';
													}
													$item_middle = str_replace( '</svg>', $fallback, $output );
												break;
									case 'png':
												$style_class = 'social_icon social_png';

												// Get PNG icon
													$slug_png = $icon_location.$item_slug.'.png';
													$type_png = $icon_location.$item_type.'.png';
													if (file_exists ( $slug_png ) || $item_type === 'social' ) {
														$item_middle = '<img src="'.$slug_png.'" alt="'.$item_type.'">';
													} else {
														$item_middle = '<img src="'.$type_png.'" alt="'.$item_type.'">';
													}
												break;
							}
							$item_start_wrap = '<li class="socialitem_' . $item_number . ' socialbox_' . $item_slug .  ' socialbox_' . $item_type .'">';
							$item_end_wrap   = '</li>';
					$socialbox_middle .= $item_start_wrap . $item_start . $item_middle . $item_end . $item_end_wrap;
					$item_number++;
				endif;
		endforeach;





	// Socialbox output
		$socialbox_open   = '<ul class="socialbox ' . $class . ' ' . $style_class . '">';
		$socialbox_close .= '</ul>';

		return $socialbox_open . $socialbox_middle . $socialbox_close;
}









/*


static function render_socialbox_icon_png() {
		// Output SVG w/ PNG fallback
			$slug_svg = $icon_location.$item_slug.'.svg';
			$type_svg = $icon_location.$item_type.'.svg';
			$slug_png = $icon_location.$item_slug.'.png';
			$type_png = $icon_location.$item_type.'.png';
			if ( file_exists ( $slug_file ) || $item_type === 'social' ) {
				$output = stream_get_contents(fopen($slug_svg,"r") );
			} else {
				$output = stream_get_contents(fopen($type_svg,"r") );
			}
			if (file_exists ( $slug_png ) || $item_type === 'social' ) {
				$fallback = '<foreignObject><img src="'.$slug_png.'" alt="'.$item_type.'"></foreignObject></svg>';
			} else {
				$fallback = '<foreignObject><img src="'.$type_png.'" alt="'.$item_type.'"></foreignObject></svg>';
			}
			$item_middle = str_replace( '</svg>', $fallback, $output );
		
		
		// Output PNG
			$slug_png = $icon_location.$item_slug.'.png';
			$type_png = $icon_location.$item_type.'.png';
			if (file_exists ( $slug_png ) || $item_type === 'social' ) {
				$item_middle = '<img src="'.$slug_png.'" alt="'.$item_type.'">';
			} else {
				$item_middle = '<img src="'.$type_png.'" alt="'.$item_type.'">';
			}
}
static function render_icon_svg() {

}
//*/








/*
	// $option_value = self::optionafier( $input )
	// $option_value['display']
	// $option_value['slug']
	// $option_value['slug_value']
	// $option_value['add_value']
	// $option_value['option_type']
*/
static function optionafier( $input ) {

		global $list_o_social;

		$display = ucfirst(strtolower(str_replace(' ', '', $input)));
		$slugged = sanitize_title(str_replace(' ', '', $input));

		if ( preg_match('/phone/', $slugged) ) $option_type = 'phone';
		if ( preg_match('/fax/'  , $slugged) ) $option_type = 'fax';
		if ( preg_match('/addr/' , $slugged) ) $option_type = 'addr';
		if ( preg_match('/email/', $slugged) ) $option_type = 'email';
		foreach ( $list_o_social as $social ) {
					if ( strpos( sanitize_title(str_replace(' ', '', $social)), $slugged ) !== false ) {
							$option_type = 'social';
							$display = $social;
					}
		}

		return array (
			'display' => $display,						// Standardized User identifier, not used in any algorithm. 
			'slug' => $slugged ,						// Used in identifing css
			'slug_value' => $slugged .'_value',			// Used in form creation
			'add_value' => $slugged . '_add_value',		// Used in form creation
			'option_type' => $option_type				// Identifies what type of data it is. OUTPUTS phone, fax, addr, email, or social
		);
}

}}?>