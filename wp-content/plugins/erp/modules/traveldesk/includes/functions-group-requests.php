<?php

?>
<script>

function getMotPreTravel(n,rownumber)
{
	//alert(rownumber);
	<?php 
        global $wpdb;
        $compid =  $_SESSION['compid'];
        ?>
	var smotid		='selModeofTransp'+rownumber;
	var selfromIt	="from"+rownumber;
	var seltoIt		="to"+rownumber;
	var	stayDur		="selStayDur"+rownumber;	
		
	if(n==1)
	{		
                                                                                                                                                                                                                                                    
		content='<select name="selModeofTransp[]" id="'+smotid+'" onchange="chkCost(this.value, '+rownumber+');setFromTo(this.value, '+rownumber+');" class="form-control" style="width:110px;"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT * FROM mode WHERE MOD_Id IN (1,2)"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';

		
		
		citycontent='<input  name="from[]"  autocomplete="off" id="'+selfromIt+'" type="text" placeholder="From" class="form-control" style="width:130px;"><input  name="to[]" id="'+seltoIt+'" type="text" placeholder="To" class="form-control"  autocomplete="off" style="width:130px;"><select name="selStayDur[]" id="'+stayDur+'" class="form-control" style="width:100px;display:none;"><option value="n/a">Select</option></select>';
		
		
	}
	else if(n==2)
	{
                                                                                                                                                                                                      
		content='<select name="selModeofTransp[]" id="'+smotid+'"  onchange="chkCost(this.value, '+rownumber+');" class="form-control" style="width:110px;"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT * FROM mode WHERE MOD_Id IN (5)"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';
	
                                                                                                                                                                                                                                                                                                                                                                                                                                    
		citycontent='<input   autocomplete="off" name="from[]" id="'+selfromIt+'" type="text" placeholder="Location" class="form-control" style="width:130px;"><input  name="to[]" id="'+seltoIt+'" type="text" placeholder="To" class="form-control" value="n/a" style="display:none;"><select name="selStayDur[]" id="'+stayDur+'" class="form-control" style="width:130px;"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT * FROM stay_duration"); foreach($selsql as $rowsql){?><option value="<?php echo $rowsql->SD_Id;?>"><?php echo $rowsql->SD_Name;?></option><?php } ?></select>';
		
		//alert(citycontent);
		
	}
	
	
	
	
	if(n){
	
		modeoftranporid="modeoftr"+rownumber+"acontent";
		cityfromtoid="city"+rownumber+"container";
		
		//alert(modeoftranporid);
		
		document.getElementById(modeoftranporid).innerHTML=content;
		document.getElementById(cityfromtoid).innerHTML=citycontent;
	}
}
var $j = jQuery.noConflict();
$j("#selEmployees").on("change", function(){
	
	
	var el = document.getElementsByTagName('select')[0];
  		
		//alert(getSelectValues(el));
		
		var returnVal=getSelectValues(el);
		
		//alert(returnVal.join(",   "));
		
		retrnValJn=returnVal.join(",   ");
		
		$j("#txtaemployees").val("");
		
		$j("#txtaemployees").val(retrnValJn);
		
		valGroupRequestCost();
		
		getGrpBookingTotal();		

});


function setFromTo(modeval, rownumber){
									
	
	var cityCont	=	"#city"+rownumber+"container";
	
	var from	=	"from"+rownumber;
	var to		=	"to"+rownumber;
	
	//alert(modeval)
	
	if(modeval==1){
		
		var htmlCont='<input  name="from[]" id="'+from+'" type="text" placeholder="From" class="form-control places" style="width:130px;" ><input  name="to[]" id="'+to+'" type="text" placeholder="To" class="form-control places" style="width:130px;" ><select name="selStayDur[]" id="selStayDur'+rownumber+'" class="form-control" style="width:100px;display:none;"><option value="n/a">Select</option></select>';
		
				
	} else {
		
		var htmlCont	=	'<input  name="from[]" id="'+from+'" type="text" placeholder="From" class="form-control" style="width:130px;" ><input name="to[]" id="'+to+'" type="text" placeholder="To" class="form-control" style="width:130px;" >';
		
	}
	var $j = jQuery.noConflict();
	$j(cityCont).html(htmlCont);
	
	//if(modeval==1)
	//$j('.places').coolautosuggest({url:"../airports.php?chars=",});
	
									
}

function chkCost(modeValue, rowno)
{
	
	//alert("Mode="+modeValue+" rows="+rowno);
	
	var rowno=rowno-1;
	
	var chks=document.getElementsByName('txtCost[]'); 
	
	var estCost=chks[rowno].value;
	
	//if(estCost){ }
	
}

// group booking Total Cost

function valGroupRequestCost(){


	//alert('ok');
	
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
			
			//var cnt	=	$("#selEmployees :selected").length;
			var $j = jQuery.noConflict();
			var cnt = $j("#selEmployees").val();
                        var cnt = cnt.length;
			if(cnt && chks[i].value)
			document.getElementById("txtTotalCost"+(i+1)).value = chks[i].value * cnt;
			
			getGrpBookingTotal();
			
		}
		
	}

}

function getGrpBookingTotal()
{
	
	//alert("ok");
	
	var chks=document.getElementsByName('txtTotalCost[]');
	
	var totalcost=0;
	
	for(var i=0;i<chks.length;i++)
	{		
		costotint=parseInt(chks[i].value.trim());		
		
		if(costotint){
		totalcost+=costotint;
		}
		
	}
	
	
	totalcost=indianRupeeFormat(totalcost);
	
	
	if(totalcost!=0 && totalcost!=""){
		
		document.getElementById('totaltable').innerHTML='<table class="wp-list-table widefat striped admins" style=" font-weight:bold;"><tr ><td align="right" width="85%">Total Cost</td><td align="right" width="5%">:</td><td align="right" width="10%">Rs '+totalcost+'.00</td></tr></table>';
		}else{
		document.getElementById('totaltable').innerHTML='';
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
		}
		
	}
	
	
}

</script>

