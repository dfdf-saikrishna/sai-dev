<?php
//require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];

$empuserid = $_SESSION['empuserid'];//echo $empuserid;die;
$reqid = $_GET['reqid'];
if(!$finance){
?>

<div class="table-responsive">
  <?php 
			  $empdetails=$wpdb->get_results("SELECT * FROMemployees emp, company com, department dep, designation des, requests req, request_employee re, employee_grades eg","*","req.REQ_Id='$reqid'  AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id  AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND req.REQ_Active=1 AND re.RE_Status=1");
			  ?>
  <table class="table table-hover">
    <tr>
      <td width="20%">Employee Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails['EMP_Code']; ?> (<?php echo $empdetails['EG_Name']; ?>)</td>
      <td width="20%">Company Name</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo stripslashes($empdetails['COM_Name']); ?></td>
    </tr>
    <tr>
      <td width="20%">Employee Name</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails['EMP_Name']; ?></td>
      <td width="20%">Reporting Manager Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails['EMP_Reprtnmngrcode']; ?></td>
    </tr>
    <tr>
      <td>Employee Designation </td>
      <td>:</td>
      <td><?php echo $empdetails['DES_Name']; ?></td>
      <td>Reporting Manager Name</td>
      <td>:</td>
      <?php 
					$repmngname=$wpdb->get_results("SELECT * FROMemployees","EMP_Name","EMP_Code='$empdetails[EMP_Reprtnmngrcode]' AND COM_Id='$compid'",$filename);
					?>
      <td><?php echo $repmngname['EMP_Name'];?></td>
    </tr>
    <tr>
      <td width="20%">Employee Department</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails['DEP_Name']; ?></td>
      <?PHP 
	  
	  $q=NULL;
	  
	  if(!$showProCode){
	  	$pc=" AND PC_Status IN (1)";
		$cc=" AND CC_Status IN (1)";
	  }
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM project_code", "*", "COM_Id='$compid' AND PC_Active=1 $pc", $filename, 0);
	  
	  if(count($selexpcat) && $showProCode){
							
					?>
      <td width="20%" style="color:#C66300;">Project Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php 
	  
	  if($row['PC_Id']){
	  
		  if($rowpcname=$wpdb->get_results("SELECT * FROMproject_code", "PC_Code, PC_Name", "COM_Id='$compid' AND PC_Id=$row[PC_Id] AND PC_Active=1", $filename, 0)){
		  
			 echo $rowpcname['PC_Code'].' -- '.$rowpcname['PC_Name'];
		  
		  
		  } 
		  
	  }  else {
	  
	  	echo 'None';
	  
	  }
	  ?></td>
       
      <?php }  else { ?>
      <td colspan="3">&nbsp;</td>
      <?php } ?>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <?PHP 
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM cost_center", "*", "COM_Id='$compid' AND CC_Active=1 $cc");
	  
	  if(count($selexpcat) && $showProCode){
									
		?>
      <td width="20%" style="color:#C66300;">Cost Center</td>
      <td width="5%">:</td>
      <td width="25%"><?php 
	  if($row['CC_Id']){
	  
		  if($rowpcname=$wpdb->get_results("SELECT * FROM cost_center", "CC_Code, CC_Name", "COM_Id='$compid' AND CC_Id=$row[CC_Id] AND CC_Active=1")){
		  
			 echo $rowpcname['CC_Code'].' -- '.$rowpcname['CC_Name'];
		  
		  
		  } 
		  
	  }  else {
	  
	  	echo 'None';
	  
	  }
	  ?></td>
       
      <?php }  else { ?>
      <td colspan="3">&nbsp;</td>
      <?php } ?>
    </tr>
  </table>
</div>

<?php } else { ?>
<div class="row">
   
  <?php 
	
	 $q=NULL;
	  
	  if(!$showProCode){
	  	$pc=" AND PC_Status IN (1)";
		$cc=" AND CC_Status IN (1)";
	  }
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM project_code", "*", "COM_Id='$compid' AND PC_Active=1 $pc");
	  
	  if(count($selexpcat) && $showProCode){
	
	?>
  <div class="col-lg-6">
   Project Code: 
      
      <b>  <?php 
	  
	  if($row['PC_Id']){
	  
		  if($rowpcname=$wpdb->get_results("SELECT * FROMproject_code", "PC_Code, PC_Name", "COM_Id='$compid' AND PC_Id=$row[PC_Id] AND PC_Active=1")){
		  
			 echo $rowpcname['PC_Code'].' -- '.$rowpcname['PC_Name'];
		  
		  
		  } 
		  
	  }  else {
	  
	  	echo 'None';
	  
	  }
	  ?>
      </b>
      
  </div>
  
  <?php }  else { ?>
  <div class="col-lg-4">&nbsp;</div>
  <?php } ?>
  <?PHP 
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROMcost_center", "*", "COM_Id='$compid' AND CC_Active=1 $cc");
	  
	  if(count($selexpcat) && $showProCode){
							
	?>
  <div class="col-lg-6">
  Cost Center:
  <b>
        <?php 
	  if($row['CC_Id']){
	  
		  if($rowpcname=$wpdb->get_results("SELECT * FROMcost_center", "CC_Code, CC_Name", "COM_Id='$compid' AND CC_Id=$row[CC_Id] AND CC_Active=1")){
		  
			 echo $rowpcname['CC_Code'].' -- '.$rowpcname['CC_Name'];
		  
		  
		  } 
	  }  else {
	  
	  	echo 'None';
	  
	  }
	  ?>
     </b>
  </div>
  
  <?php }  else { ?>
  <div class="col-lg-4">&nbsp;</div>
  <?php } ?>
</div>
<?php } ?>