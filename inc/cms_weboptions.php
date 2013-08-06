<?php #19Jul13 // The Bat signal
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
            <br />
            <h3>Contact Information</h3>
            <table>
				<tr valign="top">
					<th scope="row">Phone 1</th>
					<td><input id="clientcms_options[phtxt]" type="text" name="clientcms_options[ph1txt]" value="<?php esc_attr_e( $options['ph1txt'] ); ?>" />
					Shortcode: [txt_ph1]   |   css: span.txt_phoneone</td>
				</tr>
				<tr valign="top">
					<th scope="row">Phone 2</th>
					<td><input id="clientcms_options[ph2txt]" type="text" name="clientcms_options[ph2txt]" value="<?php esc_attr_e( $options['ph2txt'] ); ?>" />
					Shortcode: [txt_ph2]   |   css: span.txt_phonetwo</td>
				</tr>
                <tr><td colspan="2"><br /></td></tr>
				<tr valign="top">
					<th scope="row">Email 1</th>
					<td><input id="clientcms_options[em1txt]" type="text" name="clientcms_options[em1txt]" value="<?php esc_attr_e( $options['em1txt'] ); ?>" />
					Shortcode: [txt_em1]   |   css: span.txt_emailone</td>
				</tr>
				<tr valign="top">
					<th scope="row">Email 2</th>
					<td><input id="clientcms_options[em2txt]" type="text" name="clientcms_options[em2txt]" value="<?php esc_attr_e( $options['em2txt'] ); ?>" />
					Shortcode: [txt_em2]   |   css: span.txt_emailtwo</td>
				</tr>
				<tr><td colspan="2"><br /></td></tr>
                <tr valign="top">
					<th scope="row">Address</th>
					<td><input id="clientcms_options[adrtxt]" type="text" name="clientcms_options[adrtxt]" value="<?php esc_attr_e( $options['adrtxt'] ); ?>" />
					Shortcode: [txt_adr]   |   css: span.txt_address</td>
				</tr>
                <tr valign="top">
					<th scope="row">City</th>
					<td><input id="clientcms_options[ctytxt]" type="text" name="clientcms_options[ctytxt]" value="<?php esc_attr_e( $options['ctytxt'] ); ?>" />
					Shortcode: [txt_cty]   |   css: span.txt_city</td>
				</tr>
                <tr valign="top">
					<th scope="row">State</th>
					<td><input id="clientcms_options[stttxt]" type="text" name="clientcms_options[stttxt]" value="<?php esc_attr_e( $options['stttxt'] ); ?>" />
					Shortcode: [txt_stt]   |   css: span.txt_state</td>
				</tr>
                <tr valign="top">
					<th scope="row">ZIP</th>
					<td><input id="clientcms_options[ziptxt]" type="text" name="clientcms_options[ziptxt]" value="<?php esc_attr_e( $options['ziptxt'] ); ?>" />
					Shortcode: [txt_zip]   |   css: span.txt_zip</td>
				</tr>
			</table>
			<hr />
            <h3>Social Media</h3>
            <style>
				tr img.icon {
					height: 20px;
					margin-right: 10px;
					max-width: 20px;
				}
			</style>
			<?php $socnet = get_bloginfo('template_url').'/img/social/'; ?>
			<span>Shortcode: [socialbox]   |   css:div.socialbox</span><br><br>
			<table>
				<tr valign="top">
					<th scope="row">Etsy</th>
					<td><input id="clientcms_options[eturl]" type="text" size="50" name="clientcms_options[eturl]" value="<?php esc_attr_e( $options['eturl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>etsy.png" /> Shortcode: [socialbox key="etsy"]   |   css: a.btn_etsy </td>
				</tr>
				<tr valign="top">
					<th scope="row">Facebook</th>
					<td><input id="clientcms_options[fburl]" type="text" size="50" name="clientcms_options[fburl]" value="<?php esc_attr_e( $options['fburl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>facebook.png" /> Shortcode: [socialbox key="facebook"]   |   css: a.btn_facebook </td>
				</tr>
				<tr valign="top">
					<th scope="row">Flickr</th>
					<td><input id="clientcms_options[flurl]" type="text" size="50" name="clientcms_options[flurl]" value="<?php esc_attr_e( $options['flurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>flickr.png" /> Shortcode: [socialbox key="flickr"]   |   css: a.btn_flickr</td>
				</tr>
				<tr valign="top">
					<th scope="row">Google+</th>
					<td><input id="clientcms_options[gpurl]" type="text" size="50" name="clientcms_options[gpurl]" value="<?php esc_attr_e( $options['gpurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>google-plus.png" /> Shortcode: [socialbox key="googleplus"]   |   css: a.btn_googleplus</td>
				</tr>
				<tr valign="top">
					<th scope="row">Instagram</th>
					<td><input id="clientcms_options[igurl]" type="text" size="50" name="clientcms_options[igurl]" value="<?php esc_attr_e( $options['igurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>instagram.png" /> Shortcode: [socialbox key="instagram"]   |   css: a.btn_youtube</td>
				</tr>
				<tr valign="top">
					<th scope="row">Linkedin</th>
					<td><input id="clientcms_options[liurl]" type="text" size="50" name="clientcms_options[liurl]" value="<?php esc_attr_e( $options['liurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>linkedin.png" /> Shortcode: [socialbox key="linkedin"]   |   css: a.btn_linkedin</td>
				</tr>
				<tr valign="top">
					<th scope="row">Pinterest</th>
					<td><input id="clientcms_options[pturl]" type="text" size="50" name="clientcms_options[pturl]" value="<?php esc_attr_e( $options['pturl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>pinterest.png" /> Shortcode: [socialbox key="pinterest"]   |   css: a.btn_pinterest</td>
				</tr>
				<tr valign="top">
					<th scope="row">Twitter</th>
					<td><input id="clientcms_options[twurl]" type="text" size="50" name="clientcms_options[twurl]" value="<?php esc_attr_e( $options['twurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>twitter.png" /> Shortcode: [socialbox key="twitter"]   |   css: a.btn_twitter</td>
				</tr>
				<tr valign="top">
					<th scope="row">Vimeo</th>
					<td><input id="clientcms_options[vmurl]" type="text" size="50" name="clientcms_options[vmurl]" value="<?php esc_attr_e( $options['vmurl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>vimeo.png" /> Shortcode: [socialbox key="vimeo"]   |   css: a.btn_vimeo</td>
				</tr>
				<tr valign="top">
					<th scope="row">Youtube</th>
					<td><input id="clientcms_options[yturl]" type="text" size="50" name="clientcms_options[yturl]" value="<?php esc_attr_e( $options['yturl'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>youtube.png" /> Shortcode: [socialbox key="youtube"]   |   css: a.btn_youtube</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 1</th>
					<td><input id="clientcms_options[x1url]" type="text" size="50" name="clientcms_options[x1url]" value="<?php esc_attr_e( $options['x1url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button1.png" /> Shortcode: [socialbox key="extra1"]   |   css: a.btn_extra1</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 2</th>
					<td><input id="clientcms_options[x2url]" type="text" size="50" name="clientcms_options[x2url]" value="<?php esc_attr_e( $options['x2url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button2.png" /> Shortcode: [socialbox key="extra2"]   |   css: a.btn_extra2</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 3</th>
					<td><input id="clientcms_options[x3url]" type="text" size="50" name="clientcms_options[x3url]" value="<?php esc_attr_e( $options['x3url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button3.png" /> Shortcode: [socialbox key="extra3"]   |   css: a.btn_extra3</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 4</th>
					<td><input id="clientcms_options[x4url]" type="text" size="50" name="clientcms_options[x4url]" value="<?php esc_attr_e( $options['x4url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button4.png" /> Shortcode: [socialbox key="extra4"]   |   css: a.btn_extra4</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 5</th>
					<td><input id="clientcms_options[x5url]" type="text" size="50" name="clientcms_options[x5url]" value="<?php esc_attr_e( $options['x5url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button5.png" /> Shortcode: [socialbox key="extra5"]   |   css: a.btn_extra5</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 6</th>
					<td><input id="clientcms_options[x6url]" type="text" size="50" name="clientcms_options[x6url]" value="<?php esc_attr_e( $options['x6url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button6.png" /> Shortcode: [socialbox key="extra6"]   |   css: a.btn_extra6</td>
				</tr>
				<tr valign="top">
					<th scope="row">Extra 7</th>
					<td><input id="clientcms_options[x7url]" type="text" size="50" name="clientcms_options[x7url]" value="<?php esc_attr_e( $options['x7url'] ); ?>" /></td>
					<td><img class="icon" src="<?php echo $socnet ?>button7.png" /> Shortcode: [socialbox key="extra7"]   |   css: a.btn_extra7</td>
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
function shortcode_txtphone(){ $options = get_option( 'clientcms_options' ); if($options["ph1txt"]){return '<span class="txt_phoneone">'.$options["ph1txt"].'</span>';}} add_shortcode( 'txt_ph1', 'shortcode_txtphone' );
function shortcode_txtphtwo(){ $options = get_option( 'clientcms_options' ); if($options["ph2txt"]){return '<span class="txt_phonetwo">'.$options["ph2txt"].'</span>';}} add_shortcode( 'txt_ph2', 'shortcode_txtphtwo' );
function shortcode_txtemone(){ $options = get_option( 'clientcms_options' ); if($options["em1txt"]){return '<span class="txt_emailone">'.$options["em1txt"].'</span>';}} add_shortcode( 'txt_em1', 'shortcode_txtemone' );
function shortcode_txtemtwo(){ $options = get_option( 'clientcms_options' ); if($options["em2txt"]){return '<span class="txt_emailtwo">'.$options["em2txt"].'</span>';}} add_shortcode( 'txt_em2', 'shortcode_txtemtwo' );
function shortcode_txtadr(){ $options = get_option( 'clientcms_options' ); if($options["adrtxt"]){return '<span class="txt_address">'.$options["adrtxt"].'</span>';}} add_shortcode( 'txt_adr', 'shortcode_txtadr' );
function shortcode_txtcty(){ $options = get_option( 'clientcms_options' ); if($options["ctytxt"]){return '<span class="txt_city">'.$options["ctytxt"].'</span>';}} add_shortcode( 'txt_cty', 'shortcode_txtcty' );
function shortcode_txtstt(){ $options = get_option( 'clientcms_options' ); if($options["stttxt"]){return '<span class="txt_state">'.$options["stttxt"].'</span>';}} add_shortcode( 'txt_stt', 'shortcode_txtstt' );
function shortcode_txtzip(){ $options = get_option( 'clientcms_options' ); if($options["ziptxt"]){return '<span class="txt_zip">'.$options["ziptxt"].'</span>';}} add_shortcode( 'txt_zip', 'shortcode_txtzip' );

/* // Google Maps Shortcode, hack later
function googlemap_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'width' => '500px',
        'height' => '300px',
        'apikey' => 'REPLACEME',
        'marker' => '',
        'center' => '',
        'zoom' => '13'
    ), $atts));
 
    if ($center) $setCenter = 'map.setCenter(new GLatLng('.$center.'), '.$zoom.');';
    if ($marker) $setMarker = 'map.addOverlay(new GMarker(new GLatLng('.$marker.')));';
 
    $rand = rand(1,100) * rand(1,100);
 
    return '
    	<script src="http://maps.google.com/maps?file=api&v=2.x&sensor=false&key='.$apikey.'" type="text/javascript"></script>
 
	    <script type="text/javascript">
		    function initialize() {
		      if (GBrowserIsCompatible()) {
		        var map = new GMap2(document.getElementById("map_canvas_'.$rand.'"));
		        '.$setCenter.'
		        '.$setMarker.'
		        map.setUIToDefault();
		      }
		    }
		    initialize();
	    </script>
    ';
 }add_shortcode('googlemap', 'googlemap_shortcode'); //*/


//// ---- Social Media Area ---- ////
function socnet_shortcode( $atts ){
	$socnet = get_bloginfo('template_url').'/img/social/';
	$options = get_option( 'clientcms_options' );
	extract( shortcode_atts( array('key' => ''), $atts ) );
	switch($key) :
		case 'etsy' : if($options["eturl"]){ return '<a class="btn_etsy" href="'.$options["eturl"].'" target="_blank"><img class="icon" src="'.$socnet.'etsy.png" alt="Etsy" /></a>';} break;
		case 'facebook' : if($options["fburl"]){ return '<a class="btn_facebook" href="'.$options["fburl"].'" target="_blank"><img class="icon" src="'.$socnet.'facebook.png" alt="Facebook" /></a>';} break;
		case 'flickr' : if($options["flurl"]){ return '<a class="btn_flickr" href="'.$options["flurl"].'" target="_blank"><img class="icon" src="'.$socnet.'flickr.png" alt="Flicker" /></a>';} break;
		case 'googleplus' : if($options["gpurl"]){ return '<a class="btn_googleplus" href="'.$options["gpurl"].'" target="_blank"><img class="icon" src="'.$socnet.'google-plus.png" alt="Google Plus" /></a>';} break;
		case 'instagram' : if($options["igurl"]){ return '<a class="btn_instagram" href="'.$options["igurl"].'" target="_blank"><img class="icon" src="'.$socnet.'instagram.png" alt="Instagram" /></a>';} break;
		case 'linkedin' : if($options["liurl"]){ return '<a class="btn_linkedin" href="'.$options["liurl"].'" target="_blank"><img class="icon" src="'.$socnet.'linkedin.png" alt="Linkedin" /></a>';} break;
		case 'pinterest' : if($options["pturl"]){ return '<a class="btn_pinterest" href="'.$options["pturl"].'" target="_blank"><img class="icon" src="'.$socnet.'pinterest.png" alt="Pinterest" /></a>';} break;
		case 'twitter' : if($options["twurl"]){ return '<a class="btn_twitter" href="'.$options["twurl"].'" target="_blank"><img class="icon" src="'.$socnet.'twitter.png" alt="Facebook" /></a>';} break;
		case 'vimeo' : if($options["vmurl"]){ return '<a class="btn_vimeo" href="'.$options["vmurl"].'" target="_blank"><img class="icon" src="'.$socnet.'vimeo.png" alt="Vimeo" /></a>';} break;
		case 'youtube' : if($options["yturl"]){ return '<a class="btn_youtube" href="'.$options["yturl"].'" target="_blank"><img class="icon" src="'.$socnet.'youtube.png" alt="Youtube" /></a>';} break;
		case 'extra1' : if($options["x1url"]){ return '<a class="btn_extra1" href="'.$options["x1url"].'" target="_blank"><img class="icon" src="'.$socnet.'button1.png" alt="Social Network" /></a>';} break;
		case 'extra2' : if($options["x2url"]){ return '<a class="btn_extra2" href="'.$options["x2url"].'" target="_blank"><img class="icon" src="'.$socnet.'button2.png" alt="Social Network" /></a>';} break;
		case 'extra3' : if($options["x3url"]){ return '<a class="btn_extra3" href="'.$options["x3url"].'" target="_blank"><img class="icon" src="'.$socnet.'button3.png" alt="Social Network" /></a>';} break;
		case 'extra4' : if($options["x4url"]){ return '<a class="btn_extra4" href="'.$options["x4url"].'" target="_blank"><img class="icon" src="'.$socnet.'button4.png" alt="Social Network" /></a>';} break;
		case 'extra5' : if($options["x5url"]){ return '<a class="btn_extra5" href="'.$options["x5url"].'" target="_blank"><img class="icon" src="'.$socnet.'button5.png" alt="Social Network" /></a>';} break;
		case 'extra6' : if($options["x6url"]){ return '<a class="btn_extra6" href="'.$options["x6url"].'" target="_blank"><img class="icon" src="'.$socnet.'button6.png" alt="Social Network" /></a>';} break;
		case 'extra7' : if($options["x7url"]){ return '<a class="btn_extra7" href="'.$options["x7url"].'" target="_blank"><img class="icon" src="'.$socnet.'button7.png" alt="Social Network" /></a>';} break;
		default : {
			$result = '<div class="socialbox">';
				if ($options["fburl"]) { $result .= '<a class="btn_facebook" href="'.$options["fburl"].'" target="_blank"><img class="icon" src="'.$socnet.'facebook.png" alt="Facebook" /></a>'; }
				if ($options["twurl"]) { $result .= '<a class="btn_twitter" href="'.$options["twurl"].'" target="_blank"><img class="icon" src="'.$socnet.'twitter.png" alt="Twitter" /></a>'; }
				if ($options["liurl"]) { $result .= '<a class="btn_linkedin" href="'.$options["liurl"].'" target="_blank"><img class="icon" src="'.$socnet.'linkedin.png" alt="Linkedin" /></a>'; }
				if ($options["eturl"]) { $result .= '<a class="btn_etsy" href="'.$options["eturl"].'" target="_blank"><img class="icon" src="'.$socnet.'etsy.png" alt="Etsy" /></a>'; }
				if ($options["yturl"]) { $result .= '<a class="btn_youtube" href="'.$options["yturl"].'" target="_blank"><img class="icon" src="'.$socnet.'youtube.png" alt="Youtube" /></a>'; }
				if ($options["gpurl"]) { $result .= '<a class="btn_googleplus" href="'.$options["gpurl"].'" target="_blank"><img class="icon" src="'.$socnet.'google-plus.png" alt="Google Plus" /></a>'; }
				if ($options["igurl"]) { $result .= '<a class="btn_instagram" href="'.$options["igurl"].'" target="_blank"><img class="icon" src="'.$socnet.'instagram.png" alt="Instagram" /></a>'; }
				if ($options["pturl"]) { $result .= '<a class="btn_pinterest" href="'.$options["pturl"].'" target="_blank"><img class="icon" src="'.$socnet.'pinterest.png" alt="Pinterest" /></a>'; }
				if ($options["glurl"]) { $result .= '<a class="btn_flickr" href="'.$options["flurl"].'" target="_blank"><img class="icon" src="'.$socnet.'flickr.png" alt="Flicker" /></a>'; }
				if ($options["vmurl"]) { $result .= '<a class="btn_vimeo" href="'.$options["vmurl"].'" target="_blank"><img class="icon" src="'.$socnet.'vimeo.png" alt="Vimeo" /></a>'; }
				if ($options["x1url"]) { $result .= '<a class="btn_extra1" href="'.$options["x1url"].'" target="_blank"><img class="icon" src="'.$socnet.'button1.png" alt="Social Network" /></a>'; }
				if ($options["x2url"]) { $result .= '<a class="btn_extra2" href="'.$options["x2url"].'" target="_blank"><img class="icon" src="'.$socnet.'button2.png" alt="Social Network" /></a>'; }
				if ($options["x3url"]) { $result .= '<a class="btn_extra3" href="'.$options["x3url"].'" target="_blank"><img class="icon" src="'.$socnet.'button3.png" alt="Social Network" /></a>'; }
				if ($options["x4url"]) { $result .= '<a class="btn_extra4" href="'.$options["x4url"].'" target="_blank"><img class="icon" src="'.$socnet.'button4.png" alt="Social Network" /></a>'; }
				if ($options["x5url"]) { $result .= '<a class="btn_extra5" href="'.$options["x5url"].'" target="_blank"><img class="icon" src="'.$socnet.'button5.png" alt="Social Network" /></a>'; }
				if ($options["x6url"]) { $result .= '<a class="btn_extra6" href="'.$options["x6url"].'" target="_blank"><img class="icon" src="'.$socnet.'button6.png" alt="Social Network" /></a>'; }
				if ($options["x7url"]) { $result .= '<a class="btn_extra7" href="'.$options["x7url"].'" target="_blank"><img class="icon" src="'.$socnet.'button7.png" alt="Social Network" /></a>'; }
			$result .= '</div>';
			return $result;
			break;
		}
	endswitch;
} add_shortcode( 'socialbox', 'socnet_shortcode' ); //*/
?>