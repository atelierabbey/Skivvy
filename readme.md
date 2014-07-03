The Skivvy Decree
- Less is More.
- Consistent Structure
- Reduce rabbit holing
- Clear and ordered function files
- Less automation and queries for straight echoes
- Fully flexible
- Minimilist core

----

## SHORTCODES

#### Skiv-Divs 
Use:
````
[$tag class="" style="" title="" func="" param="" echoes=""]
````
- $tag (required) - Division name. Accepted values = 'one_full', 'one_half', 'one_half_last','one_third', 'one_third_last', 'two_third', 'two_third_last', 'one_fourth', 'one_fourth_last', 'three_fourth', 'three_fourth_last'
- class - Passes into the container div's classes. Any CSS class(es). Space seperate.
- style - Add as normal in the " style='' " attribute. any inline CSS.
- title - Renders either H2 (one full) or H3 (on all else) just before the "div.skivdiv-content" & addes a sanitized CSS class to the overall wrapper
	// Function attributes - Deals with turning the SkivDiv into a functional area.
- func - name of function to be called, works with $param. i.e. $func($param);
- param - Comma seperated string in order of parameters. CANNOT PASS AN ARRAY! 
- echoes - If the function echoes content, $echoes should equal '1', else default = '0'. Shortcodes must return a value.

#### Raw
This is not technically a shortcode, it utilizes filters on all content pages. It removes the wp_texturizer and wp_autop for use with code.
````
[raw]Non-formatted by Wordpress[/raw]
````

##### Lorem ipsum - in inc/lib/skivvy_toolbox.php
````
[lorem words="75"]
````

##### Bloginfo - equivalent to the bloginfo function of WordPress - in inc/lib/skivvy_toolbox.php
````
[bloginfo key="name"]
````


----

## FUNCTIONS

##### the_snippet($length=55,$readmore='Read More')
   Usable alternate to the "the_excerpt()"
````php
<?php the_snippet($length=55,$readmore='Read More'); ?>
````


#### get_the_thumbnail_caption()
   Returns the caption for attached featured image featured image
````php
<?php echo get_the_thumbnail_caption(); ?>
````