<?php // D4 Theme Options  -  From http://www.webdesignerdepot.com/2012/02/creating-a-custom-wordpress-theme-options-page/



// To-Add

//	Tagline

//	Custom Title Tag

//	Meta Data



add_action( 'admin_init', 'theme_options_init' );

add_action( 'admin_menu', 'theme_options_add_page' ); 

function theme_options_init(){ register_setting( 'sample_options', 'sample_theme_options');} 

function theme_options_add_page() { add_theme_page( __( 'Theme Options', 'sampletheme' ), __( 'Theme Options', 'sampletheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' ) ;}



function theme_options_do_page() {

		global $select_options;

		if ( ! isset( $_REQUEST['settings-updated'] ) ) 

		$_REQUEST['settings-updated'] = false;

		?>

		

		<div>

		<?php screen_icon(); echo "<h2>". __( 'Custom Theme Options', 'customtheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>

			<div>

			<p><strong><?php _e( 'Options saved', 'customtheme' ); ?></strong></p></div>

		<?php endif; ?> 



		<form method="post" action="options.php">

			<?php settings_fields( 'sample_options' ); ?>

			<?php $options = get_option( 'sample_theme_options' ); ?>

			<table>

				<tr valign="top">

					<th scope="row"><?php _e( 'Facebook URL', 'customtheme' ); ?></th>

					<td><input id="sample_theme_options[fburl]" type="text" name="sample_theme_options[fburl]" value="<?php esc_attr_e( $options['fburl'] ); ?>" />

					Shortcode: [btn_fb]   |   css: a.btn_facebook </td>

				</tr>

				<tr valign="top">

					<th scope="row"><?php _e( 'Twitter URL', 'customtheme' ); ?></th>

					<td><input id="sample_theme_options[twurl]" type="text" name="sample_theme_options[twurl]" value="<?php esc_attr_e( $options['twurl'] ); ?>" />

					Shortcode: [btn_tw]   |   css: a.btn_twitter</td>

				</tr>

				<tr valign="top">

					<th scope="row"><?php _e( 'Linkedin URL', 'customtheme' ); ?></th>

					<td><input id="sample_theme_options[liurl]" type="text" name="sample_theme_options[liurl]" value="<?php esc_attr_e( $options['liurl'] ); ?>" />

					Shortcode: [btn_li]   |   css: a.btn_linkedin</td>

				</tr>

				<tr valign="top">

					<th scope="row"><?php _e( 'Youtube URL', 'customtheme' ); ?></th>

					<td><input id="sample_theme_options[yturl]" type="text" name="sample_theme_options[yturl]" value="<?php esc_attr_e( $options['yturl'] ); ?>" />

					Shortcode: [btn_yt]   |   css: a.btn_youtube</td>

				</tr>

				<tr valign="top">

					<th scope="row"><?php _e( 'Phone', 'customtheme' ); ?></th>

					<td><input id="sample_theme_options[phtxt]" type="text" name="sample_theme_options[phtxt]" value="<?php esc_attr_e( $options['phtxt'] ); ?>" />

					Shortcode: [txt_ph]   |   css: span.txt_phone</td>

				</tr>

				<tr valign="top">

					<th scope="row"><?php _e( 'Address', 'customtheme' ); ?></th>

					<td><textarea id="sample_theme_options[adtxt]" class="large-text" cols="50" rows="10" name="sample_theme_options[adtxt]"><?php echo esc_textarea( $options['adtxt'] ); ?></textarea>

					Shortcode: [txt_ad]   |   css: span.txt_address</td>

				</tr>
				<!--
				<tr valign="top">

					<th scope="row"><?php _e( 'Google Analytics', 'customtheme' ); ?></th>

					<td><textarea id="sample_theme_options[gacode]" class="large-text" cols="50" rows="10" name="sample_theme_options[gacode]"><?php echo esc_textarea( $options['gacode'] ); ?></textarea>Automagically Hooks to Footer</td>

				</tr>
				-->
			</table> 

			<p><input type="submit" value="<?php _e( 'Save Options', 'customtheme' ); ?>" /></p>

		</form>

	</div>

	<?php 

} 





// Google Analytics Footer Hook // Added 2012 November 15 - Hooks to footer to add Google Analytics from Database to include Google Analytics
/* Remove 17 Jan 13 - Degraded to Analtics.php 
function incAnalytics() {
 $options = get_option( 'sample_theme_options' );
 if (isset($options['gacode'])) { echo $options['gacode'];}
}
add_action('wp_footer', 'incAnalytics'); 
*/




//// SHORT CODES

// Facebook Shortcode

function fburl_sc( $atts ){$options = get_option( 'sample_theme_options' );?>

	<a class="btn_facebook" href="<?php echo $options['fburl']; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/clear.gif" alt="Facebook - <?php echo $options['fburl']; ?>"></a> <?php

} add_shortcode( 'btn_fb', 'fburl_sc' );



// Twitter Shortcode

function twurl_sc( $atts ){$options = get_option( 'sample_theme_options' );?>

	<a class="btn_twitter" href="<?php echo $options['twurl']; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/clear.gif" alt="Twitter - <?php echo $options['twurl']; ?>"></a> <?php

} add_shortcode( 'btn_tw', 'twurl_sc' );



// Linkedin Shortcode

function liurl_sc( $atts ){$options = get_option( 'sample_theme_options' );?>

	<a class="btn_linkedin" href="<?php echo $options['liurl']; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/clear.gif" alt="Linkedin - <?php echo $options['liurl']; ?>"></a> <?php

} add_shortcode( 'btn_li', 'liurl_sc' );



// Youtube Shortcode

function yturl_sc( $atts ){$options = get_option( 'sample_theme_options' );?>

	<a class="btn_youtube" href="<?php echo $options['yturl']; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/clear.gif" alt="Youtube - <?php echo $options['yturl']; ?>"></a> <?php

} add_shortcode( 'btn_yt', 'yturl_sc' );



// Phone Shortcode

function phtxt_sc( $atts ){$options = get_option( 'sample_theme_options' );?>

	<span class="txt_phone"><?php echo $options['phtxt']; ?></span> <?php

} add_shortcode( 'txt_ph', 'phtxt_sc' );



// Phone Shortcode

function adtxt_sc( $atts ){$options = get_option( 'sample_theme_options' );?>

	<span class="txt_address"><?php echo $options['adtxt']; ?></span> <?php

} add_shortcode( 'txt_ad', 'adtxt_sc' );







?>