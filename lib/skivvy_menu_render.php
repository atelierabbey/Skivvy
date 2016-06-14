<?php #19Dec15 - https://codex.wordpress.org/Class_Reference/Walker


class skivvy_walker_main extends Walker_Nav_Menu {
  
		function start_lvl( &$output, $depth ) {
			// depth dependent classes
				$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
				$display_depth = ( $depth + 1); // because it counts the first submenu as 0
				$classes = array(
					'sub-menu',
					( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
					// ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
					//'menu-tier-' . $display_depth
					);
				$class_names = implode( ' ', $classes );

			// build html
				# $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
				$output .= '<ul class="' . $class_names . '">';
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= '</ul>';
			$output .= "\n";
		}

		function start_el( &$output, $item, $depth, $args ) {
			global $wp_query;
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			// depth dependent classes
			$depth_classes = array(
			#	( $depth == 0 ? 'navitem-item' : 'navitem-sub' ),
			#	( $depth >=2 ? 'sub-sub-menu-item' : '' ),
				( $depth % 2 ? 'navitem-odd' : 'navitem-even' ),
			#	'menu-item-depth-' . $depth
			);
			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// build html
			$output .= $indent . '<li class="navitem-'. $item->ID . ' ' . $depth_class_names . ' ' . $class_names . '">';

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ' title="' .esc_attr( apply_filters( 'the_title', $item->title, $item->ID ) ).'"';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			//$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after
			);

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		function end_el( &$output, $item, $depth=0, $args=array() ) {
			$output .= '</li>';
			#$output .= ' ';
			$output .= "\n";
		}
}
/*
//// ---- Advanced Menu Styling Classes ---- ////
	if( class_exists( 'SimpleXMLElement' ) ) {
		// Cleans up and counts number of menu items
		function skivvy_advmenus( $output ) {
				libxml_use_internal_errors( false );
				try {
					$xml = new SimpleXMLElement( preg_replace( '#>([^<]+)<#i', '><![CDATA[\\1]]><', $output ), LIBXML_NOWARNING );
				}
				catch( Exception $e ) {
					return $output;
				}
				$container = array();
				if( ! $xml->li ) {
					list( , $item ) = each( $xml->xpath( 'ul' ) );
					if( ! $item ) list( , $item ) = each( $xml->xpath( 'menu' ) );
					if( $item ) {
						$container = array( '<' . $xml->getName(), '</' . $xml->getName() . '>' );
						foreach( $xml->attributes() as $key => $value ) $container[0] .= ' ' . $key . '="' . $value . '"';
						$container[0] .= '>';
				}
				}
				else $item = $xml;
				if( count( $item ) ) return $container[0]. preg_replace( '#<\?[^>]*\?>#', '', preg_replace( '#<!\[CDATA\[([^<]+)\]\]>#', '\\1', skivvy_advmenus_level( $item )->asXML() ) ) . $container[1];
				else return $container[0] . $output . $container[1];
			} add_filter( 'wp_nav_menu', 'skivvy_advmenus' );

		// Adds .odd-menu-item , .even-menu-item , .last-menu-item , .first-menu-item  to the Nav menu
			function skivvy_advmenus_level( $xml ) {

				if( 0 < $count = count( $xml->li ) ) {
					$i = 1;
					foreach( $xml->li as $item ) {
						$attributes = $item->attributes();
						// Adds Even Odd classes
							if( $i % 2 ) $attributes['class'] = 'odd-menu-item ' . $attributes['class'];
							else $attributes['class'] = 'even-menu-item ' . $attributes['class'];

						// Adds parent class if has submenu
							if( $item->ul ) {
								$attributes['class'] = 'parent-menu-item ' . $attributes['class'];
								skivvy_advmenus_level( $item->ul );
							}
							elseif( $item->menu ) {
								$attributes['class'] = 'parent-menu-item ' . $attributes['class'];
								skivvy_advmenus_level( $item->menu );
							}

						// Adds First and Last class
							if( $i == $count ) $attributes['class'] = 'last-menu-item ' . $attributes['class'];
							if( $i == 1 ) $attributes['class'] = 'first-menu-item ' . $attributes['class'];
							$i ++;
					}
				}
				return $xml;

			}

	} // Ends if class_exists('SimpleXMLElement') */





?>