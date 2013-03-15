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
 
