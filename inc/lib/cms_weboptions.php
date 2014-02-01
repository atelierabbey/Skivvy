<?php if ( ! class_exists( 'skivvy_websiteoptions' ) ) { class skivvy_websiteoptions {

	static $version = "31Jan13";

	static $number_o_phone = 2;
	static $number_o_email = 2;
	static $number_o_address = 1;

	static $socialmedsbox = array(
	//  array( 'display' => '', 'css' => '', 'slug'=>'' ),
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
				self::render_website_options
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
			function shortcode_txtadr(){
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
					'key' => ''
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
						if ( $key === "email{$i}" && $options["em{$i}txt"] ) { 
							$result .= self::format_email_data ($i,$options) ;
						}
					} 

					// For each number of phones
					for( $i = 1; $i <= self::$number_o_phone; $i++ ) {
						if ( $key === "phone{$i}" && $options["ph{$i}txt"] ) { 
							$result .= self::format_phone_data ($i,$options) ;
						}
					} // */

					// Run each $socialmedia key vs. $css, if == run formatting
					foreach ($socials as $social) {
						if ($key == $social['css']) {
							$result .= self::format_socialbox_icons ($social,$options);
						}
					}

				} else {
					// If no $key is set run all
					$result = '<div class="socialbox">';
						// Runs through the Socialmedbox variable's arrays
						foreach($socials as $social){
							$css = $social['css'];
							$slug = $social['slug'];
							if($options["{$slug}url"]){
								
								if( $key === $css ) {
									$result .=  self::format_socialbox_icons ($social,$options);
								}

								if (1 == $options["{$slug}urladd"] )
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

					$result .= '</div>';
				}
				return $result;
			}




	/*
	 *
	 *	Render Website Options Page
	 *
	 */



			function render_website_options() {
				global $select_options;
				if ( ! isset( $_REQUEST['settings-updated'] ) ) { $_REQUEST['settings-updated'] = false; }
				?>
				<div class="wrap skivvy-websiteoptions">
					<?php if ( false !== $_REQUEST['settings-updated'] ) { echo '<div><p><strong>Options saved</strong></p></div>'; } ?> 
					<?php screen_icon();?> 
					<h2>Website Options</h2>
					<form method="post" action="../../lib/options.php">
						<?php settings_fields( 'skivvy_options' ); ?>
						<?php $options = get_option( 'clientcms_options' ); ?>

						<h3>Contact Information</h3>
						<table><?php


							// For each phone, create a row
								echo '<tr><td colspan="4"><small>Please use spaces to seperate the sections of digits; (i.e. "1 555 444 7777" )</small>';
								for( $i = 1; $i <= self::$number_o_phone; $i++ ) {

									if( 1 == $options["ph{$i}txtadd"]) $checked = 'checked="checked"';
									$value = esc_attr( $options["ph{$i}txt"] );
									echo (
										'<tr valign="top">'.
											'<th scope="row">Phone '. $i .'</th>'.
											'<td>'. 
												'<input id="clientcms_options[ph'. $i .'txtadd]" type="checkbox" value="1" name="clientcms_options[ph'. $i .'txtadd]"'. $checked .'>'.
											'</td>'.
											'<td>'.
												'<input id="clientcms_options[ph'. $i .'txt]" type="text" name="clientcms_options[ph'. $i .'txt]" placeholder="1 222 333 4444" value="'.$value.'" >'.
											'</td>'.
											'<td>'.
												'<img class="icon" src="'.self::iconLoc().'phone'. $i .'.png" >'.
												'Icon: <input type="text" size="22" value=\'[socialbox key="phone'. $i .'"]\'  readonly>'.
												'&nbsp;&nbsp;|&nbsp;&nbsp;'.
												'Text:<input type="text" size="20" value=\'[text_phone phone="'. $i .'"]\' readonly>'.
												'<input type="text" size="20" value=\'[text_phone phone="'. $i .'" delimiter="."]\' readonly>'.
												'<input type="text" size="34" value=\'[text_phone phone="'. $i .'" custom="+$a ($b) $c-$d"]\' readonly>'.
											'</td>'.
										'</tr>'
									);
								}
							?>
							<tr><td colspan="2"><br /></td></tr>
							<?php // For each email, create a row
								for( $i = 1; $i <= self::$number_o_email; $i++ ) {

									if( 1 == $options["em{$i}txtadd"]) $checked = 'checked="checked"';
									$value = esc_attr( $options["em{$i}txt"] ); ?>
									<tr valign="top">
										<th scope="row">Email <?php echo $i; ?></th>
										<td><input id="clientcms_options[em<?php echo $i; ?>txtadd]" type="checkbox" value="1" <?php echo $checked; ?> name="clientcms_options[em<?php echo $i; ?>txtadd]"></td>
										<td><input id="clientcms_options[em<?php echo $i; ?>txt]" type="text" name="clientcms_options[em1txt]" value="<?php echo $value; ?>" /></td>
										<td>
											<img class="icon" src="<?php echo self::iconLoc() ?>email<?php echo $i; ?>.png" />
											Text:<input type="text" size="6" value="[txt_em<?php echo $i; ?>]"  readonly>
											Icon: <input type="text" size="22" value="[socialbox key='email<?php echo $i; ?>']"  readonly>
										</td>
									</tr>
							<?php } ?>

							<tr><td colspan="3"><br /></td></tr>

							<tr valign="top">
								<th scope="row" colspan="2">Address</th>
								<td><input id="clientcms_options[adrtxt]" type="text" name="clientcms_options[adrtxt]" value="<?php esc_attr_e( $options['adrtxt'] ); ?>" /></td>
								<td>Shortcode: <em>[txt_adr]</em>   |   css: <em>span.txt_address</em></td>
							</tr>
							<tr valign="top">
								<th scope="row" colspan="2">City</th>
								<td><input id="clientcms_options[ctytxt]" type="text" name="clientcms_options[ctytxt]" value="<?php esc_attr_e( $options['ctytxt'] ); ?>" /></td>
								<td>Shortcode: [txt_cty]   |   css: span.txt_city</td>
							</tr>
							<tr valign="top">
								<th scope="row" colspan="2">State</th>
								<td><input id="clientcms_options[stttxt]" type="text" name="clientcms_options[stttxt]" value="<?php esc_attr_e( $options['stttxt'] ); ?>" /></td>
								<td>Shortcode: [txt_stt]   |   css: span.txt_state</td>
							</tr>
							<tr valign="top">
								<th scope="row" colspan="2">ZIP</th>
								<td><input id="clientcms_options[ziptxt]" type="text" name="clientcms_options[ziptxt]" value="<?php esc_attr_e( $options['ziptxt'] ); ?>" /></td>
								<td>Shortcode: [txt_zip]   |   css: span.txt_zip</td>
							</tr>
						</table>


						<hr />
						<h3>Social Media</h3>
						<span>Shortcode: [socialbox]   |   css:div.socialbox</span><br><br>
						<table>
							<tr valign="top">
								<th scope="row">RSS</th>
								<td><input id="clientcms_options[rssurladd]" type="checkbox" value="1" <?php if( 1 == $options['rssurladd']) echo 'checked="checked"'; ?> name="clientcms_options[rssurladd]"></td>
								<td><input id="clientcms_options[rssurl]" type="text" size="50" name="clientcms_options[rssurl]" value="<?php bloginfo('rss2_url'); ?>"  readonly></td>
								<td><img class="icon" src="<?php echo self::iconLoc() ?>rss.png" />
									Icon: <input type="text" size="30" value='[socialbox key="rss"]'  readonly>
								</td>
							</tr>

							<?php $socials = self::$socialmedsbox;
								foreach($socials as $social){
									$display = $social['display'];
									$css = $social['css'];
									$slug = $social['slug'];
									if( 1 == $options["{$slug}urladd"]) { $checked = 'checked="checked"';} else { $checked = ''; }
									$value = esc_attr( $options["{$slug}url"] );
									echo
										'<tr valign="top">'.
											'<th scope="row">'.$display.'</th>'.
											'<td>'.
												'<input id="clientcms_options['.$slug.'urladd]" type="checkbox" value="1" '.$checked.' name="clientcms_options['.$slug.'urladd]">'.
											'</td>'.
											'<td>'.
												'<input id="clientcms_options['.$slug.'url]" type="text" size="50" name="clientcms_options['.$slug.'url]" value="'.$value.'" />'.
											'</td>'.
											'<td>'.
												'<img class="icon" src="' . self::iconLoc() . $css . '.png" />'.
												'Icon: <input type="text" size="30" value=\'[socialbox key="' . $css . '"]\' readonly>'.
											'</td>'.
										'</tr>';
								}
							?>
						</table>
						<p><input type="submit" value="Save Options" /></p>
					</form>
					<div>Website Options Version : <?php echo self::$version ?></div>
				</div>
				<?php 
			}




}}?>