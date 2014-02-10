<?php // Wp-jcycle required https://github.com/atelierabbey/WPJcycle - http://jquery.malsup.com/cycle2/api/

	// Enqueue script
			wp_enqueue_script('jcycle2');



	// Start SLIDE WRAP
			echo ( 
				'<div '.
					' class="cycle-slideshow"'. // Initializing class, default for cycle2
					' data-cycle-pager="#per-slide-template"'. // Connects to #per-slide-template box below
					' data-cycle-slides=".cycle-slide"'. // identifies the class identifier for slides
					' data-pause-on-hover="true"'. // Pause on hover
					' style="position:relative;"'.
				'>'
			);





	// SLIDE LOOP
			$slidequery = new WP_Query(array(
				'post_type' => 'jCycle_slider',
				'posts_per_page' => 5,
				'order' => 'ASC',
				'orderby' => 'none'
			)); while ( $slidequery->have_posts() ) { $slidequery->the_post();

				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'full', true);

				// SLIDE 
					echo '<div class="cycle-slide slide-' . get_the_ID() . '" style="position:absolute;' . 'background-image:url(\'' . $image_url[0] . '\');'. '">';
						# echo '<h1>' . get_the_title() . '</h1>';
						# the_content();
					echo '</div>';



			} wp_reset_postdata(); 





		// Cycle Pagers
			# echo '<div class="cycle-pagerelement cycle-prev">&#8617;</div>';
			# echo '<div class="cycle-pagerelement cycle-resume" data-cycle-cmd="resume">&#187;</div>';
			# echo '<div class="cycle-pagerelement cycle-pause" data-cycle-cmd="pause">&#35;</div>';
			# echo '<div class="cycle-pagerelement cycle-next">&#8618;</div>';

	// End SLIDE WRAP
		echo '</div>';

		// Per Slide Template
			# echo '<div id="per-slide-template"></div>';
?>