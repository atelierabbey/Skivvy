<?php #16Oct13
//// ---- the_snippet() function to replace the_excerpt() ---- //// the_snippet(72,'Read More');
function the_snippet($length=55,$readmore='Read More') {
  global $post;
  $text = $post->post_content;
  $text = strip_shortcodes( $text );
  $text = apply_filters('the_content', $text);
  $text = str_replace(']]>', ']]&gt;', $text);
  $more_link = '<a href="'.get_permalink($post->ID).'" class="readmorebtn">'.$readmore.'</a>';
  echo wp_trim_words($text,$length,$more_link); 
} 
?>