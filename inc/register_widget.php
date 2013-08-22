<?php #22Aug13
function skivvy_add_widget() {
	register_widget( 'Bucket_Widget' );
} add_action( 'widgets_init', 'skivvy_add_widget' );

include_once('widget_bucket.php');
?>