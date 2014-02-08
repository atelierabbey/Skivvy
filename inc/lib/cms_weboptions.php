<?php if ( ! class_exists( 'skivvy_websiteoptions' ) ) { class skivvy_websiteoptions {

	# TEMP NOTES
	# Address Shortcode
	# Add / style="text/icon/svg" /
	# Add / Delimiter='' /
	# Add Custom (for address & Phone)
	# Deprecate all old text functions







	static $socialmedsbox = array(
		// array( 'display' => '', 'css' => '', 'slug'=>'' ),
		array( 'display' => 'Etsy',			'css' => 'etsy',		'slug'=>'et'),
		array( 'display' => 'Facebook',		'css' =>'facebook',		'slug'=>'fb'),
		array( 'display' => 'Flickr',		'css' =>'flickr',		'slug'=>'fl'),
		array( 'display' => 'Google+',		'css' =>'googleplus',	'slug'=>'gp'),
		array( 'display' => 'Instagram',	'css' =>'instagram',	'slug'=>'ig'),
		array( 'display' => 'LinkedIn',		'css' =>'linkedin',		'slug'=>'li'),
		array( 'display' => 'Pinterest',	'css' =>'pinterest',	'slug'=>'pt'),
		array( 'display' => 'Twitter',		'css' =>'twitter',		'slug'=>'tw'),
		array( 'display' => 'Vimeo',		'css' =>'vimeo',		'slug'=>'vm'),
		array( 'display' => 'Youtube',		'css' =>'youtube',		'slug'=>'yt'),
		array( 'display' => 'Extra 1',		'css' =>'extra1',		'slug'=>'x1'),
		array( 'display' => 'Extra 2',		'css' =>'extra2',		'slug'=>'x2'),
		array( 'display' => 'Extra 3',		'css' =>'extra3',		'slug'=>'x3'),
		array( 'display' => 'Extra 4',		'css' =>'extra4',		'slug'=>'x4'),
		array( 'display' => 'Extra 5',		'css' =>'extra5',		'slug'=>'x5'),
		array( 'display' => 'Extra 6',		'css' =>'extra6',		'slug'=>'x6'),
		array( 'display' => 'Extra 7',		'css' =>'extra7',		'slug'=>'x7')
	);

	// Set the image location for the social icons.
	static function iconLoc() { return get_bloginfo('template_url').'/img/social/'; }















	/////// [ Belt line ] //////  Not touching below the belt, keep it PG.











	static $version = '5Feb13';


	/*
	 *
	 *	Initialization functions
	 *
	 */


	// Construct initializtion
		function __construct() {
			add_action( 'admin_init', 'skivvy_websiteoptions::theme_options_init');
			add_action( 'admin_menu', 'skivvy_websiteoptions::theme_options_add_page'); 
	
			add_shortcode( 'text_phone', 'skivvy_websiteoptions::shortcode_textPhone');
			add_shortcode( 'txt_ph2', 'skivvy_websiteoptions::shortcode_txtphtwo');
			add_shortcode( 'txt_em1', 'skivvy_websiteoptions::shortcode_txtemone');
			add_shortcode( 'txt_em2', 'skivvy_websiteoptions::shortcode_txtemtwo');
			add_shortcode( 'txt_adr', 'skivvy_websiteoptions::shortcode_txtadr');
			add_shortcode( 'txt_cty', 'skivvy_websiteoptions::shortcode_txtcty');
			add_shortcode( 'txt_stt', 'skivvy_websiteoptions::shortcode_txtstt');
			add_shortcode( 'txt_zip', 'skivvy_websiteoptions::shortcode_txtzip');	
			add_shortcode( 'socialbox', 'skivvy_websiteoptions::socialbox_shortcode');
		}

	// Register the Options group
		static function theme_options_init(){
			register_setting( 'skivvy_options', 'clientcms_options');
		}

	// Register the Options page
		function theme_options_add_page() {
			add_theme_page(
				'Website Options', // Page Title
				'Website Options', // Menu Title
				'edit_theme_options', // Capability
				'website_options', // menu slug
				'skivvy_websiteoptions::render_website_options'
			);
		}




	/*
	 *
	 *	formats functions
	 *
	 */



		// ---- formats phone
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

		// ---- formats email
			function format_email_data ($social,$options) {
				$slug = $social['slug'];
				return '<a class="btn_'.$social['css'].'" href="mailto:'.$options["{$slug}txt"].'"></a>';
			}

		// ---- formats social media icons
			function format_socialbox_icons ($social,$options) {
				$slug = $social['slug'];
				return '<a class="btn_'.$social['css'].' socialbox_icon" href="'.$options["{$slug}url"].'" target="_blank" title="'.$social['display'].'"></a>';
			}



		// Format - Address
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




	/*
	 *
	 *	Shortcodes
	 *
	 */



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
					if($options["adrtxt"]){return '<span class="txt_address">'.$options["adrtxt"].'</span>';}
			}

			function shortcode_txtcty(){
				$options = get_option( 'clientcms_options' );
				if($options["ctytxt"]){return '<span class="txt_city">'.$options["ctytxt"].'</span>';}
			}

			function shortcode_txtstt(){
				$options = get_option( 'clientcms_options' );
				if($options["stttxt"]){return '<span class="txt_state">'.$options["stttxt"].'</span>';}
			}

			function shortcode_txtzip(){
				$options = get_option( 'clientcms_options' );
				if($options["ziptxt"]){return '<span class="txt_zip">'.$options["ziptxt"].'</span>';}
			}














		/*****	[socialbox] Shortcode *****/
			function socialbox_shortcode( $atts ){

				extract( shortcode_atts( array(
					'key' => '', // Example : phone1,email2,fax1,facebook. comma separated. If left empty, will display all. If >1, wraps in ul.socialbox, each item will be li. 
					'output' => 'png', // Options : 'png' = a span with list  |  'svg' = outputs link around SVG code  |  'text' = outputs only text, no link.  |  'link', nolist
					'delimiter' => '', // any character to delimit. Works only with phone, fax, or address
					'custom' => '' // Examples: for phone = +$a,$b/$c*$d  |  for addr = $street1, $street2 <br> $city, $state <br> $zip  | for others => 
				), $atts ) );



				$options = get_option( 'clientcms_options' );
				$socials = self::$socialmedsbox; 


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
						foreach ($socials as $social) {
							if ($key == $social['css'])
								$result .= self::format_socialbox_icons ($social,$options);
						}


				} else {


					// If no $key is set run all
						$result = '<ul class="socialbox">';

						// Runs through the Socialmedbox variable's arrays
							foreach($socials as $social){
								$css = $social['css'];
								$slug = $social['slug'];

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

						$result .= '</ul>';

				} return $result;

			}

























	/*
	 *
	 *	Render Website Options Page
	 *
	 */


			function render_website_options() {

				global $select_options;

				echo '<div class="wrap skivvy-websiteoptions">';
					screen_icon();
					echo '<h2>Website Options</h2>';



					if ( ! isset( $_REQUEST['settings-updated'] ) ) {
							$_REQUEST['settings-updated'] = false;
					}

					if ( false !== $_REQUEST['settings-updated'] ) {
							echo '<div class="skivvy-optionsupdate"><h3>Options saved</h3></div>';
					}



					echo '<form method="post" action="options.php">';
						settings_fields( 'skivvy_options' );
						$options = get_option( 'clientcms_options' );
						echo '<h2>Contact Information</h2>';

						$total_phone = 2;
							if ( $options["number_of_phone"] ) $total_phone = $options["number_of_phone"];
						$total_fax = 1;
							if ( $options["number_of_fax"] ) $total_fax = $options["number_of_fax"];
						$total_email = 2;
							if ( $options["number_of_email"] ) $total_email = $options["number_of_email"];
						$total_addr = 2;
							if ( $options["number_of_address"] ) $total_addr = $options["number_of_address"];

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
								echo '<h3>Phone</h3>'.
									 '<small>Please use spaces to seperate the sections of digits; (i.e. "1 555 444 7777" )</small>';
										for( $i = 1; $i <= $total_phone; $i++ ) {

											if ( 1 == $options["ph{$i}txtadd"] && $options["ph{$i}txt"] ) {
												$checked = 'checked="checked"';
											} else {
												$checked = '';
											}

											echo (
												'<div class="skivvy-optionrow skivvy-optionphone">'.
													'<span><input id="clientcms_options[ph'. $i .'txtadd]" type="checkbox" value="1" name="clientcms_options[ph'. $i .'txtadd]"'. $checked .'></span>'.
													'<span class="icon"><img src="' . self::iconLoc() . 'phone'. $i . '.png" ></span>'.
													'<span>Phone '. $i .'</span>'.
													'<span><input id="clientcms_options[ph'. $i .'txt]" type="text" name="clientcms_options[ph'. $i .'txt]" placeholder="1 222 333 4444" value="'.esc_attr( $options["ph{$i}txt"] ).'" ></span>'.
												'<div class="clear"></div></div>'
											);
										}







							// FAX
								echo '<h3>FAX</h3>'.
									 '<small>Please use spaces to seperate the sections of digits; (i.e. "1 555 444 7777" )</small>';
										for( $i = 1; $i <= $total_fax; $i++ ) {

											if ( 1 == $options["fax{$i}txtadd"] && $options["fax{$i}txt"] ) {
												$checked = 'checked="checked"';
											} else {
												$checked = '';
											}

											echo (
												'<div class="skivvy-optionrow skivvy-optionfax">'.
													'<span><input id="clientcms_options[fax'. $i .'txtadd]" type="checkbox" value="1" name="clientcms_options[fax'. $i .'txtadd]"'. $checked .'></span>'.
													'<span class="icon"><img src="' . self::iconLoc() . 'fax'. $i . '.png" ></span>'.
													'<span>Fax '. $i .'</span>'.
													'<span><input id="clientcms_options[fax'. $i .'txt]" type="text" name="clientcms_options[fax'. $i .'txt]" placeholder="1 222 333 4444" value="'.esc_attr( $options["fax{$i}txt"] ).'" ></span>'.
												'<div class="clear"></div></div>'
											);
										}







							// EMAILS
								echo '<h3>Email</h3>';

									for( $i = 1; $i <= $total_email; $i++ ) {

										if ( 1 == $options["em{$i}txtadd"] && $options["em{$i}txt"] ) {
												$checked = 'checked="checked"';
										} else {
												$checked = '';
										}

										echo (
											'<div class="skivvy-optionrow skivvy-optionemail">'.
												'<span><input id="clientcms_options[em' . $i . 'txtadd]" type="checkbox" value="1" ' . $checked . ' name="clientcms_options[em' . $i . 'txtadd]"></span>'.
												'<span class="icon"><img src="' . self::iconLoc() . 'email' . $i . '.png" ></span>'.
												'<span>Email '. $i . '</span>'.
												'<span><input id="clientcms_options[em' . $i . 'txt]" type="text" name="clientcms_options[em' . $i . 'txt]" value="' . esc_attr( $options["em{$i}txt"] ) . '" ></span>'.
											'<div class="clear"></div></div>'
										);
									}






							// ADDRESSES
								echo '<h3>Address</h3>';

								for( $i = 1; $i <= $total_addr; $i++ ) {

									if ( 1 == $options["addr{$i}txtadd"] ) {
											$checked = 'checked="checked"';
									} else {
											$checked = '';
									}

									echo (
										'<div class="skivvy-optionrow skivvy-optionaddr">'.
											'<span><input id="clientcms_options[addr' . $i . 'txtadd]" type="checkbox" value="1" ' . $checked . ' name="clientcms_options[addr' . $i . 'txtadd]"></span>'.
											'<span class="icon"><img src="' . self::iconLoc() . 'address' . $i . '.png"></span>'.
											'<span>Address '. $i .'</span>'.
											'<span>'. 
												'<input id="clientcms_options[addr'. $i .'street1]" type="text" name="clientcms_options[addr'. $i .'street1]" value="' . esc_attr( $options["addr{$i}street1"] ) . '" placeholder="Street 1">'.
												'<input id="clientcms_options[addr'. $i .'street2]" type="text" name="clientcms_options[addr'. $i .'street2]" value="' . esc_attr( $options["addr{$i}street2"] ) . '" placeholder="Street 2">'.
												'<input id="clientcms_options[addr'. $i .'city]" type="text" name="clientcms_options[addr'. $i .'city]" value="' . esc_attr( $options["addr{$i}city"] ) . '" placeholder="City">'.
												'<input id="clientcms_options[addr'. $i .'state]" type="text" name="clientcms_options[addr'. $i .'state]" value="' . esc_attr( $options["addr{$i}state"] ) . '" placeholder="State">'.
												'<input id="clientcms_options[addr'. $i .'zip]" type="text" name="clientcms_options[addr'. $i .'zip]" value="' . esc_attr( $options["addr{$i}zip"] ) . '" placeholder="Zip">'.
												'<input id="clientcms_options[addr'. $i .'country]" type="text" name="clientcms_options[addr'. $i .'country]" value="' . esc_attr( $options["addr{$i}country"] ) . '" placeholder="Country">'.
											'</span>'.
										'<div class="clear"></div></div>'
									);
								}







						echo '<hr>'.
							 '<h3>Social Media</h3>';

							// RSS
								if( 1 == $options["rssurladd"]) {
									$checked = 'checked="checked"';
								} else {
									$checked = '';
								}
								echo (
									'<div class="skivvy-optionrow skivvy-optionsocial">'.
										'<span class="add"><input id="clientcms_options[rssurladd]" type="checkbox" value="1" '.$checked.' name="clientcms_options[rssurladd]"></span>'.
										'<span class="icon"><img src="' . self::iconLoc() . 'rss.png" /></span>'.
										'<span class="name">RSS</span>'.
										'<span class="input"><input id="clientcms_options[rssurl]" type="text" size="50" name="clientcms_options[rssurl]" value="'.get_bloginfo('rss2_url') . '"  readonly></span>'.
									'<div class="clear"></div></div>'
								);


							//SOCIAL
								$socials = self::$socialmedsbox;
								foreach($socials as $social){
									$display = $social['display'];
									$css = $social['css'];
									$slug = $social['slug'];
									if( 1 == $options["{$slug}urladd"]) { $checked = 'checked="checked"';} else { $checked = ''; }
									$value = esc_attr( $options["{$slug}url"] );
									echo (
										'<div class="skivvy-optionrow skivvy-optionsocial">'.
											'<span class="add"><input id="clientcms_options['.$slug.'urladd]" type="checkbox" value="1" '.$checked.' name="clientcms_options['.$slug.'urladd]"></span>'.
											'<span class="icon"><img src="' . self::iconLoc() . $css . '.png" /></span>'.
											'<span class="name">'.$display.'</span>'.
											'<span class="input"><input id="clientcms_options['.$slug.'url]" type="text" size="50" name="clientcms_options['.$slug.'url]" value="'.$value.'"></span>'.
										'<div class="clear"></div></div>'
										);
								}




						submit_button();

					echo '</form>';
					echo '<div>Website Options Version: ' . self::$version . '</div>';
				echo '</div>';
			}




}}?>