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
		
			//var Url="getMileage.php?modeid="+val;
                        
                        wp.ajax.send( 'get-mileage', {
                            data: {
                                modeid : val,
                            },
                            success: function(resp) {
                                console.log(resp);
                                var mileamount=parseFloat(resp) * distnce;
                                
				mileamount	=	parseInt(parseFloat(mileamount));
				
				j("#txtCost"+iteration).val(mileamount);

                            },
                            error: function(error) {
                                console.log( error );
                            }
                        });
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
	
		
	var htmlCont='<input type="text" class="form-control" name="txtCost[]" id="'+txtcost+'" onkeyup="valCost(this.value);" autocomplete="off" style="width:110px;"/><input  name="from[]" id="'+from+'" type="text" placeholder="From" class="form-control" style="width:130px; display:none;" value="n/a" ><input name="to[]" id="'+to+'" type="text" placeholder="To" class="form-control" style="width:130px; display:none;" value="n/a"><input type="text" class="form-control" name="txtdist[]" id="'+costIt+'" autocomplete="off" style="display:none;" value="n/a"/><select name="selStayDur[]" class="form-control" style="display:none;"><option value="n/a">Select</option></select>';


	//j(cityCont).html(htmlCont);
									
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
function getMotPreTravel(n,rownumber)
{
	//alert(rownumber);
	<?php 
        global $wpdb;
        $compid =  $_SESSION['compid'];
        ?>
	var smotid		=	'selModeofTransp'+rownumber;
	var selfromIt           =	"from"+rownumber;
	var seltoIt		=	"to"+rownumber;
	var	stayDur		=	"selStayDur"+rownumber;	
	
	var costIt		=	"txtdist"+rownumber;
		
	if(n==1)
	{
		
		content='<select name="selModeofTransp[]" id="'+smotid+'" onchange="chkCost(this.value, '+rownumber+');enbDisGetQuote(this.value,'+rownumber+');emptyQuote('+rownumber+');setFromTo(this.value, '+rownumber+');" class="form-control"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE EC_Id=1 AND COM_Id IN (0, '$compid') AND MOD_Status=1"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';

		
		citycontent='<input  name="from[]"  autocomplete="off" id="'+selfromIt+'" type="text" placeholder="From" class="form-control"><input name="to[]" id="'+seltoIt+'" type="text" placeholder="To" class="form-control"  autocomplete="off"><select name="selStayDur[]" id="'+stayDur+'" class="form-control" style="display:none;"><option value="n/a">Select</option></select>';
		
		
	}
	else if(n==2)
	{
				
		content='<select name="selModeofTransp[]" id="'+smotid+'"  onchange="chkCost(this.value, '+rownumber+');enbDisGetQuote(this.value,'+rownumber+');emptyQuote('+rownumber+');setFromTo(this.value, '+rownumber+');" class="form-control"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE EC_Id=2 AND COM_Id IN (0, '$compid') AND MOD_Status=1"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';
		
		
		citycontent='<input autocomplete="off" name="from[]" id="'+selfromIt+'" type="text" placeholder="Location" class="form-control"><input  name="to[]" id="'+seltoIt+'" type="text" placeholder="To" class="form-control" value="n/a" style="display:none;"><select name="selStayDur[]" id="'+stayDur+'" class="form-control" onchange="chkND(this.value, '+rownumber+');"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT SD_Id, SD_Name FROM stay_duration"); foreach($selsql as $rowsql){?><option value="<?php echo $rowsql->SD_Id;?>"><?php echo $rowsql->SD_Name;?></option><?php } ?></select>';
		
		
		
		//alert(citycontent);
		
	} else if(n==4){
	
		<?php if(!$etEdit){?>
		document.getElementById('getQuote'+rownumber).disabled=true;
		<?php } ?>
		
		content='<select name="selModeofTransp[]" id="'+smotid+'" onchange="chkCost(this.value, '+rownumber+'); emptyQuote('+rownumber+');" class="form-control" style="width:110px;"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE EC_Id=4 AND COM_Id IN (0, '$compid') AND MOD_Status=1"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';
		
		
			
		citycontent='<input autocomplete="off" name="from[]" id="'+selfromIt+'" type="text" placeholder="Location" class="form-control"><input  name="to[]" id="'+seltoIt+'" type="text" placeholder="To" class="form-control" value="n/a" style="display:none;"><select name="selStayDur[]" id="'+stayDur+'" class="form-control" style="display:none;"><option value="n/a">Select</option></select>';
	
	
	}
	
	
	
	
	if(n){
	
		modeoftranporid="modeoftr"+rownumber+"acontent";
		cityfromtoid="city"+rownumber+"container";
		
		//alert(modeoftranporid);
		
		document.getElementById(modeoftranporid).innerHTML=content;
		document.getElementById(cityfromtoid).innerHTML=citycontent;
	}
	
	var j = jQuery.noConflict();
	j("#field"+rownumber).html(null);
	
	j("#sessionid"+rownumber).val(null);
	j("#hiddenPrefrdSelected"+rownumber).val(null);
	j("#hiddenAllPrefered"+rownumber).val(null);
	  
	j("#txtCost"+rownumber).val(null);
	  
	
}
function getMotPosttravel(n,rownumber)
{
	
	//alert(n+","+rownumber);
	
	var selfromIt	="from"+rownumber;
	var seltoIt		="to"+rownumber;		
	var	stayDur		="selStayDur"+rownumber;
	var costIt		="txtdist"+rownumber;
	
	if(n==1)
	{		
		content='<select name="selModeofTransp[]" onchange="setFromTo(this.value, '+rownumber+');"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE EC_Id=1 AND COM_Id IN (0, '$compid') AND MOD_Status=1"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';
		
		
		
		citycontent='<input  name="from[]" id="'+selfromIt+'" type="text" placeholder="From" autocomplete="off"><input  name="to[]" id="'+seltoIt+'" type="text" placeholder="To" autocomplete="off"><select name="selStayDur[]" id="'+stayDur+'" style="display:none;"><option value="n/a">Select</option></select>';		
		
	}
	else if(n==2)
	{
		
		
		content='<select name="selModeofTransp[]" onchange="chkCostPost(this.value, '+rownumber+');"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE EC_Id=2 AND COM_Id IN (0, '$compid') AND MOD_Status=1"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';		
		
		citycontent='<input  name="from[]" id="'+selfromIt+'" type="text" placeholder="Location" autocomplete="off"><input  name="to[]" id="'+seltoIt+'" type="text" placeholder="To" value="n/a" style="display:none;"><select name="selStayDur[]" id="'+stayDur+'" onchange="chkNDPost(this.value, '+rownumber+');"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT SD_Id, SD_Name FROM stay_duration"); foreach($selsql as $rowsql){?><option value="<?php echo $rowsql->SD_Id;?>"><?php echo $rowsql->SD_Name;?></option><?php } ?></select>';
		
		
		
	}
	else if(n==4)
	{
		content='<select name="selModeofTransp[]"><option value="">Select</option><?php $selsql=$wpdb->get_results("SELECT MOD_Id, MOD_Name FROM mode WHERE EC_Id=4 AND COM_Id IN (0, '$compid') AND MOD_Status=1"); foreach($selsql as $rowsql){ ?><option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option><?php } ?></select>';
		
		
		citycontent='<input  name="from[]" id="'+selfromIt+'" type="text" placeholder="Location" autocomplete="off"><input  name="to[]" id="'+seltoIt+'" type="text" style="display:none;" placeholder="To" value="n/a"><select name="selStayDur[]" id="'+stayDur+'" style="display:none;"><option value="n/a">Select</option></select>';	
	
	}
	
	if(n){
	
		modeoftranporid="modeoftr"+rownumber+"acontent"
		cityfromtoid="city"+rownumber+"container";
		
		//alert(cityfromtoid);
		
		document.getElementById(modeoftranporid).innerHTML=content;
		document.getElementById(cityfromtoid).innerHTML=citycontent;
		
	}
}
function chkCost(modeValue, rowno)
{
	
	//alert("Mode="+modeValue+" rows="+rowno);
	
	var rowno=rowno-1;
	
	var chks=document.getElementsByName('txtCost[]'); 
	
	if(chks[rowno].value){
	
	var currntModVal=parseInt(modeValue);
	
	var ModLimitVal=getGradeLimitAmount(currntModVal);
	
	var ModLimitVal_0=parseInt(ModLimitVal[0]);
	
	//alert(ModLimitVal_0);
	
	///alert(chks[rowno].value);
	
	if(ModLimitVal_0!=0){
	
		if(currntModVal==5 || currntModVal==6){
					
			var stayDur		=	document.getElementsByName('selStayDur[]');
			
			var stayDurNos	=	parseInt(stayDur[rowno].value);
		
			var estCost		=	parseInt(chks[rowno].value)/stayDurNos;
		
		}
	
		if(estCost	>	ModLimitVal_0){
			
			alert("Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis.");
	
			chks[rowno].value="";
			chks[rowno].focus();
			return false;
		
		}
	
	}
		
	}
	
}
function enbDisGetQuote(modevals,i)
{
	//alert(modevals+'--'+i);
	
	if(modevals==1 || modevals==2 || modevals==5){
	
		document.getElementById('getQuote'+i).disabled=false;
	
	}else{
	
		document.getElementById('getQuote'+i).disabled=true;
	}
	
	
}
function emptyQuote(iter){

	//alert(iter);
        var j = jQuery.noConflict();
	j("#field"+iter).html(null);
	
	j("#sessionid"+iter).val(null);
	j("#hiddenPrefrdSelected"+iter).val(null);
	j("#hiddenAllPrefered"+iter).val(null);
	
	
	j("#txtCost"+iter).val(null);

}
function checkDeletRow()
{
	if(confirm("Are you sure want to delete this request details"))
	{
		return true;
	}
	else
	{
		return false;
	}
	
}
function chkCostPost(modeValue, rowno)
{
	
	//alert("Mode="+modeValue+" rows="+rowno);
	
	var rowno=rowno-1;
	
	var chks=document.getElementsByName('txtCost[]'); 
	
	if(chks[rowno].value){
	
		var currntModVal=parseInt(modeValue);
		
		var ModLimitVal=getGradeLimitAmount(currntModVal);
		
		var ModLimitVal_0=parseInt(ModLimitVal[0]);
		
		//alert(ModLimitVal_0);
		
		///alert(chks[rowno].value);
		
		if(ModLimitVal_0!=0){
		
			if(currntModVal==5 || currntModVal==6){
						
				var stayDur		=	document.getElementsByName('selStayDur[]');
				
				var stayDurNos	=	parseInt(stayDur[rowno].value);
			
				var estCost		=	parseInt(chks[rowno].value)/stayDurNos;
			
			}
		
			if(estCost	>	ModLimitVal_0){
				
				
				var limitval="Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis";
						
				$("#sms").val(limitval);
				
				var nclick=$(this), data=nclick.data();
				data.verticalEdge=data.vertical || 'right';
				data.horizontalEdge=data.horizontal  || 'top';
				$.notific8($("#sms").val(), data)	;
				
				/*alert("Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis.");
		
				chks[rowno].value="";
				chks[rowno].focus();*/
				return false;
			
			}
		
		}
		
	}
	
}
// on changing the stay duration check the grade limit amount

function chkNDPost(stayDurNos, rowno)
{
	
	//alert("Mode="+modeValue+" rows="+rowno);
	
	var rowno=rowno-1;
	
	var chks		=	document.getElementsByName('txtCost[]'); 
	
	var selexpcat	=	document.getElementsByName('selExpcat[]'); 
	
	var modeval		=	document.getElementsByName('selModeofTransp[]');
	
	if(chks[rowno].value){
	
		var currntModVal=parseInt(modeval[rowno].value.trim());
		
		//alert('Mode Val='+currntModVal);
		
		var ModLimitVal=getGradeLimitAmount(currntModVal);
		
		var ModLimitVal_0=parseInt(ModLimitVal[0]);
		
		//alert('mode limit 0th='+ModLimitVal_0);
		
		//alert('Cost='+chks[rowno].value);
		
		if(ModLimitVal_0!=0){
		
			if(currntModVal==5 || currntModVal==6)
			var estCost		=	parseInt(chks[rowno].value) / parseInt(stayDurNos);
			
			//alert('Estimated Cost='+estCost);
		
			if(estCost	>	ModLimitVal_0){
				
				var limitval="Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis";
						
				$("#sms").val(limitval);
				
				var nclick=$(this), data=nclick.data();
				data.verticalEdge=data.vertical || 'right';
				data.horizontalEdge=data.horizontal  || 'top';
				$.notific8($("#sms").val(), data)	;
				
				/*alert("Your "+ModLimitVal[1]+" expense limit is upto "+ModLimitVal_0+" on per day basis.");
		
				chks[rowno].value="";
				chks[rowno].focus();*/
				return false;
			
			}
		
		}
		
	}
	
}
function delFile(rfid,spanid){

//alert(rfid);
        var j = jQuery.noConflict();
	if(confirm("Are you sure want to delete this file"))
	{
		var filename=j('#filename').val();
		
		//alert(filename);
		
		//var Url="delRequestfiles.php";
		//Url=Url+"&rfid="+rfid;
		
                wp.ajax.send( 'delete-files', {
                    data: {
                        rfid : rfid,
                    },
                    success: function(msg) {
                        if(msg==1)
                         {
                                 j("#"+spanid).html("<font color='red'>file deleted</font>");
                                 j("#"+spanid).fadeOut(3000);
                         }else{
                                 alert("file could not be deleted. please contact your admin.");
                         }
                       
                    },
                    error: function(error) {
                        console.log( error );
                    }
                });
                
	}
	else
	{
		return false;
	}

}
function Validate(flname) {
	
	//alert(flname);
	
	var files = document.getElementById(flname).files;
	
	var flag=0;
       
        wp.ajax.send( 'get-file-extensions', {
            data: {},
            success: function(resp) {
                //console.log(resp);
                var _validFileExtensions = resp;
                for (var i = 0; i < files.length; i++)
                {		
		
		fileName=files[i].name;
		
		//alert(fileName);
		
		fileSplit=fileName.split(".");
				
		var blnValid = false;

		for (var j = 0; j < _validFileExtensions.length; j++) 
		{
						
			var sCurExtension = _validFileExtensions[j];
			
			filena="."+fileSplit[1].toLowerCase();
			
			
			if ( filena== sCurExtension.toLowerCase()) 
			{
				blnValid = true;
				sFileName=fileName;
				break;
			}
			else
			{
				sFileName=fileName;
			}
			
	
		}
			
			if (blnValid==false) {
				alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
				flag=1;
				document.getElementById(flname).value="";
				document.getElementById(flname).focus();
				return flag;
				break;
			}
		
		
	
                }

                return flag;
            },
            error: function(error) {
                console.log( error );
            }
        });
}
</script>

