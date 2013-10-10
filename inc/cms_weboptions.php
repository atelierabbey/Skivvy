<?php $version = "10Oct13"; // The Bat signal
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' ); 
function theme_options_init(){ register_setting( 'sample_options', 'clientcms_options');} 
function theme_options_add_page() { add_theme_page(
		'Website Options', // Page Title
		'Website Options', // Menu Title
		'edit_theme_options', // Capability
		'website_options', // menu slug
		'theme_options_do_page' 
) ;}
function theme_options_do_page() {
	global $select_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) ) 
		$_REQUEST['settings-updated'] = false;
	?>
    <div class="wrap">
		<?php screen_icon(); echo "<h2>Website Options</h2>"; ?>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div>
			<p><strong>Options saved</strong></p></div>
		<?php endif; ?> 

		<form method="post" action="options.php">
			<?php settings_fields( 'sample_options' ); ?>
			<?php $options = get_option( 'clientcms_options' ); ?>
            <br>
            <style>
				tr img.icon {
					background: #848d9d;
					height: 20px;
					padding: 1px;
					margin-right: 10px;
					max-width: 20px;
				}
				tr img.icon:hover {
					background: linear-gradient(to top, #373737 0px, #464646 5px) repeat scroll 0 0 #464646
				}
			</style>
            <script>
				function copyText(element) {
				   document.this.value = element.innerHTML;
				}
			</script>
			<?php $socnet = get_bloginfo('template_url').'/img/social/'; ?>
            <h3>Contact Information</h3>
            <table>
				<tr valign="top">
					<th scope="row">Phone 1</th>
                    <td><input id="clientcms_options[phtxtadd]" type="checkbox" value="1" <?php if( 1 == $options['phtxtadd']) echo 'checked="checked"'; ?> name="clientcms_options[phtxtadd]"></td>
					<td><input id="clientcms_options[ph1txt]" type="text" name="clientcms_options[ph1txt]" placeholder="1 222 333 4444" value="<?php esc_attr_e( $options['ph1txt'] ); ?>" /></td>
                    <td>
                    	<img class="icon" src="<?php echo $socnet ?>phone1.png" />
                    	Text:<input type="text" size="6" value="[txt_ph1]" onclick="copyText(this)" readonly>
                        Icon: <input type="text" size="22" value='[socialbox key="phone1"]' onclick="copyText(this)" readonly>
                        <em>delimiter="."   |   custom="+$a ($b) $c-$d</em>
					</td>
                </tr>
				<tr valign="top">
					<th scope="row">Phone 2</th>
                    <td><input id="clientcms_options[ph2txtadd]" type="checkbox" value="1" <?php if( 1 == $options['ph2txtadd']) echo 'checked="checked"'; ?> name="clientcms_options[ph2txtadd]"></td>
					<td><input id="clientcms_options[ph2txt]" type="text" name="clientcms_options[ph2txt]" placeholder="1 222 333 4444" value="<?php esc_attr_e( $options['ph2txt'] ); ?>" /></td>
					<td>
                    	<img class="icon" src="<?php echo $socnet ?>phone2.png" />
                    	Text:<input type="text" size="6" value="[txt_ph2]" onclick="copyText(this)" readonly>
                        Icon: <input type="text" size="22" value='[socialbox key="phone2"]' onclick="copyText(this)" readonly>
                        <em>delimiter="."   |   custom="+$a ($b) $c-$d</em>
					</td>
				</tr>
                <tr><td colspan="2"><br /></td></tr>
				<tr valign="top">
					<th scope="row">Email 1</th>
                    <td><input id="clientcms_options[em1txtadd]" type="checkbox" value="1" <?php if( 1 == $options['em1txtadd']) echo 'checked="checked"'; ?> name="clientcms_options[em1txtadd]"></td>
					<td><input id="clientcms_options[em1txt]" type="text" name="clientcms_options[em1txt]" value="<?php esc_attr_e( $options['em1txt'] ); ?>" /></td>
					<td>
                    	<img class="icon" src="<?php echo $socnet ?>email1.png" />
                    	Text:<input type="text" size="6" value="[txt_em1]" onclick="copyText(this)" readonly>
                        Icon: <input type="text" size="22" value="[socialbox key='email1']" onclick="copyText(this)" readonly>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Email 2</th>
                    <td><input id="clientcms_options[em2txtadd]" type="checkbox" value="1" <?php if( 1 == $options['em2txtadd']) echo 'checked="checked"'; ?> name="clientcms_options[em2txtadd]"></td>
					<td><input id="clientcms_options[em2txt]" type="text" name="clientcms_options[em2txt]" value="<?php esc_attr_e( $options['em2txt'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>email2.png" />
                    	Text:<input type="text" size="6" value="[txt_em2]" onclick="copyText(this)" readonly>
                        Icon: <input type="text" size="22" value='[socialbox key="email2"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
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
					<td><img class="icon" src="<?php echo $socnet ?>rss.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="rss"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Etsy</th>
                    <td><input id="clientcms_options[eturladd]" type="checkbox" value="1" <?php if( 1 == $options['eturladd']) echo 'checked="checked"'; ?> name="clientcms_options[eturladd]"></td>
					<td><input id="clientcms_options[eturl]" type="text" size="50" name="clientcms_options[eturl]" value="<?php esc_attr_e( $options['eturl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>etsy.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="etsy"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Facebook</th>
                    <td><input id="clientcms_options[fburladd]" type="checkbox" value="1" <?php if( 1 == $options['fburladd']) echo 'checked="checked"'; ?> name="clientcms_options[fburladd]"></td>
					<td><input id="clientcms_options[fburl]" type="text" size="50" name="clientcms_options[fburl]" value="<?php esc_attr_e( $options['fburl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>facebook.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="facebook"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Flickr</th>
                    <td><input id="clientcms_options[flurladd]" type="checkbox" value="1" <?php if( 1 == $options['flurladd']) echo 'checked="checked"'; ?> name="clientcms_options[flurladd]"></td>
					<td><input id="clientcms_options[flurl]" type="text" size="50" name="clientcms_options[flurl]" value="<?php esc_attr_e( $options['flurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>flickr.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="flickr"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Google+</th>
                    <td><input id="clientcms_options[gpurladd]" type="checkbox" value="1" <?php if( 1 == $options['gpurladd']) echo 'checked="checked"'; ?> name="clientcms_options[gpurladd]"></td>
					<td><input id="clientcms_options[gpurl]" type="text" size="50" name="clientcms_options[gpurl]" value="<?php esc_attr_e( $options['gpurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>google-plus.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="googleplus"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Instagram</th>
                    <td><input id="clientcms_options[igurladd]" type="checkbox" value="1" <?php if( 1 == $options['igurladd']) echo 'checked="checked"'; ?> name="clientcms_options[igurladd]"></td>
					<td><input id="clientcms_options[igurl]" type="text" size="50" name="clientcms_options[igurl]" value="<?php esc_attr_e( $options['igurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>instagram.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="instagram"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Linkedin</th>
                    <td><input id="clientcms_options[liurladd]" type="checkbox" value="1" <?php if( 1 == $options['liurladd']) echo 'checked="checked"'; ?> name="clientcms_options[liurladd]"></td>
					<td><input id="clientcms_options[liurl]" type="text" size="50" name="clientcms_options[liurl]" value="<?php esc_attr_e( $options['liurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>linkedin.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="linkedin"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Pinterest</th>
                    <td><input id="clientcms_options[pturladd]" type="checkbox" value="1" <?php if( 1 == $options['pturladd']) echo 'checked="checked"'; ?> name="clientcms_options[pturladd]"></td>
					<td><input id="clientcms_options[pturl]" type="text" size="50" name="clientcms_options[pturl]" value="<?php esc_attr_e( $options['pturl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>pinterest.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="pinterest"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Twitter</th>
                    <td><input id="clientcms_options[twurladd]" type="checkbox" value="1" <?php if( 1 == $options['twurladd']) echo 'checked="checked"'; ?> name="clientcms_options[twurladd]"></td>
					<td><input id="clientcms_options[twurl]" type="text" size="50" name="clientcms_options[twurl]" value="<?php esc_attr_e( $options['twurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>twitter.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="twitter"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Vimeo</th>
                    <td><input id="clientcms_options[vmurladd]" type="checkbox" value="1" <?php if( 1 == $options['vmurladd']) echo 'checked="checked"'; ?> name="clientcms_options[vmurladd]"></td>
					<td><input id="clientcms_options[vmurl]" type="text" size="50" name="clientcms_options[vmurl]" value="<?php esc_attr_e( $options['vmurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>vimeo.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="vimeo"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Youtube</th>
                    <td><input id="clientcms_options[yturladd]" type="checkbox" value="1" <?php if( 1 == $options['yturladd']) echo 'checked="checked"'; ?> name="clientcms_options[yturladd]"></td>
					<td><input id="clientcms_options[yturl]" type="text" size="50" name="clientcms_options[yturl]" value="<?php esc_attr_e( $options['yturl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>youtube.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="youtube"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 1</th>
                    <td><input id="clientcms_options[x1urladd]" type="checkbox" value="1" <?php if( 1 == $options['x1urladd']) echo 'checked="checked"'; ?> name="clientcms_options[x1urladd]"></td>
					<td><input id="clientcms_options[x1url]" type="text" size="50" name="clientcms_options[x1url]" value="<?php esc_attr_e( $options['x1url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button1.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra1"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 2</th>
                    <td><input id="clientcms_options[x2urladd]" type="checkbox" value="1" <?php if( 1 == $options['x2urladd']) echo 'checked="checked"'; ?> name="clientcms_options[x2urladd]"></td>
					<td><input id="clientcms_options[x2url]" type="text" size="50" name="clientcms_options[x2url]" value="<?php esc_attr_e( $options['x2url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button2.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra2"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 3</th>
                    <td><input id="clientcms_options[x3urladd]" type="checkbox" value="1" <?php if( 1 == $options['x3urladd']) echo 'checked="checked"'; ?> name="clientcms_options[x3urladd]"></td>
					<td><input id="clientcms_options[x3url]" type="text" size="50" name="clientcms_options[x3url]" value="<?php esc_attr_e( $options['x3url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button3.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra3"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 4</th>
                    <td><input id="clientcms_options[x4urladd]" type="checkbox" value="1" <?php if( 1 == $options['x4urladd']) echo 'checked="checked"'; ?> name="clientcms_options[x4urladd]"></td>
					<td><input id="clientcms_options[x4url]" type="text" size="50" name="clientcms_options[x4url]" value="<?php esc_attr_e( $options['x4url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button4.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra4"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 5</th>
                    <td><input id="clientcms_options[x5urladd]" type="checkbox" value="1" <?php if( 1 == $options['em2txtadd']) echo 'checked="checked"'; ?> name="clientcms_options[x5urladd]"></td>
					<td><input id="clientcms_options[x5url]" type="text" size="50" name="clientcms_options[x5url]" value="<?php esc_attr_e( $options['x5url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button5.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra5"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 6</th>
                    <td><input id="clientcms_options[x6urladd]" type="checkbox" value="1" <?php if( 1 == $options['x6urladd']) echo 'checked="checked"'; ?> name="clientcms_options[x6urladd]"></td>
					<td><input id="clientcms_options[x6url]" type="text" size="50" name="clientcms_options[x6url]" value="<?php esc_attr_e( $options['x6url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button6.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra6"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 7</th>
                    <td><input id="clientcms_options[x7urladd]" type="checkbox" value="1" <?php if( 1 == $options['x7urladd']) echo 'checked="checked"'; ?> name="clientcms_options[x7urladd]"></td>
					<td><input id="clientcms_options[x7url]" type="text" size="50" name="clientcms_options[x7url]" value="<?php esc_attr_e( $options['x7url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button7.png" />
                        Icon: <input type="text" size="30" value='[socialbox key="extra7"]' onclick="copyText(this)" readonly>
                    </td>
				</tr>
            </table>
			<p><input type="submit" value="Save Options" /></p>
		</form>
	</div>
	<?php 
} 



/* -------------------------------
	Website Options Shortcodes
---------------------------------*/ 
//// ---- Contact Info Area ---- ////
function shortcode_txtphone($atts){
	extract( shortcode_atts( array(
		'delimiter' => '',
		'custom' => ''
	), $atts ) );
	$options = get_option( 'clientcms_options' );
	if($options["ph1txt"]){
		$phone = explode(" ", $options["ph1txt"]);
		if ($custom) : 
			$formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
			elseif($delimiter): $formatted = $phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
			else: $formatted = '('.$phone[1].') '.$phone[2].'-'.$phone[3];
		endif;
		return '<a class="txt_phoneone" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'">'.$formatted.'</a>';
	}
} add_shortcode( 'txt_ph1', 'shortcode_txtphone' );

function shortcode_txtphtwo($atts){
	extract( shortcode_atts( array(
		'delimiter' => '',
		'custom' => ''
	), $atts ) );
	$options = get_option( 'clientcms_options' );
	if($options["ph2txt"]){
		$phone = explode(" ", $options["ph2txt"]);
		if ($custom) : 
			$formatted = str_replace(array('$a','$b','$c','$d'), $phone, $custom );
			elseif($delimiter): $formatted = $phone[1].$delimiter.$phone[2].$delimiter.$phone[3];
			else: $formatted = '('.$phone[1].') '.$phone[2].'-'.$phone[3];
		endif;
		return '<a class="txt_phonetwo" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'">'.$formatted.'</a>';
	}
} add_shortcode( 'txt_ph2', 'shortcode_txtphtwo' );

function shortcode_txtemone(){ $options = get_option( 'clientcms_options' ); if($options["em1txt"]){return '<span class="txt_emailone">'.$options["em1txt"].'</span>';}} add_shortcode( 'txt_em1', 'shortcode_txtemone' );
function shortcode_txtemtwo(){ $options = get_option( 'clientcms_options' ); if($options["em2txt"]){return '<span class="txt_emailtwo">'.$options["em2txt"].'</span>';}} add_shortcode( 'txt_em2', 'shortcode_txtemtwo' );
function shortcode_txtadr(){ $options = get_option( 'clientcms_options' ); if($options["adrtxt"]){return '<span class="txt_address">'.$options["adrtxt"].'</span>';}} add_shortcode( 'txt_adr', 'shortcode_txtadr' );
function shortcode_txtcty(){ $options = get_option( 'clientcms_options' ); if($options["ctytxt"]){return '<span class="txt_city">'.$options["ctytxt"].'</span>';}} add_shortcode( 'txt_cty', 'shortcode_txtcty' );
function shortcode_txtstt(){ $options = get_option( 'clientcms_options' ); if($options["stttxt"]){return '<span class="txt_state">'.$options["stttxt"].'</span>';}} add_shortcode( 'txt_stt', 'shortcode_txtstt' );
function shortcode_txtzip(){ $options = get_option( 'clientcms_options' ); if($options["ziptxt"]){return '<span class="txt_zip">'.$options["ziptxt"].'</span>';}} add_shortcode( 'txt_zip', 'shortcode_txtzip' );

//// ---- [socialbox] ---- ////
function socialbox_shortcode( $atts ){
	$socnet = get_bloginfo('template_url').'/img/social/';
	$options = get_option( 'clientcms_options' );
	extract( shortcode_atts( array('key' => ''), $atts ) );
	switch($key) : // Individual buttons
		case 'etsy'			: if($options["eturl"]) { return '<a class="btn_etsy" href="'.$options["eturl"].'" target="_blank"><img class="icon" src="'.$socnet.'etsy.png" alt="Etsy" ></a>';} break;
		case 'facebook'		: if($options["fburl"]) { return '<a class="btn_facebook" href="'.$options["fburl"].'" target="_blank"><img class="icon" src="'.$socnet.'facebook.png" alt="Facebook" ></a>';} break;
		case 'flickr'		: if($options["flurl"]) { return '<a class="btn_flickr" href="'.$options["flurl"].'" target="_blank"><img class="icon" src="'.$socnet.'flickr.png" alt="Flicker" ></a>';} break;
		case 'googleplus'	: if($options["gpurl"]) { return '<a class="btn_googleplus" href="'.$options["gpurl"].'" target="_blank"><img class="icon" src="'.$socnet.'google-plus.png" alt="Google Plus" ></a>';} break;
		case 'instagram'	: if($options["igurl"]) { return '<a class="btn_instagram" href="'.$options["igurl"].'" target="_blank"><img class="icon" src="'.$socnet.'instagram.png" alt="Instagram" ></a>';} break;
		case 'linkedin'		: if($options["liurl"]) { return '<a class="btn_linkedin" href="'.$options["liurl"].'" target="_blank"><img class="icon" src="'.$socnet.'linkedin.png" alt="Linkedin" ></a>';} break;
		case 'pinterest'	: if($options["pturl"]) { return '<a class="btn_pinterest" href="'.$options["pturl"].'" target="_blank"><img class="icon" src="'.$socnet.'pinterest.png" alt="Pinterest" ></a>';} break;
		case 'twitter'		: if($options["twurl"]) { return '<a class="btn_twitter" href="'.$options["twurl"].'" target="_blank"><img class="icon" src="'.$socnet.'twitter.png" alt="Facebook" ></a>';} break;
		case 'vimeo'		: if($options["vmurl"]) { return '<a class="btn_vimeo" href="'.$options["vmurl"].'" target="_blank"><img class="icon" src="'.$socnet.'vimeo.png" alt="Vimeo" ></a>';} break;
		case 'youtube'		: if($options["yturl"]) { return '<a class="btn_youtube" href="'.$options["yturl"].'" target="_blank"><img class="icon" src="'.$socnet.'youtube.png" alt="Youtube" ></a>';} break;
		case 'extra1' 		: if($options["x1url"]) { return '<a class="btn_extra1" href="'.$options["x1url"].'" target="_blank"><img class="icon" src="'.$socnet.'button1.png" alt="Social Network" ></a>';} break;
		case 'extra2'		: if($options["x2url"]) { return '<a class="btn_extra2" href="'.$options["x2url"].'" target="_blank"><img class="icon" src="'.$socnet.'button2.png" alt="Social Network" ></a>';} break;
		case 'extra3'		: if($options["x3url"]) { return '<a class="btn_extra3" href="'.$options["x3url"].'" target="_blank"><img class="icon" src="'.$socnet.'button3.png" alt="Social Network" ></a>';} break;
		case 'extra4'		: if($options["x4url"]) { return '<a class="btn_extra4" href="'.$options["x4url"].'" target="_blank"><img class="icon" src="'.$socnet.'button4.png" alt="Social Network" ></a>';} break;
		case 'extra5'		: if($options["x5url"]) { return '<a class="btn_extra5" href="'.$options["x5url"].'" target="_blank"><img class="icon" src="'.$socnet.'button5.png" alt="Social Network" ></a>';} break;
		case 'extra6'		: if($options["x6url"]) { return '<a class="btn_extra6" href="'.$options["x6url"].'" target="_blank"><img class="icon" src="'.$socnet.'button6.png" alt="Social Network" ></a>';} break;
		case 'extra7'		: if($options["x7url"]) { return '<a class="btn_extra7" href="'.$options["x7url"].'" target="_blank"><img class="icon" src="'.$socnet.'button7.png" alt="Social Network" ></a>';} break;
		case 'rss'			: if($options["rssurl"]){ return '<a class="btn_rss" href="'.$options["rssurl"].'" target="_blank"><img class="icon" src="'.$socnet.'rss.png" alt="Social Network" ></a>';} break;
		case 'email1'		: if($options["em1txt"]){ $result .=  '<a class="btn_email1" href="mailto:'.$options["em1txt"].'"><img class="icon" src="'.$socnet.'email1.png" alt="Email" ></a>'; } break;
		case 'email2'		: if($options["em2txt"]){ $result .=  '<a class="btn_email2" href="mailto:'.$options["em2txt"].'"><img class="icon" src="'.$socnet.'email2.png" alt="Email 2" ></a>'; } break;
		case 'phone1'		: if($options["ph1txt"]){ $phone = explode(" ", $options["ph1txt"]); return '<a class="btn_phoneone" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'"><img class="icon" src="'.$socnet.'phone1.png" alt="Phone" ></a>'; } break;
		case 'phone2'		: if($options["ph2txt"]){ $phone = explode(" ", $options["ph2txt"]); return '<a class="btn_phonetwo" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'"><img class="icon" src="'.$socnet.'phone1.png" alt="Phone 2" ></a>'; } break;
		default : { // Social Box
			$result = '<div class="socialbox">';
				// Social Media
				if (1 == $options["fburladd"] && $options["fburl"]) { $result .= '<a class="btn_facebook" href="'.$options["fburl"].'" target="_blank"><img class="icon" src="'.$socnet.'facebook.png" alt="Facebook" ></a>'; }
				if (1 == $options["twurladd"] && $options["twurl"]) { $result .= '<a class="btn_twitter" href="'.$options["twurl"].'" target="_blank"><img class="icon" src="'.$socnet.'twitter.png" alt="Twitter" ></a>'; }
				if (1 == $options["liurladd"] && $options["liurl"]) { $result .= '<a class="btn_linkedin" href="'.$options["liurl"].'" target="_blank"><img class="icon" src="'.$socnet.'linkedin.png" alt="Linkedin" ></a>'; }
				if (1 == $options["eturladd"] && $options["eturl"]) { $result .= '<a class="btn_etsy" href="'.$options["eturl"].'" target="_blank"><img class="icon" src="'.$socnet.'etsy.png" alt="Etsy" ></a>'; }
				if (1 == $options["yturladd"] && $options["yturl"]) { $result .= '<a class="btn_youtube" href="'.$options["yturl"].'" target="_blank"><img class="icon" src="'.$socnet.'youtube.png" alt="Youtube" /></a>'; }
				if (1 == $options["gpurladd"] && $options["gpurl"]) { $result .= '<a class="btn_googleplus" href="'.$options["gpurl"].'" target="_blank"><img class="icon" src="'.$socnet.'google-plus.png" alt="Google Plus" /></a>'; }
				if (1 == $options["igurladd"] && $options["igurl"]) { $result .= '<a class="btn_instagram" href="'.$options["igurl"].'" target="_blank"><img class="icon" src="'.$socnet.'instagram.png" alt="Instagram" /></a>'; }
				if (1 == $options["pturladd"] && $options["pturl"]) { $result .= '<a class="btn_pinterest" href="'.$options["pturl"].'" target="_blank"><img class="icon" src="'.$socnet.'pinterest.png" alt="Pinterest" /></a>'; }
				if (1 == $options["blurladd"] && $options["glurl"]) { $result .= '<a class="btn_flickr" href="'.$options["flurl"].'" target="_blank"><img class="icon" src="'.$socnet.'flickr.png" alt="Flicker" /></a>'; }
				if (1 == $options["vmurladd"] && $options["vmurl"]) { $result .= '<a class="btn_vimeo" href="'.$options["vmurl"].'" target="_blank"><img class="icon" src="'.$socnet.'vimeo.png" alt="Vimeo" /></a>'; }
				if (1 == $options["x1urladd"] && $options["x1url"]) { $result .= '<a class="btn_extra1" href="'.$options["x1url"].'" target="_blank"><img class="icon" src="'.$socnet.'button1.png" alt="Social Network" /></a>'; }
				if (1 == $options["x2urladd"] && $options["x2url"]) { $result .= '<a class="btn_extra2" href="'.$options["x2url"].'" target="_blank"><img class="icon" src="'.$socnet.'button2.png" alt="Social Network" /></a>'; }
				if (1 == $options["x3urladd"] && $options["x3url"]) { $result .= '<a class="btn_extra3" href="'.$options["x3url"].'" target="_blank"><img class="icon" src="'.$socnet.'button3.png" alt="Social Network" /></a>'; }
				if (1 == $options["x4urladd"] && $options["x4url"]) { $result .= '<a class="btn_extra4" href="'.$options["x4url"].'" target="_blank"><img class="icon" src="'.$socnet.'button4.png" alt="Social Network" /></a>'; }
				if (1 == $options["fburladd"] && $options["x5url"]) { $result .= '<a class="btn_extra5" href="'.$options["x5url"].'" target="_blank"><img class="icon" src="'.$socnet.'button5.png" alt="Social Network" /></a>'; }
				if (1 == $options["fburladd"] && $options["x6url"]) { $result .= '<a class="btn_extra6" href="'.$options["x6url"].'" target="_blank"><img class="icon" src="'.$socnet.'button6.png" alt="Social Network" /></a>'; }
				if (1 == $options["fburladd"] && $options["x7url"]) { $result .= '<a class="btn_extra7" href="'.$options["x7url"].'" target="_blank"><img class="icon" src="'.$socnet.'button7.png" alt="Social Network" /></a>'; }
				if (1 == $options["rssurladd"]) {$result .= '<a class="btn_rss" href="'.$options["rssurl"].'" target="_blank"><img class="icon" src="'.$socnet.'rss.png" alt="RSS" /></a>'; }
				if (1 == $options["em1txtadd"] && $options["em1txt"]){ $result .= '<a class="btn_email1" href="mailto:'.$options["em1txt"].'" title="Email - '.$options["em1txt"].'"><img class="icon" src="'.$socnet.'email1.png" alt="Email - ' .$options["em1txt"]. '" /></a>'; }
				if (1 == $options["em2txtadd"] && $options["em2txt"]){ $result .= '<a class="btn_email2" href="mailto:'.$options["em2txt"].'" title="Email - '.$options["em2txt"].'"><img class="icon" src="'.$socnet.'email2.png" alt="Email - ' .$options["em2txt"]. '" /></a>'; }
				if (1 == $options["phtxtadd"]  && $options["ph1txt"]){ $phone = explode(" ", $options["ph1txt"]); $result .= '<a class="btn_phoneone" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'" title="Call- '.$options["ph1txt"].'"><img class="icon" src="'.$socnet.'phone1.png" alt="Phone - '. "$phone[0] ( $phone[1] ) $phone[2] - $phone[3]" .'" /></a>'; }
				if (1 == $options["ph2txtadd"] && $options["ph2txt"]){ $phone = explode(" ", $options["ph2txt"]); $result .= '<a class="btn_phonetwo" href="tel:+'.$phone[0].$phone[1].$phone[2].$phone[3].'" title="Call- '.$options["ph1txt"].'"><img class="icon" src="'.$socnet.'phone2.png" alt="Phone - '. "$phone[0] ( $phone[1] ) $phone[2] - $phone[3]" .'" /></a>'; }
			$result .= '</div>';
			return $result;
			break;
		}
	endswitch;
} add_shortcode( 'socialbox', 'socialbox_shortcode' ); //*/
?>