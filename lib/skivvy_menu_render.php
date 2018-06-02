<?php # 2017-08-31

function skivvy_nav_classes( $classes, $item, $args, $depth ) {
	// /wp-includes/nav-menu-template.php
	# $classes = array();
	# $classes[] = 'menu-item';
	# $classes[] = 'menu-item-type-' . $item->type;
	# $classes[] = 'menu-item-object-' . $item->object;
	# if ( 'post_type' === $item->type && $front_page_id === (int) $item->object_id ) {
	# 	$classes[] = 'menu-item-home';
	# }
	#	$classes[] = 'navitem-'. $item->ID;
	#	$classes[] = ( $depth == 0 ? 'menu-item-item' : 'menu-item-sub' );
	#	$classes[] = ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' );
	#	$classes[] = 'menu-item-depth-' . $depth;
	#	$classes[] = ( $depth >=2 ? 'menu-item-sub-sub' : '' );
	#	$classes[] = ( $depth == 0 ? 'menu-item-item' : 'menu-item-sub' );

    return $classes;

} add_filter( 'nav_menu_css_class', 'skivvy_nav_classes', 0, 4 );

class skivvy_walker_main extends Walker_Nav_Menu {
  
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			// depth dependent classes
				$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
				$display_depth = $depth + 1; // because it counts the first submenu as 0
				$classes = array(
					'sub-menu',
					( $display_depth % 2 ? 'menu-odd' : 'menu-even' ),
					( $display_depth >=2 ? 'sub-sub-menu' : '' ),
					'menu-tier-' . $display_depth
				);
				$class_names = implode( ' ', $classes );

			// build html
				# $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
				$output .= '<ul class="' . $class_names . '">';
		}

		function end_lvl( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$output .= '</ul>';
			$output .= "\n";
		}

		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			global $wp_query;
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes = apply_filters( 'nav_menu_css_class', array_filter($classes), $item, $args, $depth );

			// link attributes
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) . '"' : ' title="' .esc_attr( apply_filters( 'the_title', $item->title, $item->ID ) ).'"';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) . '"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) . '"' : '';
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) . '"' : '';
				#$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after
			);

			// build html
			$output .= $indent;
			$output .= '<li class="' .  esc_attr( implode( ' ', $classes ) )  . '">';
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		}

		function end_el( &$output, $item, $depth=0, $args=array() ) {
			$output .= '</li>';
			#$output .= ' ';
			$output .= "\n";
		}
}
