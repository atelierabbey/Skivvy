<?php if ( ! class_exists( 'skivvy_websiteoptions' ) ) { class skivvy_websiteoptions {

/*
**
**		Initialization functions
**
*/

		static $version = '26Feb13';

		function __construct() {
				add_action( 'admin_init', 'skivvy_websiteoptions::theme_options_init');
				add_action( 'admin_menu', 'skivvy_websiteoptions::theme_options_add_page'); 
				add_action('wp_before_admin_bar_render', 'skivvy_websiteoptions::theme_options_admin_bar', 0); // Adds Menu item under site name
				add_shortcode( 'socialbox', 'skivvy_websiteoptions::socialbox_shortcode');
				global $list_o_social;
					if (!isset( $list_o_social ))	$list_o_social = array( 'RSS', 'Etsy', 'Facebook', 'Flickr', 'Google Plus', 'Instagram', 'LinkedIn', 'Pinterest', 'Twitter', 'Vimeo', 'Youtube', 'Extra 1', 'Extra 2', 'Extra 3', 'Extra 4', 'Extra 5', 'Extra 6', 'Extra 7' );
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
				global $icon_location;
				global $version;
				$options = get_option( 'clientcms_options' );



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
											'<span class="icon"><img src="' . $icon_location .'phone.png" ></span>'.
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
											'<span class="icon"><img src="' . $icon_location . 'fax.png" ></span>'.
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
											'<span class="icon"><img src="' . $icon_location . 'email.png" ></span>'.
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
											'<span class="icon"><img src="' . $icon_location . 'addr.png"></span>'.
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
											'<span class="icon"><img src="' . $icon_location . $option_value['slug'] . '.png" /></span>'.
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

	// Social Image Location
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
			// RENDER - Socialbox - open
				switch ($style) {
					case 'link' : $style_class = 'social_link'; break;
					case 'text' : $style_class = 'social_text'; break;
					case 'svg' : $style_class = 'social_svg'; break;
					case 'png' : $style_class = 'social_icon'; break;
				}
				$socialbox_open = '<ul class="socialbox ' . $class . ' ' . $style_class . '">';




			// RENDER - Socialbox - Items
				foreach( $option_output as $option_item ) {
					// Item Variables
						$item_slug = $option_item['slug'];
						$item_type = $option_item['option_type']; // phone, fax, addr, email, or social
						$item_value = $options_object[ $option_item['slug_value'] ];
						$item_display = $option_item['display']; 

					 // These values are temporary. But, if is selected by Key, and no value is to replace it, it will produce the value.
						$item_href = '#';
						$item_title_alt = $item_middle = $item_display;

						if ( !empty($key) OR $item_value AND $options_object[$option_item['add_value']] ) :

										if ( $delimiter == '') $delimiter = null;

										// PHONE & FAX
											if ( $item_value && $item_type == 'phone' || $item_type == 'fax' ) :
													
													$phone = explode(" ", $item_value);
													if     ($custom)	: $formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
													elseif ($delimiter)	: $formatted = $phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
													else				: $formatted = '('.$phone[1].') '.$phone[2].'-'.$phone[3];
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
													$item_middle = $formatted;
											endif;
										// End PHONE & FAX


										// ADDRESSES
											if ( $item_value && $item_type == 'addr' ) :

													$address = explode(",", $item_value);
													$str = $formatted = '';
													foreach ($address as $addr){
														$str .= $addr;
													}


													if ($custom) {
															$formatted = str_replace(array('$a','$b','$c','$d','$e','$f','$g','$h'), $address, $custom );
													} elseif ($delimiter) {
															$i = 0;
															foreach ($address as $addr){
																		$formatted .= $addr;
																		$str .= $addr;
																		if ( $addr !== count($address) ) {
																			if ( $delimiter ) $formatted .= $delimiter; else $formatted .= ', ';
																			$str .= ' ';
																		}
															}
													} else {
														$addr_middles  = $address[0]; // Street
														$addr_middles .= '<br>';
														$addr_middles .= $address[1]; // City
														$addr_middles .= ', ';
														$addr_middles .= $address[2]; // State
														$addr_middles .= $address[3]; // Zip
													}
													$item_href = 'https://maps.google.com/?q='.$str;
													$item_title_alt = "Map it - {$item_value}";
													$item_middle = $addr_middles;
											endif;
										// End ADDRESSES


										// EMAIL
											if ( $item_value && $item_type == 'email' ) :
													$item_href = "mailto:{$item_value}";
													$item_title_alt = "Email - {$item_value}";
													$item_middle = $item_value;
											endif;
										// End EMAIL


										// SOCIAL
											if ( $item_value && $item_type == 'social' ) :
													$item_href = "{$item_value}";
													
													$item_title_alt = "Visit - {$item_display}";
													if ($item_slug == 'rss')
															$item_title_alt = "Follow - {$item_display}";
													$item_middle = $item_display;
											endif;
										// End SOCIAL



							// ITEM Wrappers

							if ( $style === 'text' ) {
									$item_start = '<li class="socialbox_' . $item_slug . ' socialbox_' . $item_type .'"><span>';
									$item_end = '</span></li>';
							} else {
									$item_start = '<li class="socialbox_' . $item_slug . ' socialbox_' . $item_type .'"><a href="'. $item_href .'" target="_blank" title="' . $item_title_alt . '">';
									$item_end = '</a></li>';
							}


							// OUTPUT - Item
							$socialbox_middle .= $item_start_wrap . $item_start . $item_middle . $item_end . $item_end_wrap;
						endif; } 





			// RENDER - Socialbox close
			$socialbox_close .= '</ul>';





	// OUTPUT - Socialbox
	return $socialbox_open . $socialbox_middle . $socialbox_close;
}















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
		if ( preg_match('/fax/', $slugged) ) $option_type = 'fax';
		if ( preg_match('/addr/', $slugged) ) $option_type = 'addr';
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