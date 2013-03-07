<?php
  global $wpdb;  
  $activity = $_GET['edit'];
  $button_label = "Add Testimonial";
  $header_label = "Add Testimonial";
  
  //first we check for form submission and that this is a new submission
  if ($activity != 1) {
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$testimonial = $_POST['testimonial-body'];
	$test_name = $_POST['testimonial-name'];
	
	$insqry = $wpdb->prepare("INSERT INTO ". $wpdb->prefix . "testimonials (testimonial, testimonial_name) 
			  		                 VALUES (%s, %s)", $testimonial, $test_name);
	$wpdb->query($insqry);
	
	if ($insqry) {
	  echo "<div id=\"success\">Testimonial has been added</div>\n";	
	}
	
	  $testimonial = "";
      $testimonial_name = "";
  }
  }
  
  //We've edited and submitted an existing testimonial now to update the database
  if ($activity == 1) {
	 if($_SERVER['REQUEST_METHOD'] == 'POST') {
	    $testimonial = $_POST['testimonial-body'];
		$test_name = $_POST['testimonial-name'];
		$test_id = $_POST['test_id'];
		
		$updqry = $wpdb->prepare("UPDATE ". $wpdb->prefix . "testimonials SET testimonial = %s, testimonial_name = %s WHERE testimonial_id = %d", $testimonial, $test_name, $test_id);
		$wpdb->query($updqry);
		
		if ($updqry) {
		  echo "<div id=\"success\">Testimonial has been updated</div>\n";	
		} 	 
	 }
  }
  
    //Edit an existing testimonial
  if ($activity == 1) {
	$test = $_GET['test'];
	$button_label = "Edit Testimonial";
    $header_label = "Edit Testimonial";
	
	$testimonial_list=$wpdb->get_results("SELECT * FROM ". $wpdb->prefix . "testimonials WHERE testimonial_id =". $test);
    $test_count = $wpdb->get_var("SELECT COUNT(*) FROM ". $wpdb->prefix . "testimonials WHERE testimonial_id =" .$test);

	  if ($test_count >= 1) {
		  foreach ($testimonial_list as $vals) {
			$testimonial = stripslashes($vals->testimonial);
			$testimonial_name = stripslashes( $vals->testimonial_name);
			$test_id = $vals->testimonial_id;
		  }
	  } else {
		$theList = "There was an error selecting the testimonial from the list.\n";  
	  }	  
  }  
  

 
?>
<style type="text/css">
  table, td, th {
	margin: 10px;
	padding: 10px;  
  }
  
  th,td {
	vertical-align: top;  
  }
</style>
<div class="wrap">
  <h2><?php echo $header_label;?></h2>
  <hr/>
  <form id="add-testimonial-form" name="add-testimonial-form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
  <?php echo "<h3>$theList</h3>"; ?>
  <table>
    <tr>
      <th>Testimonial</th>
      <td><textarea id="testimonial-body" name="testimonial-body" rows="8" cols="100"><?php echo $testimonial; ?></textarea><br/>
        <span style="font-style: italic; font-size: .90em; color#666;">Enter the testimonial text.</span>
      </td>
    </tr>
    <tr>
      <th>Customer Name</th>
      <td><input type="text" id="testimonial-name" name="testimonial-name" style="width: 200px;" value="<?php echo $testimonial_name; ?>"/><br/>
        <span style="font-style: italic; font-size: .90em; color#666;">Enter the name of the customer who gave the testimonial.</span>
      </td>
    </tr>
  </table>
    <?php if ($activity == 1) {	?>  
    <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id; ?>"/>
	<?php  } ?>
   <input type="submit" id="button-submit" name="button-submit" value="<?php echo $button_label;?>" />
  </form>
</div>