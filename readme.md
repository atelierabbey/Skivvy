Less is More.
Consistent Structure
Built in plugins over wp-plugins
Only one deep rabbit holing
Clear and ordered function files
Less automation and queries
Fully flexible
Minimilist core


# Website options and Socialbox usage


The Socialbox includes a large amount of common social media sites to start, to add more, add to the following array.
```php
$list_o_social = array( 'RSS', 'Etsy', 'Facebook', 'Flickr', 'Google Plus', 'Instagram', 'LinkedIn', 'Pinterest', 'Twitter', 'Vimeo', 'Youtube');
```


This item displays all social icon .pngs that are checked in the website options and has filled content. It fills in teh order above.
```
[socialbox]
```

Outputting a specified order can be done via the key. This Method also ignores the "Add to Socialbox" Checkmark AND whether or not the stored value is empty.

The key is neither case sensitive, nor white-space intolerant. 
```
[socialbox key="Facebook,FacEBook,    pinterest,Phone 1, email1, Phone2"]
```

### Styles

Socialbox has the following styles: link, text, png, &amp; svg

##### TEXT

The text style outputs simple text only. It produces various results for different contact types, but will pretty much just return the result of what was saved.

- Phone/Fax/Address will produce a custom/delimited/standard form (in that order of importance).
- Email will produce the saved email address
- Social media will produce the saved URL

````
[socialbox style="text"]
````

##### LINK

Link has some of the same rules as text. Except will wrap the results in a clickable format. 
- Phone: 'tel:' formatted href
- Fax: 'fax:' formatted href
- Email: 'mailto:' formatted href
- Address: a link to a query on Google Maps
- Social Media: Links to social media, but unlike text, it outputs the name of the Social Media rather than the URL.

````
[socialbox style="text"]
````

##### PNG
.png files are the default output style for socialbox. 

Both these options will produce identical results
````
[socialbox]
   // or
[socialbox style="png"]
````

##### SVG

SVGs have huge advantages over regular raster image files. one being that it can scale to just about any size. secondly, you can update the coloring with CSS (Which means it can animate or be changed by javascript during events, or even a simple hover effect.)

For older browsers that don't understand SVGs, the socialbox has a fallback to the .png of the same name.

````
[socialbox style="svg"]
````

### Delimiters

Delimiters are possible for Phone/fax numbers and addresses. This only works with the text and link styles

This produces a comma seperated address in text.
````
[socialbox key="addr1" delimiter=", " style="text"]
````

Also hyphen seperated phone numbers like this 1-222-333-4444
````
[socialbox key=”phone1″ delimiter=”-” style=”text”]
````

### Custom Layouts
Custom layout offers a way to optimize format of most non-standard ouputs. Custom output works with both text &amp; link styles, as well as Addresses, Phone and Fax numbers. If the custom layout element is filled out, it will ignore delimiters.

The mindset for working with the custom attribute is breaking each section of an input into sections. In the case of an address, think of Street, city, st, zip, and country as $a, $b, $c, $d, and $e, repectively. For phone or fax numbers, each group of digits: 1-222-333-4444 would be $a-$b-$c-$d.

Note: Custom will ignore delimiters and will also show up in the link title (tooltip) as it's formatted
````
    // Produces: "1 , {222} 333 ++4444" from 1-222-333-4444
[socialbox key="phone1" delimiter="-" custom="$a , {$b} $c ++$d" style="text"]

    // This also works fine. Just be aware of mixing up Address, Fax, & Phone numbers.
[socialbox key="phone1,phone2" custom="+$a {$b} $c $d" style="link"]
````



### CSS Class

Socialbox can also add additional css class styles simply. The example below will add "whatever" to the socialbox container ul element
````
[socialbox class="whatever"]
````

### Notes

Social box has a hierachy of what to listent to in the attributes. Left to right below is the order in which output is calculated: style > custom > delimiter


----

# Home Meta Buckets


BOTH LINK AND IMAGE output a URL, not the code to make an image or link.

````
[homemeta key="Bucket 1" output="title"]
[homemeta key="Bucket 1" output="image"]
[homemeta key="Bucket 1" output="link"]
[homemeta key="Bucket 1" output="content"]
````

or

````php
  echo get_post_meta( get_option( 'page_on_front' ) , "_home_meta_bucket-1_title" , TRUE);
  echo get_post_meta( get_option( 'page_on_front' ) , "_home_meta_bucket-1_image" , TRUE);
  echo get_post_meta( get_option( 'page_on_front' ) , "_home_meta_bucket-1_link" , TRUE);
  echo get_post_meta( get_option( 'page_on_front' ) , "_home_meta_bucket-1_content" , TRUE);
````

