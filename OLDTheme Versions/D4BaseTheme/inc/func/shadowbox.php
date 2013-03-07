<?php function shadowbox_init(){
 echo '<script type="text/javascript" src="' . bloginfo("template_url") . '/inc/shadowbox/shadowbox.js"></script>';
 echo '<script type="text/javascript" src="' . bloginfo("template_url") . '/inc/shadowbox/shadowbox.css"></script>';
 echo '<script type="text/javascript">Shadowbox.init();</script>';
 echo '<script type="text/javascript">$(document).ready(function(){$(".gallery a").attr("rel","shadowbox[gallery]");});</script>';
} add_action('wp_head', 'shadowbox_init'); ?>