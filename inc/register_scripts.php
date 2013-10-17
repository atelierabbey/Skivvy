<?php #22Aug13
function skivvy_script_enqueuer() {
	# wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer ); 
	wp_enqueue_script( 'skivvycustom', get_stylesheet_directory_uri().'/js/custom.js', 'jquery', '1.0', true ); 

	//// ---- Wordpress included http://codex.wordpress.org/Function_Reference/wp_enqueue_script ---- ////
	# wp_enqueue_script('jcrop'); //http://deepliquid.com/content/Jcrop.html
	# wp_enqueue_script('swfobject'); //http://code.google.com/p/swfobject/
	# wp_enqueue_script('swfupload'); //http://swfupload.org/
	# wp_enqueue_script('swfupload-degrade'); //http://swfupload.org/
	# wp_enqueue_script('swfupload-queue'); //http://swfupload.org/
	# wp_enqueue_script('swfupload-handlers'); //http://swfupload.org/
	# wp_enqueue_script('jquery-form'); //http://plugins.jquery.com/project/form/
	# wp_enqueue_script('jquery-color'); //http://plugins.jquery.com/project/color/
	# wp_enqueue_script('jquery-masonry'); //http://masonry.desandro.com/
	# wp_enqueue_script('jquery-ui-core'); //http://jqueryui.com/
	# wp_enqueue_script('jquery-ui-widget');
	# wp_enqueue_script('jquery-ui-mouse');
	# wp_enqueue_script('jquery-ui-accordion'); //http://jqueryui.com/demos/accordion/
	# wp_enqueue_script('jquery-ui-autocomplete'); //http://jqueryui.com/demos/autocomplete/
	# wp_enqueue_script('jquery-ui-slider'); //http://jqueryui.com/demos/slider/
	# wp_enqueue_script('jquery-ui-tabs'); //http://jqueryui.com/demos/tabs/
	# wp_enqueue_script('jquery-ui-sortable'); //http://jqueryui.com/demos/sortable/
	# wp_enqueue_script('jquery-ui-draggable'); //http://jqueryui.com/demos/draggable/
	# wp_enqueue_script('jquery-ui-droppable'); //http://jqueryui.com/demos/droppable/
	# wp_enqueue_script('jquery-ui-selectable'); //http://jqueryui.com/demos/selectable/
	# wp_enqueue_script('jquery-ui-position'); //http://jqueryui.com/demos/position/
	# wp_enqueue_script('jquery-ui-datepicker'); //http://jqueryui.com/demos/datepicker/
	# wp_enqueue_script('jquery-ui-resizable'); //http://jqueryui.com/demos/resizable/
	# wp_enqueue_script('jquery-ui-dialog'); //http://jqueryui.com/demos/dialog/
	# wp_enqueue_script('jquery-ui-button'); //http://jqueryui.com/demos/button/
	# wp_enqueue_script('jquery-effects-core'); //jQuery UI Effects
	# wp_enqueue_script('jquery-effects-blind'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-bounce'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-clip'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-drop'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-explode'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-fade'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-fold'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-highlight'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-pulsate'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-scale'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-shake'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-slide'); //http://jqueryui.com/effect/
	# wp_enqueue_script('jquery-effects-transfer'); //http://jqueryui.com/effect/
	# wp_enqueue_script('wp-mediaelement'); //http://mediaelementjs.com/
	# wp_enqueue_script('schedule'); //http://trainofthoughts.org/blog/2007/02/15/jquery-plugin-scheduler/
	# wp_enqueue_script('suggest'); //http://plugins.jquery.com/project/suggest
	# wp_enqueue_script('thickbox'); //http://thickbox.net/
	# wp_enqueue_script('hoverIntent'); //http://plugins.jquery.com/project/hotkeys
	# wp_enqueue_script('jquery-hotkeys'); //http://plugins.jquery.com/project/hotkeys
	# wp_enqueue_script('sack'); //http://code.google.com/p/tw-sack/
	# wp_enqueue_script('quicktags'); //http://www.alexking.org/
	# wp_enqueue_script('iris'); //https://github.com/automattic/Iris
	# wp_enqueue_script('tiny_mce'); //http://tinymce.moxiecode.com/
	# wp_enqueue_script('json2'); //https://github.com/douglascrockford/JSON-js
	# wp_enqueue_script('plupload'); //http://www.plupload.com/ Plupload Core
	# wp_enqueue_script('plupload-all'); //http://www.plupload.com/example_all_runtimes.php
	# wp_enqueue_script('plupload-html5'); //plupload-html5
	# wp_enqueue_script('plupload-flash'); //http://www.plupload.com/example_all_runtimes.php
	# wp_enqueue_script('underscore'); //http://underscorejs.org/
	# wp_enqueue_script('backbone'); //http://backbonejs.org/
} add_action('wp_enqueue_scripts', 'skivvy_script_enqueuer'); ?>