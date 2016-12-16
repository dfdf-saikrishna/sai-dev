<?php 
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$et = 1;
$row = $wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Id='$reqid' AND RT_Id IN (1,2) AND REQ_Active != 9");

$showProCode = 1;
$finance=0;
if(!$finance){
?>

<div class="postbox">
    <div class="inside">
  <?php 
			  $empdetails=$wpdb->get_results("SELECT * FROM employees emp, company com, department dep, designation des, requests req, request_employee re, employee_grades eg WHERE req.REQ_Id='$reqid'  AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id  AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND req.REQ_Active=1 AND re.RE_Status=1");
			 //print_r($empdetails);die;
                          ?>
  <table class="wp-list-table widefat striped admins">
    <tr>
      <td width="20%">Employee Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails[0]->EMP_Code; ?> (<?php echo $empdetails[0]->EG_Name; ?>)</td>
      <td width="20%">Company Name</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo stripslashes($empdetails[0]->COM_Name); ?></td>
    </tr>
    <tr>
      <td width="20%">Employee Name</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails[0]->EMP_Name; ?></td>
      <td width="20%">Reporting Manager Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails[0]->EMP_Reprtnmngrcode; ?></td>
    </tr>
    <tr>
      <td>Employee Designation </td>
      <td>:</td>
      <td><?php echo $empdetails[0]->DES_Name; ?></td>
      <td>Reporting Manager Name</td>
      <td>:</td> 
         
      <?php 
      $code=$empdetails[0]->EMP_Reprtnmngrcode;
					$repmngname=$wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code' AND COM_Id='$compid'");
                                    // Print_r($repmngname);DIE;
					?>
      <?php if($repmngname){ ?>
      <td><?php echo $repmngname[0]->EMP_Name;?></td>
      </tr><?php } ?>
    <tr>
      <td width="20%">Employee Department</td>
      <td width="5%">:</td>
      <td width="25%"><?php echo $empdetails[0]->DEP_Name; ?></td>
  
      <?PHP 
	  
	  $q=NULL;
	  
	  if(!$showProCode){
	  	$pc=" AND PC_Status IN (1)";
		$cc=" AND CC_Status IN (1)";
	  }else{
            $pc="";
            $cc="";  
          }
	  $selexpcat=$wpdb->get_results("SELECT * FROM project_code WHERE COM_Id='$compid' AND PC_Active=1 $pc");
          
	  if(count($selexpcat) && $showProCode){
							
					?>
      <td width="20%" style="color:#C66300;">Project Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php 
	  
	  if($row[0]->PC_Id){
	  
		  if($rowpcname=$wpdb->get_results("SELECT PC_Code,PC_Name  FROM project_code WHERE COM_Id='$compid' AND PC_Id=$row->PC_Id AND PC_Active=1")){
		  
			 echo $rowpcname->PC_Code.' -- '.$rowpcname->PC_Name;
		  
		  } 
		  
	  }  
	  ?></td>
       
      <?php }  else { ?>
      <td width="20%" style="color:#C66300;">Project Code</td>
      <td width="5%">:</td>
      <td colspan="3">&nbsp;
	  	<?php echo 'None'; ?>
	  
      </td>
      <?php } ?>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <?PHP 
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM cost_center WHERE COM_Id='$compid' AND CC_Active=1 $cc");
	  
	  if(count($selexpcat) && $showProCode){
									
		?>
      <td width="20%" style="color:#C66300;">Cost Center</td>
      <td width="5%">:</td>
      <td width="25%"><?php 
	  if($row[0]->CC_Id){
	  
		  if($rowpcname=$wpdb->get_results("SELECT CC_Code,CC_Name FROM cost_center WHERE COM_Id='$compid' AND CC_Id=$row[CC_Id] AND CC_Active=1")){
		  
			 echo $rowpcname->CC_Code.' -- '.$rowpcname->CC_Name;
		  
		  
		  } 
		  
	  }  
	  ?></td>
       
      <?php }  else { ?>
      <td width="20%" style="color:#C66300;">Cost Center</td>
      <td width="5%">:</td>
      <td colspan="3">&nbsp;
      <?php echo 'None'; ?></td>
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
	  }else{
            $pc="";
            $cc="";  
          }
          
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM project_code WHERE COM_Id='$compid' AND PC_Active=1 $pc");
	  
	  if(count($selexpcat) && $showProCode){
	
	?>
  <div class="col-lg-6">
   Project Code: 
      
      <b>  <?php 
	  
	  if($row->PC_Id){
	  
		  if($rowpcname=$wpdb->get_results("SELECT PC_Code,PC_Name FROM project_code COM_Id='$compid' AND PC_Id=$row->PC_Id AND PC_Active=1")){
		  
			 echo $rowpcname->PC_Code.' -- '.$rowpcname->PC_Name;
		  
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
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM cost_center WHERE COM_Id='$compid' AND CC_Active=1 $cc");
	  
	  if(count($selexpcat) && $showProCode){
							
	?>
  <div class="col-lg-6">
  Cost Center:
  <b>
        <?php 
	  if($row->CC_Id){
	  
		  if($rowpcname=$wpdb->get_results("SELECT CC_Code, CC_Name  FROMcost_center WHERE COM_Id='$compid' AND CC_Id=$row[CC_Id] AND CC_Active=1")){
		  
			 echo $rowpcname->CC_Code.' -- '.$rowpcname->CC_Name;
		  
		  
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