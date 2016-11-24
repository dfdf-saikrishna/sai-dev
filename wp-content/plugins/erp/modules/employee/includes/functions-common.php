<?php
ob_start();
?>
<script>
    function valPreCost(costval)
    {
	//alert('ok');return false;
	var chks=document.getElementsByName('txtCost[]');
	
	for(var i=0;i<chks.length;i++)
	{
		var costcont=chks[i].value.trim();
		
		reg=/[^0-9]/;
		if(reg.test(costcont)){  
		
			chks[i].value="";
			alert("Only Numbers Allowed here");
			chks[i].focus();
			return false;
			
		} else {
				
			//alert('fine');
						
			var selmode=document.getElementsByName('selModeofTransp[]');
			
			var currntModVal=selmode[i].value;
			
			currntModVal=parseInt(currntModVal);
			
			var ModLimitVal=getGradeLimitAmount(currntModVal);
			
			//alert(ModLimitVal);
			
			
			var ModLimitVal_0=parseInt(ModLimitVal[0]);
			
			//alert(ModLimitVal_0);			
			
			if(ModLimitVal_0!=0){
				
				var hotel=0;
				
				if(currntModVal==5 || currntModVal==6){
					
					var stayDur		=	document.getElementsByName('selStayDur[]');
					
					var stayDurNos	=	parseInt(stayDur[i].value);
				
					costcont		=	parseInt(chks[i].value)/stayDurNos;
					
					hotel=1;
				
				}
				
				//alert(costcont +'>'+ModLimitVal_0);
			
				if(costcont	> ModLimitVal_0){
					
					if(hotel)
					alert("Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis.");
					else{
                                        document.getElementById('show-exceed').innerHTML="Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0;
                                        document.getElementById("budget_limit").value = "1";
					//alert("Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0);
                                        }
					//$('#expenseLimit').val("1");
                                        //chks[i].value="";
					getTotal();
					//$("#field"+(i+1)).html(null);
					//chks[i].focus();
					return false;
			
				}else{
					//alert('ok');
                                        document.getElementById('show-exceed').innerHTML='';
                                        document.getElementById("budget_limit").value = "0";
					getTotal();
				}
			
			} else {
				getTotal();
			}
			
			
		}
	}
	
	
}

function getGradeLimitAmount(mode)
{
	var ModLimitVal;
	var _mode;
	
	switch (mode)
	{
		<?php 
		global $wpdb;
                $mydetails = myDetails();
                $selgrdLim=$wpdb->get_row("SELECT * FROM grade_limits WHERE EG_Id='$mydetails->EG_Id' AND GL_Status=1");
                $selgrdLim = json_decode(json_encode($selgrdLim), True);
                $selgrdLim=array_values($selgrdLim);
                $selall=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE COM_Id = 0 and MOD_Status=1 ORDER BY MOD_Id ASC");
	
		$i=0;
		foreach($selall as $row):
		
			 $k=$i+4;
		?>
		case <?php echo $row->MOD_Id ?>:
		_mode='<?php echo $row->MOD_Name ?>';
		ModLimitVal='<?php echo $selgrdLim[$k]; ?>';
		break;
		<?php $i++; endforeach; ?>
		default:
		_mode='0';
		ModLimitVal="0";
	}
		
		return [ModLimitVal , _mode];
}

function getTotal()
{
	
	var chks=document.getElementsByName('txtCost[]');
	
	var totalcost=0;
	
	for(var i=0;i<chks.length;i++)
	{		
		costotint=parseInt(chks[i].value.trim());		
		
		if(costotint){
		totalcost+=costotint;
		}
		
	}
	
	totalcost=indianRupeeFormat(totalcost);
	//alert(totalcost);
	
	if(totalcost!=0 && totalcost!=""){
	
		document.getElementById('totaltable').innerHTML='<table class="wp-list-table widefat striped admins" style="font-weight:bold;"><tr ><td align="right" width="85%">Total Amount</td><td align="center" width="5%">:</td><td align="right" width="10%">'+totalcost+'.00</td></tr></table>';
		
	} else {
		
		document.getElementById('totaltable').innerHTML='';
                document.getElementById('show-exceed').innerHTML='';
		
	}	
		
}

function indianRupeeFormat(x){
	
	x=x.toString();
	var lastThree = x.substring(x.length-3);
	var otherNumbers = x.substring(0,x.length-3);
	if(otherNumbers != '')
		lastThree = ',' + lastThree;
	var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
	
	//res=parseInt(res);
	
	return res;

}
    
</script>
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



