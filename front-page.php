<?php #14Aug13 ?>
<?php get_header(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.lite.js"></script>

<div class='slideshow-wrapper' style="position:relative;">
	<?php $args = array(
			'post_type' => 'd4am_slider',
			'posts_per_page' => 5,
			'order' => 'ASC', // ASC or DESC
			'orderby' => 'none' // none , ID, author, title, name, date, modified, parent, rand, comment_count, menu_order, meta_value, meta_value_num
		); $loop = new WP_Query( $args ); while ( $loop->have_posts() ) : $loop->the_post();
	?>
        <div class="slide" style="position:absolute;">
			<h1><?php the_title();?></h1>
            <?php the_post_thumbnail();?>
            <?php the_content(); ?>
        </div>
	<?php endwhile; ?>
</div>
<?php /* ?>
<div id='page'>
    <div id='next_arrow'></div>
    <div id='prev_arrow'></div>
</div><?php //*/ ?>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('.slideshow-wrapper').cycle({
			// activePagerClass: 'activeSlide', // class name used for the active pager element 
			// after:         null,  // transition callback (scope set to element that was shown):  function(currSlideElement, nextSlideElement, options, forwardFlag) 
			// allowPagerClickBubble: false, // allows or prevents click event on pager anchors from bubbling 
			// animIn:        null,  // properties that define how the slide animates in 
			// animOut:       null,  // properties that define how the slide animates out 
			// autostop:      0,     // true to end slideshow after X transitions (where X == slide count) 
			// autostopCount: 0,     // number of transitions (optionally used with autostop to define X) 
			// backwards:     false, // true to start slideshow at last slide and move backwards through the stack 
			// before:        null,  // transition callback (scope set to element to be shown):     function(currSlideElement, nextSlideElement, options, forwardFlag) 
			// cleartype:     !$.support.opacity,  // true if clearType corrections should be applied (for IE) 
			cleartypeNoBg: true, // set to true to disable extra cleartype fixing (leave false to force background color setting on slides) 
			// containerResize: 1,   // resize container to fit largest slide 
			// continuous:    0,     // true to start next transition immediately after current one completes 
			// cssAfter:      null,  // properties that defined the state of the slide after transitioning out 
			// cssBefore:     null,  // properties that define the initial state of the slide before transitioning in 
			// delay:         0,     // additional delay (in ms) for first transition (hint: can be negative) 
			// easeIn:        null,  // easing for "in" transition 
			// easeOut:       null,  // easing for "out" transition 
			// easing:        null,  // easing method for both in and out transitions 
			// end:           null,  // callback invoked when the slideshow terminates (use with autostop or nowrap options): function(options) 
			// fastOnEvent:   0,     // force fast transitions when triggered manually (via pager or prev/next); value == time in ms 
			// fit:           0,     // force slides to fit container 
			fx:            'fade', // name of transition effect (or comma separated names, ex: 'fade,scrollUp,shuffle') 
			// fxFn:          null,  // function used to control the transition: function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag) 
			// height:        'auto',// container height (if the 'fit' option is true, the slides will be set to this height as well) 
			// manualTrump:   true,  // causes manual transition to stop an active transition instead of being ignored 
			// metaAttr:      'cycle',// data- attribute that holds the option data for the slideshow 
			// next:          '#next_arrow',  // element, jQuery object, or jQuery selector string for the element to use as event trigger for next slide 
			// nowrap:        0,     // true to prevent slideshow from wrapping 
			// onPagerEvent:  null,  // callback fn for pager events: function(zeroBasedSlideIndex, slideElement) 
			// onPrevNextEvent: null,// callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement) 
			// pager:         null,  // element, jQuery object, or jQuery selector string for the element to use as pager container 
			// pagerAnchorBuilder: null, // callback fn for building anchor links:  function(index, DOMelement) 
			// pagerEvent:    'click.cycle', // name of event which drives the pager navigation 
			pause:         true,     // true to enable "pause on hover" 
			// pauseOnPagerHover: 0, // true to pause when hovering over pager link 
			// prev:          '#prev_arrow',  // element, jQuery object, or jQuery selector string for the element to use as event trigger for previous slide 
			// prevNextEvent:'click.cycle',// event which drives the manual transition to the previous or next slide 
			// random:        0,     // true for random, false for sequence (not applicable to shuffle fx) 
			// randomizeEffects: 1,  // valid when multiple effects are used; true to make the effect sequence random 
			// requeueOnImageNotLoaded: true, // requeue the slideshow if any image slides are not yet loaded 
			// requeueTimeout: 250,  // ms delay for requeue 
			// rev:           0,     // causes animations to transition in reverse (for effects that support it such as scrollHorz/scrollVert/shuffle) 
			// shuffle:       null,  // coords for shuffle animation, ex: { top:15, left: 200 } 
			// slideExpr:     null,  // expression for selecting slides (if something other than all children is required) 
			// slideResize:   1,     // force slide width/height to fixed size before every transition 
			// speed:         1000,  // speed of the transition (any valid fx speed value) 
			// speedIn:       null,  // speed of the 'in' transition 
			// speedOut:      null,  // speed of the 'out' transition 
			// startingSlide: 0,     // zero-based index of the first slide to be displayed 
			// sync:          1,     // true if in/out transitions should occur simultaneously 
			timeout:       4000,  // milliseconds between slide transitions (0 to disable auto advance) 
			// timeoutFn:     null,  // callback for determining per-slide timeout value:  function(currSlideElement, nextSlideElement, options, forwardFlag) 
			// updateActivePagerLink: null, // callback fn invoked to update the active pager link (adds/removes activePagerClass style) 
			// width:         null   // container width (if the 'fit' option is true, the slides will be set to this width as well) 
		});
	});
</script>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>


<?php get_footer(); ?>