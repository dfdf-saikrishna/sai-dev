<?php 
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$et = 1;
$showProCode = 1;
$row = $wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Id='$reqid' AND RT_Id IN (1,2) AND REQ_Active != 9");
$workflow = $wpdb->get_results("SELECT COM_Pretrv_POL_Id, COM_Posttrv_POL_Id, COM_Othertrv_POL_Id, COM_Mileage_POL_Id, COM_Utility_POL_Id FROM company WHERE COM_Id='$compid'");

?>
<div style="margin-top:30px;">
  <table class="wp-list-table widefat striped admins">
    <tbody>
      <tr>
        <td width="20%">Request Id:</td>
        <td width="5%">:</td>
        <td width="25%"><b><?php echo $row[0]->REQ_Code; ?></b></td>
        <?php 
		$repmngr_block='<td width="20%">Reporting Manager Approval</td>
					<td width="5%">:</td>
					<td width="25%">';
                
		$fin_block='<td width="20%">Finance Approval</td>
					<td width="5%">:</td>
					<td width="25%">';			
		
		$null_block='<td width="20%">&nbsp;</td>
					<td width="5%">&nbsp;</td>
					<td width="25%">&nbsp;</td>';
					
					
		if($row[0]->REQ_Type==2 || $row[0]->REQ_Type==4){
		
			echo $null_block;
		
		} else {
		
		
			$repMngrRow=0;
					
			if($selMngrStatus=$wpdb->get_results("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1"))
			{
				
				$repMngrRow=1;
				
				$approvals=approvals($selMngrStatus[0]->REQ_Status);
				
				$repmngr_block.=$approvals;
			
				$rsdate=" on ".date('d-M, y',strtotime($selMngrStatus[0]->RS_Date));
				
				$repmngr_block.=$rsdate;
			}
			else
			{
				$approvals=approvals(1);
				
				$repmngr_block.=$approvals;
			}
			
			
			$repmngr_block.='</td>';
		
		
		//echo 'RepManagerrow='.$repMngrRow;
			 
			 
			
			$finRow=0;
			
			if($selFinance=$wpdb->get_results("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=2 AND RS_Status=1"))
			{
				$finRow=1;
				
				$approvals=approvals($selFinance[0]->REQ_Status);
				
				$fin_block.=$approvals;
			
				$rsdate=" on ".date('d-M, y',strtotime($selFinance[0]->RS_Date));
				
				$fin_block.=$rsdate;
				
			}
			else
			{
				$approvals=approvals(1);
				
				$fin_block.=$approvals;
			}
			
			
			$fin_block.='</td>';

			switch ($et)
			{
				case 1:
				$expPol=$workflow[0]->COM_Pretrv_POL_Id;
				break;
				
				case 2:
				$expPol=$workflow[0]->COM_Posttrv_POL_Id;
				break;
				
				case 3:
				$expPol=$workflow[0]->COM_Othertrv_POL_Id;
				break;
				
				case 5:
				$expPol=$workflow[0]->COM_Mileage_POL_Id;
				break;
				
				case 6:
				$expPol=$workflow[0]->COM_Utility_POL_Id;
				break;
			}
					
			switch ($expPol){
				
				// e --> r --> f & e --> r 
				case 1 : case 3: 
				echo $repmngr_block;
				break;
				
				// e--> f --> r   & e --> f
				case 2: case 4:
				echo $fin_block;
				break;
			
			}
		
		
		}
					
					
					
		
		?>
      </tr>
      
      <!---- SECOND ROW ---->
      <tr>
        <td width="20%">Request Date:</td>
        <td width="5%">:</td>
        <td width="25%"><?php echo date('d-M-y (h:i a)',strtotime($row[0]->REQ_Date)); ?></td>
        <?php 	
		
		$repmngr_block='<td width="20%">Reporting Manager Approval</td>
					<td width="5%">:</td>
					<td width="25%">';
		
		
		$fin_block='<td width="20%">Finance Approval</td>
				<td width="5%">:</td>
				<td width="25%">';
					
		
		
					
		if($row[0]->REQ_Type==2 || $row[0]->REQ_Type==4){
		
			echo $null_block;
		
		} else {
		
			if($finRow && $selFinance[0]->REQ_Status==2)
			{
								
				if($repMngrRow)
				{
					
					$approvals=approvals($selMngrStatus[0]->REQ_Status);
					
					$repmngr_block.=$approvals;
					
				
					$rsdate=" on ".date('d-M, y',strtotime($selMngrStatus[0]->RS_Date));
							
					$repmngr_block.=$rsdate;
					
				}
				else
				{
				
					
					$approvals=approvals(1);
						
					$repmngr_block.=$approvals;
				}
			}
			else
			{
				
				$approvals=approvals(5);
						
				$repmngr_block.=$approvals;
			}
		
						 
			$repmngr_block.='</td>';
		
						
						
			if($repMngrRow && $selMngrStatus[0]->REQ_Status==2)
			{
				if($finRow)
				{
					$approvals=approvals($selFinance[0]->REQ_Status);
					
					$fin_block.=$approvals;
				
					$rsdate=" on ".date('d-M, y',strtotime($selFinance[0]->RS_Date));
							
					$fin_block.=$rsdate;
					
				}
				else
				{
					$approvals=approvals(1);
						
					$fin_block.=$approvals;
				}
			}
			else
			{
				$approvals=approvals(5);
						
				$fin_block.=$approvals;
			}
					
			$fin_block.='</td>';
			
					
			switch ($expPol){
				
				// e --> r --> f
				case 1:
				echo $fin_block;
				break;
				
				// e --> f --> r
				case 2:
				echo $repmngr_block;
				break;
				
				// e --> r   & e --> f
				case 3: case 4:
				echo $null_block;
				break;			
				
			
			}
		
		}	
		
		?>
      </tr>
    </tbody>
  </table>
  </div>  

<p style="border-bottom:thin dashed #000000;">&nbsp;</p>
