<?php if ( ! class_exists( 'skivvy_websiteoptions' ) ) { class skivvy_websiteoptions {

	# TEMP NOTES
	# Address Shortcode
	# Add fax & Address icons
	# Add Custom (for address & Phone)
	# Deprecate all old text functions
	# Deprecate formatting functions, integrate with socialbox.

	/////// [ Belt line ] //////  Not touching below the belt, keep it PG.



/*
**
**			Initialization functions
**
*/

	static $version = '11Feb13';

	// Construct initializtion
		function __construct() {

			add_action( 'admin_init', 'skivvy_websiteoptions::theme_options_init');
			add_action( 'admin_menu', 'skivvy_websiteoptions::theme_options_add_page'); 
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

						if ( is_admin() ) {
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
											'<span class="icon"><img src="' . $icon_location . $option_value['slug'] . '.png" ></span>'.
											'<span class="name">'. $option_value['display'] .'</span>'.
											'<span class="input"><input id="clientcms_options['.  $option_value['slug_value'] .']" type="text" name="clientcms_options['.  $option_value['slug_value'] .']" placeholder="1 222 333 4444" value="'.esc_attr( $options[ $option_value['slug_value'] ] ).'" ></span>'.
										'<div class="clear"></div></div>'
									);
								}







							// FAX
								echo '<h3>FAX</h3>'.'<small>Please use spaces to seperate the sections of digits; (i.e. "1 555 444 7777" )</small>';
								for( $i = 1; $i <= $total_fax; $i++ ) {

									$option_value = self::optionafier( "fax{$i}" );

									if ( 1 == $options[ $option_value['add_value'] ] && $options[ $option_value['slug_value'] ] ) { $checked = 'checked="checked"'; } else { $checked = '';}

									echo (
										'<div class="skivvy-optionrow skivvy-option-fax skivvy-contact-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options['. $option_value['add_value'] .']" type="checkbox" value="1" name="clientcms_options['. $option_value['add_value'] .']"'. $checked .'></span>'.
											'<span class="icon"><img src="' . $icon_location . $option_value['slug'] . '.png" ></span>'.
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
											'<span class="icon"><img src="' . $icon_location . $option_value['slug'] .'.png" ></span>'.
											'<span class="name">'. $option_value['display'] . '</span>'.
											'<span class="input"><input id="clientcms_options['. $option_value['slug_value'] .']" type="text" name="clientcms_options['. $option_value['slug_value'] .']" value="' . esc_attr( $options[ $option_value['slug_value'] ] ) . '" ></span>'.
										'<div class="clear"></div></div>'
									);
								}






							// ADDRESSES
								echo '<h3>Address</h3>';
								for( $i = 1; $i <= $total_addr; $i++ ) {

									$option_value = self::optionafier( "addr{$i}" );

									if ( 1 == $options[$option_value['add_value']] ) { $checked = 'checked="checked"'; } else { $checked = '';}

									echo (
										'<div class="skivvy-optionrow skivvy-option-addr skivvy-contact-'. $option_value['slug'] .'">'.
											'<span class="add"><input id="clientcms_options[' . $option_value['add_value'] . ']" type="checkbox" value="1" ' . $checked . ' name="clientcms_options[' . $option_value['add_value'] . ']"></span>'.
											'<span class="icon"><img src="' . $icon_location . $option_value['slug'] . '.png"></span>'.
											'<span class="name">'. $option_value['display'] .'</span>'.
											'<span class="input">'. 
												'<input id="clientcms_options['. $option_value['slug_value'] .'_street1]" type="text" name="clientcms_options['. $option_value['slug_value'] .'_street1]" value="' . esc_attr( $options[$option_value['slug_value'] ."_street1"] ) . '" placeholder="Street 1">'.
												'<input id="clientcms_options['. $option_value['slug_value'] .'_street2]" type="text" name="clientcms_options['. $option_value['slug_value'] .'_street2]" value="' . esc_attr( $options[$option_value['slug_value'] ."_street2"] ) . '" placeholder="Street 2">'.
												'<input id="clientcms_options['. $option_value['slug_value'] .'_city]" type="text" name="clientcms_options['. $option_value['slug_value'] .'_city]" value="' . esc_attr( $options[$option_value['slug_value'] ."_city"] ) . '" placeholder="City">'.
												'<input id="clientcms_options['. $option_value['slug_value'] .'_state]" type="text" name="clientcms_options['. $option_value['slug_value'] .'_state]" value="' . esc_attr( $options[$option_value['slug_value'] ."_state"] ) . '" placeholder="State">'.
												'<input id="clientcms_options['. $option_value['slug_value'] .'_zip]" type="text" name="clientcms_options['. $option_value['slug_value'] .'_zip]" value="' . esc_attr( $options[$option_value['slug_value'] ."_zip"] ) . '" placeholder="Zip">'.
												'<input id="clientcms_options['. $option_value['slug_value'] .'_country]" type="text" name="clientcms_options['. $option_value['slug_value'] .'_country]" value="' . esc_attr( $options[$option_value['slug_value'] ."_country"] ) . '" placeholder="Country">'.
											'</span>'.
										'<div class="clear"></div></div>'
									);
								}







						echo '<hr>'.
							 '<h3>Social Media</h3>';


/*
							// RSS
								$option_value = self::optionafier( "RSS" );
								//$option_value['display'], $option_value['slug'], $option_value['slug_value'], $option_value['add_value']

								if( 1 == $options[ $option_value['add_value'] ] ) { $checked = 'checked="checked"'; } else { $checked = ''; }
								
								echo (
									'<div class="skivvy-optionrow skivvy-option-social skivvy-social-'.$option_value['slug'].'">'.
										'<span class="add"><input id="clientcms_options['. $option_value['add_value'] .']" type="checkbox" value="1" '.$checked.' name="clientcms_options['. $option_value['add_value'] .']"></span>'.
										'<span class="icon"><img src="' . $icon_location . $option_value['slug'] .'.png" /></span>'.
										'<span class="name">'. $option_value['display'] .'</span>'.
										'<span class="input"><input id="clientcms_options['.$option_value['slug_value'].']" type="text" size="50" name="clientcms_options['.$option_value['slug_value'].']" value="'.get_bloginfo('rss2_url') . '" readonly></span>'.
									'<div class="clear"></div></div>'
								); //*/


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
//*/
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































// $option_value = self::optionafier( $input )
	// $option_value['display']
	// $option_value['slug']
	// $option_value['slug_value']
	// $option_value['add_value']
	// $option_value['option_type']
static function optionafier( $input ) {

		global $list_o_social;


		$display = ucfirst(strtolower($input));
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












/*
**
**
**	Shortcodes - [socialbox]
**
**
*/
function socialbox_shortcode( $atts ){


		/*	Variables

				// Shortcode options
						@	$key				- comma seperated values of which items to render
						@	$style				- Options : 'png' | 'svg' | 'text' = outputs only text, no link. | 'link', nolist
						@	$class				- Custom class attributes
						@	$custom				- Examples: for phone = +$a,$b/$c*$d  |  for addr = $street1, $street2 <br> $city, $state <br> $zip  | for others =>
						@	$delimiter			- any character to delimit. Works only with phone, fax, or address


				// Global variables
						@	$list_o_social		- array of social items


				// Locally defined Variables
						@	$options_object		- array of all set options
						@	$total_phone		- Limits the number of generated phone output, if set in Website Options, use saved value, default = 2
						@	$total_fax			- Limits fax, default 1
						@	$total_email		- Limits email, default 2
						@	$total_addr			- Limits addresses, default 2


				// Generated variables
						@	$socialbox_types	- array of possible outputs. Defined via $key if not empty, else generates all
						@	$option_output		- array of arrays. DEFINED by optionafier() each $socialbox_types
						@	$style_class		- DEFINED by $style, if empty, defaults to 'social_icon'
						@	$socialbox_result	- Generated result of all items

		*/
		extract( shortcode_atts( array(
			'key' => '',
			'style' => '',
			'class' => '',
			'custom' => '',
			'delimiter' => ''
		), $atts ) );

		global $list_o_social;

		$options_object = get_option( 'clientcms_options' );

		if ( $options["number_of_phone"]   ) { $total_phone = $options["number_of_phone"]; } else { $total_phone = 2; }
		if ( $options["number_of_fax"]     ) { $total_fax = $options["number_of_fax"]; } else { $total_fax = 1; }
		if ( $options["number_of_email"]   ) { $total_email = $options["number_of_email"]; } else { $total_email = 2; }
		if ( $options["number_of_address"] ) { $total_addr = $options["number_of_address"]; } else { $total_addr = 2; }



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
					default : $style_class = 'social_icon'; break;
				}
				$socialbox_open = '<ul class="socialbox ' . $style_class . ' ' . $class . '">';




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

						if ( $options_object[$option_item['add_value']] && $item_value ) { $usable = true; } else { $usable = false; }
						if ( !empty($key) OR $usable ) :




								// Phone
									if ( $item_type == 'phone' && $item_value ) {
										
										$phone = explode(" ", $item_value);

										if     ($custom)	: $formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
										elseif ($delimiter)	: $formatted = $phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
										else				: $formatted = '('.$phone[1].') '.$phone[2].'-'.$phone[3];
										endif;

										$item_middle = $formatted;

										$item_href = 'tel:+'.$phone[0].$phone[1].$phone[2].$phone[3];
										$item_title_alt = "Telephone - {$formatted}";
									}


								if ( $style !== 'text' ) {
										$item_start_wrap = '<li>';
										$item_end_wrap = '</li>';
										$item_start = '<a class="socialbox_' . $item_slug . ' socialbox_' . $item_type .'" href="'. $item_href .'" target="_blank" title="' . $item_title_alt . '">';
										$item_end = '</a>';
								}


					// OUTPUT - Item
					$socialbox_middle .= $item_start_wrap . $item_start . $item_middle . $item_end . $item_end_wrap;
				endif; } 





			// RENDER - Socialbox close
			$socialbox_close .= '</ul>';





	// OUTPUT - Socialbox
	return $socialbox_open . $socialbox_middle . $socialbox_close;
}








































































///// DEPRECATED - I Wanna delete this crap so bad....

	function old_socialbox_shortcode( $atts ){

				extract( shortcode_atts( array(
					'open' => '<ul class="socialbox"><li>',
					'delimiter' => '</li><li>',
					'close' => '</li></ul>',
					'key' => '', 
					'output' => 'png', 
					'custom' => ''
				), $atts ) );


				global $list_o_social;
				$options = get_option( 'clientcms_options' );


				$result = $open;

				if ($key) {

					// Non-Dynamic Rss, Phones, & Emails
						if ( $key === 'rss' && $options["rssurl"] ) {
							$result .= '<a class="btn_rss" href="'.$options["rssurl"].'" target="_blank"></a>';
						}

					// For each number of phones
						for( $i = 1; $i <= self::$number_o_email; $i++ ) {
							if ( $key === "email{$i}" && $options["em{$i}txt"] )
								$result .= self::format_email_data ($i,$options) ;
						}

					// For each number of phones
						for( $i = 1; $i <= self::$number_o_phone; $i++ ) {
							if ( $key === "phone{$i}" && $options["ph{$i}txt"] )
								$result .= self::format_phone_data ($i,$options) ;
						}

					// Run each $socialmedia key vs. $css, if == run formatting
						foreach ($list_o_social as $social) {
							if ($key == $social['css'])
								$result .= self::format_socialbox_icons ($social,$options);
						}


				} else {

					// If no $key is set run all

						// Runs through the Socialmedbox variable's arrays
							foreach($socials as $social){
								$css = sanitize_title( $social );
								$slug = sanitize_title( $social );

								if($options["{$slug}url"]){
									if( $key === $css ) 
										$result .=  self::format_socialbox_icons ($social,$options);
									if ( 1 == $options["{$slug}urladd"] )
										$result .= self::format_socialbox_icons ($social,$options);
								}

							}

						// These are non-dynamic versions of the phone, email, and rss, they will be removed later.
							if (1 == $options["rssurladd"]) {
								$result .= '<a class="btn_rss socialbox_icon" href="'.$options["rssurl"].'" target="_blank"></a>';
							}
							if (1 == $options["em1txtadd"] && $options["em1txt"]){
								$result .= '<a class="btn_email1 socialbox_icon" href="mailto:'.$options["em1txt"].'" title="Email - '.$options["em1txt"].'"></a>';
							}
							if (1 == $options["em2txtadd"] && $options["em2txt"]){
								$result .= '<a class="btn_email2 socialbox_icon" href="mailto:'.$options["em2txt"].'" title="Email - '.$options["em2txt"].'"></a>';
							}
							if (1 == $options["phtxtadd"]  && $options["ph1txt"]){
								$phone = explode(" ", $options["ph1txt"]);
								$result .= '<a class="btn_phone1 socialbox_icon" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'" title="Call- '.$options["ph1txt"].'"></a>';
							}
							if (1 == $options["ph2txtadd"] && $options["ph2txt"]){
								$phone = explode(" ", $options["ph2txt"]);
								$result .= '<a class="btn_phone2 socialbox_icon" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'" title="Call- '.$options["ph1txt"].'"></a>';
							}

						

				}

				$result .= $close;

				return $result;

	}
		/*****	Shortcode [text_phone phone="1" delimiter="-"] functions *****/
			function shortcode_textPhone($atts){
				extract( shortcode_atts( array(
					'phone' => '1',
					'delimiter' => '',
					'custom' => ''
				), $atts ) );
				$options = get_option( 'clientcms_options' );
				if($options["ph{$phone}txt"]){
					$phone = explode(" ", $options["ph{$phone}txt"]);
					if ($custom) : 
						$formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
						elseif($delimiter): $formatted = $phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
						else: $formatted = '('.$phone[1].') '.$phone[2].'-'.$phone[3];
					endif;
					return '<a class="txt_phone{$phone}" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'">'.$formatted.'</a>';
				}
			}



		/*****	Shortcodes for Email *****/
			function shortcode_txtemone(){
				$options = get_option( 'clientcms_options' );
				if($options["em1txt"]){
					return '<span class="txt_emailone">'.$options["em1txt"].'</span>';
				}
			}
			function shortcode_txtemtwo(){
				$options = get_option( 'clientcms_options' );
				if($options["em2txt"]){return '<span class="txt_emailtwo">'.$options["em2txt"].'</span>';}
			}



		/*****	Shortcode address *****/

			function shortcode_address( $atts ) {
				$options = get_option( 'clientcms_options' );
				// {$phone}
				$input = array (
						$options["addr1_strt1_txt"],
						$options["addr1_strt2_txt"],
						$options["addr1_ctytxt"],
						$options["addr1_stttxt"],
						$options["addr1_ziptxt"]
				);

				if($options["ph{$phone}txt"]){
					$phone = explode(" ", $options["ph{$phone}txt"]);
					if ($custom) : 
						$formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
						elseif($delimiter): $formatted = $phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
						else: $formatted = '('.$phone[1].') '.$phone[2].'-'.$phone[3];
					endif;
					return '<a class="txt_phone{$phone}" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'">'.$formatted.'</a>';
				}

				format_address ( $input, $delimiter = ', ' );
			}



			// Deprecated, Sooner or later to be removed.
			function shortcode_txtadr(){
					extract( shortcode_atts( array(
						'address' => '1',
						'delimiter' => ', ',
						'custom' => ''
					), $atts ) );
					$options = get_option( 'clientcms_options' );
					if($options["adrtxt"]){ return '<span class="txt_address">'.$options["adrtxt"].'</span>'; }
			}

			function shortcode_txtcty(){
				$options = get_option( 'clientcms_options' );
				if($options["ctytxt"]){ return '<span class="txt_city">'.$options["ctytxt"].'</span>'; }
			}

			function shortcode_txtstt(){
				$options = get_option( 'clientcms_options' );
				if($options["stttxt"]){ return '<span class="txt_state">'.$options["stttxt"].'</span>'; }
			}

			function shortcode_txtzip(){
				$options = get_option( 'clientcms_options' );
				if($options["ziptxt"]){ return '<span class="txt_zip">'.$options["ziptxt"].'</span>'; }
			}


	// FORMAT - Phone
			function format_phone_data ($i,$options,$type='icon') {
				if( $type = 'text' ) {
					$option = $options["ph{$i}txtadd"];
					$phone = explode(" ", $option);
					return  '<a class="btn_phone'.$i.'" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'"></a>';
				} else {
					$slug = $social['slug'];
					return '<a class="btn_'.$social['css'].' socialbox_icon" href="'.$options["{$slug}url"].'" target="_blank" title="'.$social['display'].'"></a>';
				}
			}

	// FORMAT - Email
			function format_email_data ($social,$options) {
				$slug = $social['slug'];
				return '<a class="btn_'.$social['css'].'" href="mailto:'.$options["{$slug}txt"].'"></a>';
			}

	// FORMAT - Social Media
			function format_socialbox_icons ($social,$options) {
				$slug = $social['slug'];
				return '<a class="btn_'.$social['css'].' socialbox_icon" href="'.$options["{$slug}url"].'" target="_blank" title="'.$social['display'].'"></a>';
			}

	// FORMAT - Address
			function format_address ( $input, $delimiter = ', ' ) {
					$format = array (
							'street1' => $input[0],
							'street2' => $input[1],
							'city'    => $input[2],
							'state'   => $input[3],
							'zip'     => $input[4]
					);
					$output  = $format['street1'];
					$output .= $delimiter;
					$output .= $format['street2'];
					$output .= $delimiter;
					$output .= $format['city'];
					$output .= $delimiter;
					$output .= $format['state'];
					$output .= $delimiter;
					$output .= $format['zip'];
					return $output;
			}




}}?>