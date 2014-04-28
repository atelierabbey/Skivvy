Less is More.
Consistent Structure
Built in plugins over wp-plugins
Only one deep rabbit holing
Clear and ordered function files
Less automation and queries
Fully flexible
Minimilist core

----

## SHORTCODES

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
