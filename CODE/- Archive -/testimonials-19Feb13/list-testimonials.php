<?php
  global $wpdb;  
  
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
	 $sel_tests = $_POST['txtSelectedBoxes'];
	 
	 $ind_tests = explode(",", $sel_tests); 
	 
	 foreach($ind_tests as $vals) {
	    $delqry=$wpdb->prepare("DELETE FROM ". $wpdb->prefix . "testimonials WHERE testimonial_id = %s", $vals);
		$wpdb->query($delqry);
	 }
	 
	 echo "Testimonials have been deleted.";
  }
  
  $testimonial_list=$wpdb->get_results("SELECT substring(testimonial, 1,100) as testimonial, testimonial_name, testimonial_id FROM ". $wpdb->prefix . "testimonials ORDER BY testimonial_id");
  $test_count = $wpdb->get_var("SELECT COUNT(*) FROM ". $wpdb->prefix . "testimonials");

  if ($test_count >= 1) {
	  foreach ($testimonial_list as $vals) {
		$theList .= "<tr><td><a href=\"admin.php?page=new-testimonial&edit=1&test=".$vals->testimonial_id."\">".stripslashes($vals->testimonial)."...</a></td><td>".$vals->testimonial_name."</td><td><input type=\"checkbox\" id=\"del-item".$vals->testimonial_id."\" name=\"del-item\" value=\"".stripslashes($vals->testimonial_id)."\" onclick=\"createCheckedArray();\"/></td></tr>\n";  
	  }
  } else {
	$theList = "<tr><td colspan=\"3\">There are no testimonials in the list.</td></tr>\n";  
  }
  

  
?>
<style type="text/css">
  table, td, th {
	margin: 10px;
	padding: 10px;  
  }
  
  th,td {
	vertical-align: top;  
	text-align: left;
  }
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
 function CheckUncheckAllCheckBoxes(objID, checkedValue) {  
    if (objID == null || objID == undefined )  
    return;  
	
	$(objID + " input[type=checkbox]").each(function() {  
      this.checked = checkedValue;  
    });  
	
	  if (checkedValue == true) {
		createCheckedArray();
	  } else {
		document.getElementById("txtSelectedBoxes").value = "";  
	  }
 }
 
  function createCheckedArray() {
  var x = document.getElementsByTagName("input");
  var selectedVals = document.getElementById("txtSelectedBoxes");
  
  if (selectedVals.value != "") {
	selectedVals.value = "";  
  }
  
  for(var i = 0; i<x.length; i++) {
	if(x[i].type == "checkbox" && x[i].checked) {
	  if (isNaN(x[i].value) == false) {
		selectedVals.value += x[i].value+",";  
	  }
	}
  }
}

  
$(document).ready(function () {
  jQuery("#chkAll").click(function() {  
   CheckUncheckAllCheckBoxes("#tblTests", this.checked);  
  }); 
});
</script>
<div class="wrap">
  <h2>Testimonials</h2>
      <form id="frmActions" name="frmActions" action="<?php echo $PHP_SELF;?>" method="post">
        <input type="hidden" id="txtSelectedBoxes" name="txtSelectedBoxes"/>
        <input type="submit" id="btnSubmitActions" name="btnSubmitActions" value="Delete Checked"/>
    </form> 

  <hr/>
  <table id="tblTests">
    <tr><th>Testimonial</th><th>Testimonial Name</th><th>Delete<br/><input type="checkbox" id="chkAll" name="chkAll"/></th></tr>
    <?php echo $theList; ?>
  </table>
</div>