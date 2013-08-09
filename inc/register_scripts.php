<?php #17Jun13
function skivvy_script_enqueuer() {  
// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer ); 
} add_action('wp_enqueue_scripts', 'skivvy_script_enqueuer'); ?>