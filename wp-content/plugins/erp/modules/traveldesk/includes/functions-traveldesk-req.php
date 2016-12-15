<?php
ob_start();
?>
<script>
    function valPreCost(costval,empId)
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
					
					var stayDurNos          =	parseInt(stayDur[i].value);
				
					costcont		=	parseInt(chks[i].value)/stayDurNos;
					
					hotel=1;
				
				}
				
				//alert(costcont +'>'+ModLimitVal_0);
			
				if(costcont	> ModLimitVal_0){
					
					if(hotel)
					alert("Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis.");
					else{
                                        document.getElementById('show-exceed').innerHTML="Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0;
                                        document.getElementById("expenseLimit").value = "1";
                                        var myclass = document.getElementById("grade-limit").classList;
                                         if (myclass.contains("closed")) {
                                            myclass.remove("closed");
                                         }

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
                                        document.getElementById("expenseLimit").value = "0";
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
                //$mydetails = myDetails(empId);
                
                 $compid = $_SESSION['compid'];
                 if(isset($_REQUEST['selEmployees'])){
                 $empid = $_REQUEST['selEmployees'];
                 }else{
                     $reqid = $_REQUEST['reqid'];
                     $row = $wpdb->get_row("SELECT * FROM requests req, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Claim IS NULL and req.REQ_Id=re.REQ_Id AND COM_Id='$compid' AND REQ_Active != 9 AND REQ_Type=3 AND RE_Status=1");
                     $empid = $row->EMP_Id;
                 }
                 
                $mydetails=$wpdb->get_row("SELECT * FROM employees WHERE EMP_Id='$empid' AND COM_Id='$compid' AND EMP_Status=1");
                
                
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

