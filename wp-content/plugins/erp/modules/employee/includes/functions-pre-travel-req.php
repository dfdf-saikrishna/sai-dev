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

function mileageAmount(val, iteration){
	
	var j = jQuery.noConflict();
	var modeval	=	j("#selModeofTransp"+iteration).val();
	
	if(val=="")
	j("#txtCost"+iteration).val(null);
	
	if(modeval==""){
		
		j("#txtdist"+iteration).val(null);
		j("#txtCost"+iteration).val(null);
		alert("Please select expense category first.");
		return false;
		
	} else if(modeval && val) {
		
		result=null;
		
		switch(modeval){
			
			case '31':
			result=j("#hiddenTwowheeler").val();
			break;
			
			case '32':
			result=j("#hiddenFourwheeler").val();
			break;
			
		}
				
		var mileamount=parseFloat(result) * val;
			
		//alert(mileamount);
		
		mileamount	=	parseInt(parseFloat(mileamount));
		
		j("#txtCost"+iteration).val(mileamount);
	
	}
	
}
// mileage calculation


function getAmount(val, iteration){
	var j = jQuery.noConflict();
	if(val){
	
		var distnce=j("#txtdist"+iteration).val();
		
		if(distnce){
		
			var Url="getMileage.php?modeid="+val;
		
			//$.ajax({url: Url, success: function(result){
					
				//alert(result);
					
				//var mileamount=parseFloat(result) * distnce;
				var mileamount=parseFloat(123) * distnce;
				//alert(mileamount);
				
				mileamount	=	parseInt(parseFloat(mileamount));
				
				j("#txtCost"+iteration).val(mileamount);
				
			//}});
		
		}
		
	} else {
		
		j("#txtdist"+iteration).val(null);
		j("#txtCost"+iteration).val(null);
	}
	
}
function setFromTo(modeval, rownumber){
	var j = jQuery.noConflict();								
	
	var cityCont	=	"#city"+rownumber+"container";
	
	var from		=	"from"+rownumber;
	
	var to			=	"to"+rownumber;
	
	var costIt		=	"txtdist"+rownumber;
	
	var txtcost		=	"txtCost"+rownumber;
	
	//alert(cityCont)
	
		
	var htmlCont='<input type="text" class="form-control" name="txtCost[]" id="+txtcost+" onkeyup="valCost(this.value);" autocomplete="off" style="width:110px;"/><input  name="from[]" id="'+from+'" type="text" placeholder="From" class="form-control" style="width:130px; display:none;" value="n/a" ><input name="to[]" id="'+to+'" type="text" placeholder="To" class="form-control" style="width:130px; display:none;" value="n/a"><input type="text" class="form-control" name="txtdist[]" id="'+costIt+'" autocomplete="off" style="display:none;" value="n/a"/><select name="selStayDur[]" class="form-control" style="display:none;"><option value="n/a">Select</option></select>';


	j(cityCont).html(htmlCont);
									
}
function valCost(costval)
{
		//alert();
        var j = jQuery.noConflict();        
	if(costval.length>=1){
		
		var chks=document.getElementsByName('txtCost[]');
		
		for(var i=0;i<chks.length;i++)
		{
			var costcont=chks[i].value.trim();
			
			reg=/[^0-9]/;
			if(reg.test(costcont)){              
			chks[i].value="";
				alert("Only Numbers Allowed here");
				chks[i].focus;
				return false;
			}               
			else
			{
				
						
				var selmode=document.getElementsByName('selModeofTransp[]');
				
				var currntModVal=selmode[i].value;
				
				currntModVal=parseInt(currntModVal);
				
				//alert(currntModVal);
				
				var ModLimitVal=getGradeLimitAmount(currntModVal);
				
				//alert(ModLimitVal);
				
				var ModLimitVal_0=parseInt(ModLimitVal[0]);
				
				//alert(ModLimitVal_0);			
				
				if(ModLimitVal_0!=0){
					
					var hotel=0;
					
					if(currntModVal==5 || currntModVal==6){
					
						var stayDur		=	document.getElementsByName('selStayDur[]');
						
						var stayDurNos	=	parseInt(stayDur[i].value);
					
						costcont		=	parseInt(costcont)/stayDurNos;
						
						hotel=1;
					
					}
					
					//alert(estCost +'>'+ ModLimitVal_0);
				
					if(costcont > ModLimitVal_0){
						
						if(hotel){
						
							var limitval="Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis";
						
						} else {
							
							var limitval="Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0;
							
						}
						j('#info').show();
                                                j('#p-info').html(limitval);
//						j("#sms").val(limitval);
//						
//						var nclick=j(this), data=nclick.data();
//						data.verticalEdge=data.vertical || 'right';
//						data.horizontalEdge=data.horizontal  || 'top';
//						j.notific8(j("#sms").val(), data);
						
						getTotal();
						//chks[i].value="";
						//chks[i].focus();
						return false;
				
					} else {
						//alert('ok');
                                                j('#info').hide();
						getTotal();
					}
				
				} else {
					getTotal();
				}
			}
		}
	
	} else {
	
		getTotal();
	 
	}
}
</script>

