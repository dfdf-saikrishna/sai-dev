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
	$selrow=$wpdb->get_row("SELECT * FROM employees WHERE EMP_Reprtnmngrcode='$rcode' OR EMP_Funcrepmngrcode='$rcode' AND EMP_Status=1");
        //print_r( $selrow);die;
	return $selrow;

}

function myDetails($empid=NULL)
{
    global $wpdb;
    if(isset($_SESSION['empuserid']))
    $empuserid = $_SESSION['empuserid'];
    //echo $empuserid;die;
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

function gradeLimits($empuserid){
    
        global $wpdb;
        $mydetails = myDetails($empuserid);
        if($selgrdLim=$wpdb->get_row("SELECT * FROM grade_limits WHERE EG_Id='$mydetails->EG_Id' AND GL_Status=1")){
			$selgrdLim = json_decode(json_encode($selgrdLim), True);
			//print_r($selgrdLim);
			$selgrdLim=array_values($selgrdLim);
			//print_r($selgrdLim);

		
			echo '<table id="expenseLimitId" class="wp-list-table widefat fixed striped admins">';
			echo '<tr>';


				//echo '<h4>Expense limits:</h4>';

				 
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

/*//////////////////////////////////////////////////
               BOOKING STATUS        
///////////////////////////////////////////////////*/

function bookingStatus($status){

switch($status)
{
	case 1:
	$getapprov='<span class="status-1">Pending</span>';
	break;
	
	case 2:
	$getapprov='<span class="status-2">Booked</span>';
	break;
	
	case 3:
	$getapprov='<span class="status-4">Failed</span>';
	break;
	
	case 4:
	$getapprov='<span class="label label-info">Employee Request Cancelled <br>(Cancellation charges applicable)</span>';
	break;
	
	case 5:
	$getapprov='<span class="label label-info">Employee Request Cancelled <br>(No cancellation charges)</span>';
	break;
	
	case 6:
	$getapprov='<span class="label label-info">Travel Desk Cancelled <br>(Cancellation charges applicable)</span>';
	break;
	
	case 7:
	$getapprov='<span class="label label-info">Travel Desk Cancelled <br>(No Cancellation charges)</span>';
	break;
	
	case 8:
	$getapprov='<span class="label label-primary">Self Booking</span>';
	break;
	
	case 9:
	$getapprov='<span class="status-4">Cancelled</span>';
	break;
	
	
	default:
	$getapprov='<span class="status-3">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
	
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
                    switch ($expPol){
                        case 2:
                            $approvals=approvals(1);
                    }
                    //$approvals=approvals(5);

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
                    switch ($expPol){
                        case 2:
                            $approvals=approvals(1);
                    }
                    //$approvals=approvals(5);

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
                    switch ($expPol){
                        case 1:
                            $approvals=approvals(1);
                    }
                    //$approvals=approvals(5);

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
function Actions($et){
    global $wpdb;
    $reqid  =   $_GET['reqid'];
    $empuserid = $_SESSION['empuserid'];
    $compid = $_SESSION['compid'];
    $row = $wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");

    $actionButtons='<br />
        <div id="my_centered_buttons">
        <a href="" id="subApprove" class="button button-primary">Approve</a> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="reject" id="reject" class="button erp-button-danger">Reject</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="back" id="reset" onClick="window.history.back();" class="button">Back</button>
        </div>';
    $approver = isApprover();
    if($approver)
    {       
            $rowpol = $wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");
            $notmyreq=0;

            if($selreqs=$wpdb->get_row("SELECT EMP_Id FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND EMP_Id='$empuserid' AND req.REQ_Id='$reqid'")){

                    $notmyreq=1;

            }
            
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
            $mydetails = myDetails();
            $emp_code=$mydetails->EMP_Code;
            switch ($expPol)
            {
                    // employee --> rep manager --> finance
                    
                    case 1:
                            
                            //if its not my request
                            if(!$notmyreq)
                            {
                                if($rowpol->POL_Id=="5"){
                                    if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)) 
                                    {

                                        echo $actionButtons;

                                    }
                                }
                                //if its not my request and approval is waiting from rep manager

                                else if(!$selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1")) 
                                {
                                    if(!($row->EMP_Funcrepmngrcode == $emp_code))
                                        echo $actionButtons;

                                }

                            }

                    break;



                    // employee --> finance --> rep manager

                    case 2:


                    //if its not my request
                    if(!$notmyreq)
                    {

                            // check for finance approval
                             
                            if($selFinStat=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND REQ_Status=2 AND RS_EmpType=2 AND RS_Status=1")){
                                    if($rowpol->POL_Id=="5"){
                                        if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)){
                                            if(!$selsecstatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND REQ_Status=2 AND RS_EmpType=5 AND RS_Status=1"))
                                            echo $actionButtons; 
                                        }
                                    }
                                    //if its not my request and finance has apprvd & waiting for my approval

                                    else if(!$selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1")){

                                            echo $actionButtons;

                                    }

                            }



                    }

                    break;

                    // employee -- > approver
                    case 3:

                            //if its not my request
                            if(!$notmyreq)
                            {
                                    if($rowpol->POL_Id=="5" || $rowpol->POL_Id=="6"){
                                        if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)){
                                            if(!$selsecstatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND REQ_Status=2 AND RS_EmpType=5 AND RS_Status=1"))
                                            echo $actionButtons;

                                        }
                                    }
                                    //if its not my request and approval is waiting from rep manager
                                    else if(!$selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1")){
                                        if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)){}
                                        else{
                                            echo $actionButtons;
                                        }
                                    }

                            }

                    break;

                    // employee --> finance

                    case 4:

                            //if its not my request
                            if(!$notmyreq)
                            {
                                if($rowpol->POL_Id=="5"){
                                    if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)) 
                                    {
                                        if(!$selsecstatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND REQ_Status=2 AND RS_EmpType=5 AND RS_Status=1"))
                                        echo $actionButtons;

                                    }
                                }

                            }

                    break;

                    // Second Level Manager Request
                    case 5:

                            //if its not my request
                            if(!$notmyreq)
                            {
                                    //if its not my request and approval is waiting from rep manager
                                    if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)) 
                                    {

                                            echo $actionButtons;

                                    }

                            }

                    break;


            }


    }
    if($row->EMP_Id==$empuserid)
    {
            $editActbuttons='<br />
            <div id="my_centered_buttons">
                <a href="/wp-admin/admin.php?page=Pre-travel-edit&reqid='.$reqid.'" class="button button-primary">EDIT</a> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" name="reset" id="reset" class="button erp-button-danger">Delete</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" name="reset" id="reset" onClick="window.history.back();" class="button">Back</button>
            </div>';


            // checking if the any details in this request has gone for booking tickets, then disable the 

            $sel = $wpdb->get_row("SELECT DISTINCT(req.REQ_Id) AS totalRequests FROM requests req, request_details rd, booking_status bs WHERE COM_Id='$compid' AND req.REQ_Id='$reqid' AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 LIMIT 1");

            $cntSel	=	count($sel);

            if($cntSel){

                    $editActbuttons='<br />
                    <div class="row">
                    <div class="col-sm-3">
                    </div>
                      <div class="col-sm-3">
                      <div class="form-group">
                            <button name="buttnEdit" class="btn btn-theme" type="button" onclick="editTravelExpense('.$et.','.$reqid.');">EDIT</button>
                            </div>
                      </div>
                      <div class="col-sm-3">
                       <div class="form-group">
                            <button class="btn btn-info btn-transparent"  type="button" onClick="window.history.back();">BACK</button>
                            </div>
                      </div>
                    </div>';

            }


            // if approved 
            if($row->REQ_Status==2){

                    $edit=0;

            } else {

                    // if pending , if rejected
                    if($row->REQ_Status==1 ||$row->REQ_Status==3)
                    $edit=1;

            }


            if($et==1)
            {

                    if($selclaim=$wpdb->get_row("SELECT * FROM pre_travel_claim WHERE REQ_Id='$reqid'"))
                    $edit=0;
                    else
                    $edit=1;

            }



            if($edit)
            {
                    echo $editActbuttons;
            }

        }
}
    
function FinanceActions($et){
    global $wpdb;
    $reqid  =   $_GET['reqid'];
    $empuserid = $_SESSION['empuserid'];
    $compid = $_SESSION['compid'];
    $row = $wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");

    $actionButtons='<br />
        <div id="my_centered_buttons">
        <a href="" id="submitApprove" class="button button-primary">Approve</a> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="reject" id="reject" class="button erp-button-danger">Reject</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="back" id="reset" onClick="window.history.back();" class="button">Back</button>
        </div>';
    $approver = isApprover();
    
    
    $limitFlag	= '<div id="notice" class="notice notice-warning is-dismissible"><p id="p-notice">Sorry. Total expense cost exceeded your approval limit.</p></div>';

    // checking reporting manager has approved ?
	
	$repMngrApprvd=0;
	
	if($selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND REQ_Status=2 AND RS_Status=1"))
	$repMngrApprvd=1;
	
        // checking second level manager has approved ?
	
	$secMngrApprvd=0;
	
	if($selsecMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=5 AND REQ_Status=2 AND RS_Status=1"))
	$secMngrApprvd=1;
	
	// checking finance has approved ?
	
	$finApprvd=0;
	
	if($selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=2 AND REQ_Status IN (2,4) AND RS_Status=1"))
	$finApprvd=1;
	
	
	// finance approval limit
	
	$limit=0;
	
	//echo 'Total Cost='.$totalcost;
                                
	if($selfinlimit	=	$wpdb->get_row("SELECT APL_LimitAmount FROM approval_limit WHERE EMP_Id=$empuserid AND APL_Status=1 AND APL_Status IS NOT NULL AND APL_Active=1")){
	
		$limit_amnt	=	$selfinlimit['APL_LimitAmount'];
		
		if($limit_amnt <= $totalcost)
		$limit=1;
	
	}
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
        $mydetails = myDetails();
        $emp_code=$mydetails->EMP_Code;
        switch ($expPol)
        {
            // employee --> rep manager --> finance
		
		case 1:
	
                        //if its not my request and approval is waiting from sec manager
			if($secMngrApprvd) 
			{
			
				if(!$finApprvd){
				
					if(!$limit)
					echo $actionButtons;
					else
					echo $limitFlag;
				
				}
				
			
			}
			//if its not my request and approval is waiting from rep manager
			else if($repMngrApprvd) 
			{
			
				if(!$finApprvd){
				
					if(!$limit)
					echo $actionButtons;
					else
					echo $limitFlag;
				
				}
				
			
			}
		
			
		break;
		
		
		
		// employee --> finance --> rep manager
		
		case 2:
                    if(!$limit)
                    echo $actionButtons;
                    else
                    echo $limitFlag;
                break;
		// employee -- > finance
		case 4:
                    //if($secMngrApprvd) 
                    //{
			if(!$finApprvd){
				
				if(!$limit)
				echo $actionButtons;
				else
				echo $limitFlag;
				
			}
                    //}
//                    else if(!$secMngrApprvd){
//                        if(!$finApprvd){
//				
//				if(!$limit)
//				echo $actionButtons;
//				else
//				echo $limitFlag;
//				
//			}
//                    }
		
		break;
        }

}
function chat_box($rn_status){
      global $wpdb;
      $empuserid = $_SESSION['empuserid'];  
      $reqid = $_GET['reqid'];
      global $date;
      global $content;
      global $image;
      global $author;
      echo '<div class="note-tab-wrap erp-grid-container">';
      echo '<h3>Send Notes</h3>';

      echo '<form action="" class="note-form row" method="post">';    
      if($selsql=$wpdb->get_results("SELECT * FROM requests_notes WHERE REQ_Id='$reqid' ORDER BY RN_Id ASC")){
      //print_r($selsql);die;
      
	  foreach($selsql as $rowsql){
	  
	  
	  
		  switch ($rowsql->RN_Status)
		  {
			case 3:
				
				$date = date('d/m/y h:i a', strtotime($rowsql->RN_Date));
                                $author = "<b>Travel Desk: </b>";   
				$content = stripslashes($rowsql->RN_Notes);
                                $image = '<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32">';
				
			break;
			
			
			case 2:
                                $date = date('d/m/y h:i a', strtotime($rowsql->RN_Date));
                                $author = "<b>Finance: </b>";
				$content = stripslashes($rowsql->RN_Notes);
				$image = '<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32">';
			break;
			
			
			default:
                            
			if($rowemp=$wpdb->get_row("SELECT * FROM employees WHERE EMP_Id=$rowsql->EMP_Id")){
				
				$there=0;
                                
				if($rowempdet=$wpdb->get_row("SELECT * FROM EMPLOYEES WHERE EMP_Reprtnmngrcode='$rowemp->EMP_Code'"))
				{
					$there=1;
				
					if($row->EMP_Id==$rowsql->EMP_Id)
					$there=0;
					
				}
				$date = date('d/m/y h:i a', strtotime($rowsql->RN_Date));
                                $author = "<b>$rowemp->EMP_Code</b>";
				$content = stripslashes($rowsql->RN_Notes);
				$image = get_avatar( $rowemp->EMP_Email, 64 );
				}
			} // switch case 
		
	

        echo '<ul class="erp-list notes-list">';
                echo '<li>';
                    echo '<div class="avatar-wrap">';
                        echo $image;
                   echo '</div>';
                   echo '<div class="note-wrap">';
                    echo     '<div class="by">';
                         echo    '<a href="#" class="author">'.$author.'</a>';
                          echo   '<span class="date">'.$date.'</span>';
                      echo  '</div>';
                        echo '<div class="note-body">';
                              echo $content; 
                        echo '</div>';         
                    echo '</div>';
                echo '</li>';    
           echo ' </ul>';
        }// for each loop

    }
    
        erp_html_form_input( array(
            'name'        => 'note',
            'required'    => true,
            'placeholder' => __( 'Add a note...', 'erp' ),
            'type'        => 'textarea',
            'id'          => 'txtaNotes',
            'custom_attr' => array( 'rows' => 3, 'cols' => 30 )
        ) ); 

        echo '<input type="hidden" id="rn_status" name="rn_status" value="'.$rn_status.'">';
        echo '<input type="hidden" id="req_id" name="req_id" value="'.$reqid.'">';
        echo '<input type="hidden" id="emp_id" name="emp_id" value="'.$empuserid.'">';
        submit_button( __( 'Send Note', 'erp' ), 'primary', 'post-emp-chat' ); 
        echo '<span class="erp-loader erp-note-loader"></span>';
    echo '</form>';
    
echo '</div>';
}

