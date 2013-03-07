<?php /*Function to get the top level category id  -  Put this first section in the functions.php file*/

function pa_category_top_parent_id ($catid) {
 while ($catid) {
  $cat = get_category($catid); // get the object for the catid
  $catid = $cat->category_parent; // assign parent ID (if exists) to $catid
  // the while loop will continue whilst there is a $catid
  // when there is no longer a parent $catid will be NULL so we can assign our $catParent
  $catParent = $cat->cat_ID;
 }
return $catParent;
}

?>


<?php /*Use this code to create a conditional based on the top level category ID*/
$catid = get_query_var('cat');
if (pa_category_top_parent_id ($catid) == 'CATEGORY_ID_HERE'):?>
SOME CODE
<? endif?>

<?php /*Use this code to echo the top level category ID*/
$catid = get_query_var('cat');
echo pa_category_top_parent_id ($catid);?>