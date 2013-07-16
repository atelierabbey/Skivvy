// 7May13 - The Muy Grande Update!
	Reincluded shortcode.php, browserdetector.php, custom_adminbar.php, & custom_editor.php 
	above include_once within function.php but commented out
	added area in function.php for echoing into the wp_head to leave cleanhead.php...clean.
	renamed temp_home.php into front-page.php, removed template call comment
    removed Aside category in loop.php... it was worthless anyways.
    Updated content on db-error.php
    Added Meta description to header.php. 
    Removed all 'edit' links and comment areas... because comments suck.
    Added d4_copyright(); dynamic copyright
    formatted copyright in footer
    Created advmenus.php to give some flair. Give Menus additional styles: first-menu-item, last-menu-item, parent-menu-item, odd-menu-item, even-menu-item
    Updated styling of main_nav menu, included all arguments, formatted container div, adjusted function.css & style.css
    Removed various filters to clean up Wordpress head for speed
    added  <?php get_custom_field('image', TRUE); ?> functionality to shortcode.php
    updated shortcode.php page, cleaned up and added version date
    changed $ shortcuts to jQuery on builtin jcycle on front-page.php
    Moved sidebar-footer.php to footer.php
    Moved analytics.php to root directory to allow WP-Admin editing, edited include function in cleanhead.php
    Included jQuery Migrate v1.1.1 in the jquery.min.js for compatibility (Untested)
    Moved README.txt back to 'inc' since it doesn't need to be in the root.
    Commented out searchbar in 404.php
    Cleaned up and moved the loop from standard templates
    deleted loop.php - finally...
    Merged theme_options.php & custom_editor.php into clientcms.php
    included clientcms.php & shortcodes by default
    Organized data on theme options menu, cleaned up styling.
    Removed extra commenting on functions.php
    removed references to twentyten in register_sidebar.php
    Added dates to all core php files
    Added standard styles to style.css
    Created core.php, moved some of the items from twtyten.php over, deleted the rest, and deleted twtyten.php too.
    Moved Clean head junk back into head or in extrafunc.php, deleted cleanhead.php
    renamed core.php to extrafunc.php because they're arguable not... 'core'
    Added Jquery Enqueue to Header.php, removed from core functions
    Remove d4_copyright() from footer, it's really not that hard of a thing to add later if needed.
	added inc/register_widget.php & inc/register_posttype.php
    Updated css to include author and author uri
    Removed enqueue styles & enqueue to custom.js
    Added custom.js include to the bottom of footer.php
    added functions.css, style.css to header. No automation or behind the scenes crap.
    Renamed extrafunc.php back (again) to 'core.php'... because now it is essentially standard wordpress theme crap
    Renamed function.css to func.css, changed in header.php
    Added default list-styles to ul li
    Renamed ClientCMS theme options to website options.
    Added .sub-menu to second and third tier nav style.css
    Removed Custom.js (since it's not registered, it's an extra file for no reason.), removed call from footer.php too.
    

// 13Mar13 - Based on ideas from Starkers 4.0
	Added and Enqueued custom.js.
	Enqueued Functions.css & Style.css
	Created dynamic version number for Stylesheet, custom.js, and Favicon. This can easily be used to force refresh cache, especially with that pesky favicon.
	Renamed README.md to README.txt, since wth is .md & I guess Git will pick it up regardless.
	Converted footer copyright date from Javascript to PHP
	Added id="post-<?php the_ID(); ?>" to body
	Moved twentyten_filter_wp_title() to Cleanhead.php from twtyten.php
	Created menu_register.php with primary nav registeration. 
	Add default styling to body tag

// 6Mar13 - Github addition
	Uploaded current state to github
	moved and renamed inc/doc.txt to README.txt

// 25Feb13 - Minor Update
	sidebar_register.php
		changed "Foot" to "Footer"
		Added Change Date
		Removed unneeded comments

// 21Feb13 - Minor update
	Updated logo path for db-error.php to point to D4BaseTheme's logo
	Converted #footer-copyright to .footer-copyright
	Added .footer-copyright & .footer-copyright to new Footer heading in style.css
	Added new 'FOOTER' heading in style.css
  
// 06Feb13 - Initial Setup of D4BaseTheme 2013 //
	Clean up all twenty-ten commenting, reduce 'inc' folder
	renamed 'wp-clean-head.php
	Included inc/twtyten.php as original Twenty-ten functions.
	Included and registered local jquery library 1.9.1.min in cleanhead.php
	Included inc/cleanhead.php // Stylesheet, Jquery Register, Favicon, and meta data, includes Analytics file footer hook & Custom Log in logo
	replaced D4 favicon with blank favicon.ico
	Moved CSS '.clear' to inc/functions.css
 
