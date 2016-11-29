<?php
/**
 * [erp_hr_employee_single_tab_permission description]
 *
 * @return void
 */
//EMPLOYEE DETAILS
function ihvdelegated($n){

        $empuserid = $_SESSION['empuserid'];
	$curdate=date('Y-m-d');
        global $wpdb;
        
	if($n==1){
            
		$seldeleg=$wpdb->get_results("SELECT * FROM delegate WHERE DLG_FromEmpid='$empuserid' AND DLG_ToDate > '$curdate' AND DLG_Status=1 AND DLG_Active=1");
	
	} else if($n==2) {
			
		$seldeleg=$wpdb->get_results("SELECT * FROM delegate delg, employees emp WHERE delg.DLG_ToEmpid='$empuserid' AND delg.DLG_FromEmpid = emp.EMP_Id AND DLG_ToDate > '$curdate' AND DLG_Status=1 AND DLG_Active=1");
	}
	return $seldeleg;
	
}
//EMPLOYEE DETAILS

function isApprover()
{
    
    global $wpdb;
    $empuserid = $_SESSION['empuserid'];
    $compid = $_SESSION['compid'];
	
	$mydetails	= myDetails();
        //print_r( $mydetails);die;
        $rcode=$mydetails->EMP_Code;
       // print_r($rcode);die;
	$selrow=$wpdb->get_results("SELECT * FROM employees WHERE EMP_Reprtnmngrcode='$rcode' AND EMP_Status=1");
        //print_r( $selrow);die;
	return $selrow;

}

function myDetails($empid=NULL)
{
    global $wpdb;
    $empuserid = $_SESSION['empuserid'];
    $compid = $_SESSION['compid'];
	
	if(!$empid)
	$empid=$empuserid;
	
	$mydetails=$wpdb->get_row("SELECT * FROM employees WHERE EMP_Id='$empid' AND COM_Id='$compid' AND EMP_Status=1");
	
	return $mydetails;
}

//INDIAN MONEY FORMAT

function IND_money_format($money){
    $len = strlen($money);
    $m = '';
    $money = strrev($money);
    for($i=0;$i<$len;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
            $m .=',';
        }
        $m .=$money[$i];
    }
    return strrev($m);
}

function gradeLimits(){
    
        global $wpdb;
        $mydetails = myDetails();
        if($selgrdLim=$wpdb->get_row("SELECT * FROM grade_limits WHERE EG_Id='$mydetails->EG_Id' AND GL_Status=1")){
			$selgrdLim = json_decode(json_encode($selgrdLim), True);
			//print_r($selgrdLim);
			$selgrdLim=array_values($selgrdLim);
			//print_r($selgrdLim);

		
			echo '<table id="expenseLimitId" class="wp-list-table widefat fixed striped admins">';
			echo '<tr>';


				echo '<h4>Expense limits:</h4>';

				 
				$i=0;

				$selmod=$wpdb->get_results("SELECT MOD_Name FROM mode WHERE COM_Id = 0");

				$i = $gradelimitm = $totalLimitAmnt = 0;

				foreach($selmod as $rowmod){

						$k=$i+4;

						if($selgrdLim[$k]){

			
				  echo '<td>';
					  echo $rowmod->MOD_Name . "Expense Limit - <span class='oval-1'>";
					  echo $selgrdLim[$k] ? IND_money_format($selgrdLim[$k]).".00" : "No Limit</span>";
					 
							$gradelimitm++;
							$totalLimitAmnt += $selgrdLim[$k]; 

						}	

						if($gradelimitm%3==0)
						echo '<tr>';

						$i++; 	
				} 
					
						echo '</td>';

				
				if($totalLimitAmnt < 1) echo '<script>document.getElementById("expenseLimitId").style.display = "none";</script>';
		}
        
}
function tdclaimapprovals($string){
	global $getapprov; 
switch($string)
{
	
	case 1:
	$getapprov='<span class="status-1">Pending</span>';
	break;
	
	case 2:
	$getapprov='<span class="status-2">Approved</span>';
	break;
	
	case 3:
	$getapprov='<span class="status-4">Rejected</span>';
	break;
	
	case 4:
	$getapprov='<span class="status-3">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
	break;

}

return $getapprov;
}

function approvals($string){
	global $getapprov;
	switch($string)
	{
		case 1:
		$getapprov='<span class="status-1">Pending</span>';
		break;

		case 2:
		$getapprov='<span class="status-2">Settled</span>';
		break;
		
		case 5:
		$getapprov='<span class="status-3">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
		break;
			
		case 4:
		$getapprov='<span class="status-4">Rejected</span>';
		break;
			
		case 9:
		$getapprov='<span class="status-4">Rejected</span>';
		break;
	}

	return $getapprov;


}

/*////////////////////////////////////
		 GENERATE REQUEST IDS 
///////////////////////////////////*/

function genExpreqcode($n, $f=false){
        global $wpdb;
	$compid = $_SESSION['compid'];
	
	switch ($n){
		
		case 1:
		$tnetype="PRE";
		break;
		
		case 2:
		$tnetype="POS";
		break;
		
		case 3:
		$tnetype="GEN";
		break;
		
		case 4:
		$tnetype="TRA";
		break;
		
		case 5:
		$tnetype="MIL";
		break;
		
		case 6:
		$tnetype="UTL";
		break;		
	
	}
	
	if($f)
	$tnetype="F".$tnetype;
	

	$m=date('m');
	$y=date('y');
	
	$code=$wpdb->get_row("SELECT * FROM CODE");
	
	
	if($tnetype)	
	$requestcode=$tnetype.$compid.$m.$y.$code->code;
	else
	$requestcode=$compid.$m.$y.$code->code;
	$wpdb->query("UPDATE code SET code=$code->code+1");
	return $requestcode;

}

/////////////////////////////////////////////
//          Grade Limit amount 
/////////////////////////////////////////////

function getGradeLimit($modeid, $empuserid, $filename)
{
        $empuserid = $_SESSION['empuserid'];                
	if($selgrmlimit=$wpdb->get_row("SELECT gl.* FROM employees emp, grade_limits gl WHERE emp.EMP_Id='$empuserid' AND emp.EG_Id=gl.EG_Id AND gl.GL_Status=1 ORDER BY gl.GL_Id ASC"))
	{
			
		$selgrdLim=array_values($selgrmlimit);
		
		if($modeid)
		{
                        
			$selall=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE COM_Id = 0 and MOD_Status=1 ORDER BY MOD_Id ASC");
			
			$i=0;
		
			foreach($selall as $row):
			
				$k=$i+4;
				
				if ($modeid==$row['MOD_Id']){
					$mode=$row['MOD_Name'];
					$ModLimitVal=$selgrdLim[$k] ? $selgrdLim[$k] : 0;
				}
			
			
			endforeach;
			
		}
		
	}
	
	$returnval=$ModLimitVal."###".$mode;
		
		return $returnval;

}
function workflow(){
    global $wpdb;
    $compid = $_SESSION['compid'];
    $workflow = $wpdb->get_row("SELECT COM_Pretrv_POL_Id, COM_Posttrv_POL_Id, COM_Othertrv_POL_Id, COM_Mileage_POL_Id, COM_Utility_POL_Id FROM company WHERE COM_Id='$compid'");
    return $workflow;
}
function requestDetails($et){
    global $wpdb;
    $reqid  =   $_GET['reqid'];
    $compid = $_SESSION['compid'];
    $row = $wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");
    echo '<table class="wp-list-table widefat striped admins">';
    echo '<tr>';
    echo '<td width="20%">Request Id</td>';
    echo '<td width="5%">:</td>';
    echo '<td width="25%">'.$row->REQ_Code.'</td>';
   
    $repmngr_block='<td width="20%">Reporting Manager Approval</td>
					<td width="5%">:</td>
					<td width="25%">';
					
					
					
    $fin_block='<td width="20%">Finance Approval</td>
                            <td width="5%">:</td>
                            <td width="25%">';			

    $second_level_block='<td width="20%">Skip Level Manager Approval</td>
                            <td width="5%">:</td>
                            <td width="25%">';

    $null_block='<td width="20%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>';


    if($row->REQ_Type==2 || $row->REQ_Type==4){

            echo $null_block;

    }
    else {

            $secMngrRow=0;
                                
            if($selsecStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=5 AND RS_Status=1"))
            {
                    $secMngrRow=1;

                    $approvals=approvals($selsecStatus->REQ_Status);

                    $second_level_block .=$approvals;

                    $rsdate=" on ".date('d-M, y',strtotime($selsecStatus->RS_Date));

                    $second_level_block.=$rsdate;
            }
            else
            {
                    $approvals=approvals(1);

                    $second_level_block.=$approvals;
            }


            $second_level_block.='</td>';

            $repMngrRow=0;
                                
            if($selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1"))
            {

                    $repMngrRow=1;

                    $approvals=approvals($selMngrStatus->REQ_Status);

                    $repmngr_block.=$approvals;

                    $rsdate=" on ".date('d-M, y',strtotime($selMngrStatus->RS_Date));

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
                            
            if($selFinance=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=2  AND RS_Status=1"))
            {
                    $finRow=1;

                    $approvals=approvals($selFinance->REQ_Status);

                    $fin_block.=$approvals;

                    $rsdate=" on ".date('d-M, y',strtotime($selFinance->RS_Date));

                    $fin_block.=$rsdate;

            }
            else
            {
                    $approvals=approvals(1);

                    $fin_block.=$approvals;
            }


            $fin_block.='</td>';



            $workflow = workflow();
            switch ($et)
            {
                    case 1:
                    $expPol=$workflow->COM_Pretrv_POL_Id;
                    break;

                    case 2:
                    $expPol=$workflow->COM_Posttrv_POL_Id;
                    break;

                    case 3:
                    $expPol=$workflow->COM_Othertrv_POL_Id;
                    break;

                    case 5:
                    $expPol=$workflow->COM_Mileage_POL_Id;
                    break;

                    case 6:
                    $expPol=$workflow->COM_Utility_POL_Id;
                    break;
            }


            $polId = "";		
            switch ($expPol){

                    // e --> r --> f  //e --> r 
                    case 1 : case 3:
                    if($row->POL_Id==5 || $row->POL_Id==6){
                    echo $second_level_block;
                    $polId = $row->POL_Id;
                    }
                    else{
                    echo $repmngr_block;
                    }
                    break;
                    //e --> f
                    case 2:
                    echo $fin_block;
                    break;
                    // e--> f --> r    
                    case 4:
                    if($row->POL_Id==5){
                    echo $second_level_block;
                    $polId = $row->POL_Id;
                    }
                    else{
                    echo $fin_block;
                    break;
                    }

            }


    }
    
    
  echo '</tr>';
  /*------SECOND ROW ------*/
  echo '<tr>';
     echo  '<td width="20%">Request Date</td>';
     echo '<td width="5%">:</td>';
     echo '<td width="25%">'.date("d-M-y (h:i a)",strtotime($row->REQ_Date)).'</td>';
     
     $repmngr_block='<td width="20%">Reporting Manager Approval</td>
                    <td width="5%">:</td>
                    <td width="25%">';
		
		
    $fin_block='<td width="20%">Finance Approval</td>
                <td width="5%">:</td>
                <td width="25%">';

    $fin_block_second='<td width="20%">Finance Approval</td>
                        <td width="5%">:</td>
                        <td width="25%">';

    $second_level_block_second='<td width="20%">2nd Level Manager Approval</td>
                                <td width="5%">:</td>
                                <td width="25%">';


    if($row->REQ_Type==2 || $row->REQ_Type==4){

            echo $null_block;

    } else {

            if($finRow && $selFinance->REQ_Status==2)
            {

                    if($repMngrRow)
                    {

                            $approvals=approvals($selMngrStatus->REQ_Status);

                            $repmngr_block.=$approvals;


                            $rsdate=" on ".date('d-M, y',strtotime($selMngrStatus->RS_Date));

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
                            
            $secMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=5 AND RS_Status=1");
            if($finRow && $selFinance->REQ_Status==2)
            {

                    if($secMngrRow)
                    {

                            $approvals=approvals($secMngrStatus->REQ_Status);

                            $second_level_block_second.=$approvals;


                            $rsdate=" on ".date('d-M, y',strtotime($secMngrStatus->RS_Date));

                            $second_level_block_second.=$rsdate;

                    }
                    else
                    {


                            $approvals=approvals(1);

                            $second_level_block_second.=$approvals;
                    }
            }
            else
            {

                    $approvals=approvals(5);

                    $second_level_block_second.=$approvals;
            }


            $second_level_block_second.='</td>';			

            if($repMngrRow && $selMngrStatus->REQ_Status==2)
            {
                    if($finRow)
                    {
                            $approvals=approvals($selFinance->REQ_Status);

                            $fin_block.=$approvals;

                            $rsdate=" on ".date('d-M, y',strtotime($selFinance->RS_Date));

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

                            
            $secMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=5 AND RS_Status=1");

            if($secMngrRow && $secMngrStatus->REQ_Status==2)
            {
                    if($finRow)
                    {
                            $approvals=approvals($selFinance->REQ_Status);

                            $fin_block_second.=$approvals;

                            $rsdate=" on ".date('d-M, y',strtotime($selFinance->RS_Date));

                            $fin_block_second.=$rsdate;

                    }
                    else
                    {
                            $approvals=approvals(1);

                            $fin_block_second.=$approvals;
                    }
            }
            else
            {
                    switch ($expPol){
                        case 1:
                            $approvals=approvals(1);
                    }
                    //$approvals=approvals(5);

                    $fin_block_second.=$approvals;
            }

            $fin_block_second.='</td>';

            switch ($expPol){

                    // e --> r --> f
                    case 1:
                    if($row->POL_Id==5){
                    echo $fin_block_second;
                    }
                    else{
                    echo $fin_block;
                    }
                    break;

                    // e --> f --> r
                    case 2:
                    if($row->POL_Id==5){
                    echo $second_level_block_second;
                    $polId = $row->POL_Id;
                    }
                    else{
                    echo $repmngr_block;
                    }
                    break;

                    // e --> r   
                    case 3: 
                    echo $null_block;
                    break;

                    // e --> f
                    case 4:
                    if($row->POL_Id==5){
                    echo $fin_block_second;
                    }
                    else{
                    echo $null_block;
                    }
                    break;

            }

    }
     
  echo '</tr>';
echo '</table>';
}

