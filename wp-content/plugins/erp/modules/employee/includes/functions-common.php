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

function myEmpDetails($empid=NULL)
{
    $empuserid = $_SESSION['empuserid'];
    $compid = $_SESSION['compid'];
	
	if(!$empid)
	$empid=$empuserid;
	
	 global $wpdb;
	
	$mydetails=$wpdb->get_results("SELECT * FROM employees WHERE EMP_Id='$empid' AND COM_Id='$compid' AND EMP_Status=1");
	
	return $mydetails;
}

//EMPLOYEE DETAILS

function isApprover()
{
    
    global $wpdb;
    $empuserid = $_SESSION['empuserid'];
    $compid = $_SESSION['compid'];
	
	$mydetails	=	myEmpDetails();
        $rcode=$mydetails['0']->EMP_Code;
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
	
	$mydetails=$wpdb->get_results("SELECT * FROM employees WHERE EMP_Id='$empid' AND COM_Id='$compid' AND EMP_Status=1");
	
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
        $selgrdLim=$wpdb->get_row("SELECT * FROM grade_limits WHERE EG_Id='$mydetails->EG_Id' AND GL_Status=1");
        //$selgrdLim=select_query("grade_limits", "*", "EG_Id='$mydetails[EG_Id]' AND GL_Status=1", $filename, 0);
        
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

            
            if($totalLimitAmnt < 1) echo '<script>$("#expenseLimitId").css("display", "none");</script>';

        
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


