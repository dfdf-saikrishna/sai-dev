<?php
/**
 * [erp_hr_employee_single_tab_permission description]
 *
 * @return void
 */
//EMPLOYEE DETAILS

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


