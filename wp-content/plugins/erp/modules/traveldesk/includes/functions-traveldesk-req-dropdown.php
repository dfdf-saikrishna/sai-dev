<?php
ob_start();
?>
<script>
/**
* TRAVEL DESK JAVASCRIPT FILE
* COPYRIGHT THEFIRSTVENTURE
* @author Rahul R
*/
/*-------------------------------

		GET FIELDS 

/-------------------------------*/


// invoice  page invoice doc validation

function picval(flname) {
	
	//alert(flname);	
	
	var files = document.getElementById(flname).files;
	
	if(files.length>10){
		alert("Upto 10 files possible.");
		document.getElementById(flname).value='';
		document.getElementById(flname).focus();
		return false;
	}
	
	var flag=0;
	
	for (var i = 0; i < files.length; i++)
	{		
		
		fileName=files[i].name;
		
		//alert(fileName);
		
		fileSplit=fileName.split(".");
				
		var blnValid = false;
		
		for (var j = 0; j < fileExt.length; j++) 
		{
						
			var sCurExtension = fileExt[j];
			
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
				alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + fileExt.join(", "));
				document.getElementById(flname).value='';
				document.getElementById(flname).focus();
				flag=1;
				return flag;
				break;
			}
		
		
	
	}

    return flag;
}



function submitBookingForm(iteration) {
	
	
	var bookingActionval	=	$('#selBookingActions'+iteration).val();		
	var txtAmnt             =	$('#txtAmount'+iteration).val();
		
	var flname		=	'fileattach'+iteration+'[]';
		
	var fileField           =	document.getElementById(flname).files;
		
		
	var amntValidation = 0;
	
	if(bookingActionval==2)
	amntValidation=1;
	
		
	if(amntValidation){
		
		if(txtAmnt==""){
			
			alert("Please enter booked Amount.");
			$('#txtAmount'+iteration).focus();
			return false;
		}
		
		if(fileField.length=="" || fileField.length=="0"){
			alert("Please upload documents");	
			$('#fileattach'+iteration).focus();
			return false;
		}
		
	}
	
	
	
	$('#imgareaid'+iteration).html('<img src="../images/loading.gif">');
	
	
	
	console.log("submit event");
	var fd = new FormData(document.getElementById("bookingForm"+iteration));
	//fd.append("label", "sdfd");
	$.ajax({
	  url: "travel-agent-user-update-booking-status.php?iteration="+iteration,
	  type: "POST",
	  data: fd,
	  enctype: 'multipart/form-data',
	  processData: false,  // tell jQuery not to process the data
	  contentType: false   // tell jQuery not to set contentType
	}).done(function( result ) {
		
               // alert(result); return false;
		//console.log("PHP Output:");
		//console.log( data );
		
		switch (result){
			
			case '2':
				$("#resultid").html('<font color="red">Booking Status Updation failed. Please Try Again.</font>');
			break;
			
			case '3':
				$("#resultid").html('<font color="red">Snap !! Wrong file type uploaded.</font>');
			break;
			
			case '4':
				$("#resultid").html('<font color="red">Oops !! Some fields were not filled.</font>');
			break;
			
			case '5':
				$("#resultid").html('<font color="red">File couldn\'t be uploaded. Please check the files &amp; upload again</font>');
			break;
			
			case '6':
				$("#resultid").html('<font color="red">File size limit is upto 2 MB.</font>');
			break;
			
			default:
				document.getElementById('bookingStatusContainer'+iteration).innerHTML=result;
				
			break;
		}
		$('#imgareaid'+iteration).html("");
		
	});
	return false;
}



function cancelBookingstat(buttonId)
{	
	var txtamnt			=	'txtAmount'+buttonId;
	var amtDiv			=	'amntDiv'+buttonId;
	var ticketDiv		=	'ticketUploaddiv'+buttonId;
	var bookingbutton	=	'buttonUpdateStatus'+buttonId;
	var cancelButton	=	'buttonCancel'+buttonId;
	
	
	document.getElementById(amtDiv).style.display='none';
	document.getElementById(txtamnt).value=null;
	document.getElementById(amtDiv).style.display='none';
	
	document.getElementById(ticketDiv).value=null;
	document.getElementById(ticketDiv).style.display='none';
	
	document.getElementById(bookingbutton).style.display='none';
	document.getElementById(cancelButton).style.display='none';
	
}


function showHideBooking(flid, bookingActionval)
{
	alert(flid);
	
	var divcan			=	'amntDiv'+flid;
	var txtAmnt			=	'txtAmount'+flid;	
	var bookingbutton	=	'buttonUpdateStatus'+flid;
	var cancelButton	=	'buttonCancel'+flid;
	var selectOptionval	=	'selectoptionval'+flid;
	var ticketdiv		=	'ticketUploaddiv'+flid;
	var fileattach		=	'fileattach'+flid+'[]';
	
		
	switch(bookingActionval){
		
		case '2': // booked
		document.getElementById(txtAmnt).placeholder ="Booked Amount";
		document.getElementById(txtAmnt).value=null;
		document.getElementById(divcan).style.display='inline';
		document.getElementById(ticketdiv).style.display='inline';
		document.getElementById(fileattach).value=null;
		break;
				
		case '3': // failed to book
		document.getElementById(txtAmnt).value=null;
		document.getElementById(divcan).style.display='none';
		document.getElementById(fileattach).value=null;
		document.getElementById(ticketdiv).style.display='none';
		break;
		
		default: // select
		document.getElementById(divcan).style.display='none';
		document.getElementById(txtAmnt).value=null;
		document.getElementById(fileattach).value=null;
		document.getElementById(ticketdiv).style.display='none';
		document.getElementById(bookingbutton).style.display='none';
		document.getElementById(cancelButton).style.display='none';
		
		
	}		
		
		
		if(bookingActionval){
			document.getElementById(bookingbutton).style.display='inline';
			document.getElementById(cancelButton).style.display='inline';
		}
		
	
}
	
	
	
	/*
	
	---------- CANCELLATION REQUEST ---------------
	
	*/
	
	
function cancelCancstat(buttonId)
{	
	var selCancActions	=	'selCancActions'+buttonId;
	var cancAmntDiv		=	'cancAmntDiv'+buttonId;
	var canAmnt			=	'txtCanAmount'+buttonId;
	var bookingbutton	=	'buttonUpdateStatusCanc'+buttonId;
	var cancelButton	=	'buttonCancelCanc'+buttonId;
	var ticketcandiv	=	'ticketCancDiv'+buttonId;
	var fileCanAttach	=	'fileCanAttach'+buttonId+'[]'
	
	//document.getElementById(selCancActions).value=null;
	document.getElementById(cancAmntDiv).style.display='none';
	document.getElementById(canAmnt).value=null;
	document.getElementById(fileCanAttach).value=null;
	document.getElementById(ticketcandiv).style.display='none';
	document.getElementById(bookingbutton).style.display='none';
	document.getElementById(cancelButton).style.display='none';
	
}



function submitCancellationForm(iteration) {
	
	
	//alert('ok')
	
	var bookingActionval	=	$('#selCancActions'+iteration).val();		
	var txtAmnt				=	$('#txtCanAmount'+iteration).val();
	//var fileField			=	$('#fileCanAttach'+iteration).val();
	
	var flname	=	'fileCanAttach'+iteration+'[]';
	
	var fileField	= document.getElementById(flname).files;
	
		
	var amntValidation = 0;
	
	if(bookingActionval==4){

		amntValidation=1;
		
	}
		
	if(amntValidation){
		
		if(txtAmnt==""){
			
			alert("Please enter cancellation Amount.");
			$('#txtCanAmount'+iteration).focus();
			return false;
		}
		
		if(fileField.length=="" || fileField.length=="0"){
			alert("Please upload documents");	
			$('#fileCanAttach'+iteration).focus();
			return false;
		}
		
		
	}	
	
	
	$('#imgareaid2'+iteration).html('<img src="../images/loading.gif">');
	
	
	
	//console.log("submit event");
	
	//alert(bookingActionval);return false;
	
	var fd = new FormData(document.getElementById("cancellationForm"+iteration));
	//fd.append("label", "sdfd");
	
	//alert(fd.serialize()); return false;
	
	$.ajax({
	  url: "travel-agent-user-update-booking-status.php?iteration="+iteration,
	  type: "POST",
	  data: fd,
	  enctype: 'multipart/form-data',
	  processData: false,  // tell jQuery not to process the data
	  contentType: false   // tell jQuery not to set contentType
	}).done(function( result ) {
		
		//alert(result);  return false;
		//console.log("PHP Output:");
		//console.log( data );
		
		switch (result){
			
			// BOOKING ------------------
			
			case '2':
				$("#resultid").html('<font color="red">Cancellation Updation failed. Please Try Again.</font>');
			break;
			
			case '3':
				$("#resultid").html('<font color="red">Snap !! Wrong file type uploaded.</font>');
			break;
			
			case '4':
				$("#resultid").html('<font color="red">Oops !! Some fields were not filled.</font>');
			break;
			
			case '5':
				$("#resultid").html('<font color="red">File couldn\'t be uploaded. Please check the files &amp; upload again</font>');
			break;			
			
			
			default:
				document.getElementById('cancelStatusContainer'+iteration).innerHTML=result;
				
			break;
		}
		$('#imgareaid2'+iteration).html("");
		
	});
	return false;
}


function showHideCanc(flid, bookingActionval)
{
	var cancAmntDiv		=	'cancAmntDiv'+flid;	
	var txtCancAmnt		=	'txtCanAmount'+flid;
	var ticketCancDiv	=	'ticketCancDiv'+flid;
	var fileCanAttach	=	'fileCanAttach'+flid+'[]';
	var bookingbutton	=	'buttonUpdateStatusCanc'+flid;
	var cancelButton	=	'buttonCancelCanc'+flid;	
	
	//alert(bookingActionval);
	
	switch(bookingActionval){
		
		case '4': case '6':
		document.getElementById(cancAmntDiv).style.display='inline';
		document.getElementById(txtCancAmnt).value=null;
		document.getElementById(txtCancAmnt).placeholder="Cancellation Amount";
		document.getElementById(ticketCancDiv).style.display='inline';
		document.getElementById(fileCanAttach).value=null;
		break;
				
		case '5': case '7':
		document.getElementById(txtCancAmnt).placeholder ="";
		document.getElementById(txtCancAmnt).value=null;
		document.getElementById(cancAmntDiv).style.display='none';
		document.getElementById(fileCanAttach).value=null;		
		document.getElementById(ticketCancDiv).style.display='none';
		break;
		
		
		default:
		document.getElementById(cancAmntDiv).style.display='none';
		document.getElementById(txtCancAmnt).value=null;
		document.getElementById(ticketCancDiv).style.display='none';
		document.getElementById(fileCanAttach).value=null;
		document.getElementById(bookingbutton).style.display='none';
		document.getElementById(cancelButton).style.display='none';
		
		
	}
	
	if(bookingActionval){
	
		document.getElementById(bookingbutton).style.display='inline';
		document.getElementById(cancelButton).style.display='inline';
	
	}
}
	
/*-------------------------------

		GET QUOTE

/-------------------------------*/

var bkp;
function upload()
{
	bkp=document.getElementById('fileDiv').innerHTML;
	
	document.getElementById('fileDiv').innerHTML="<input type='file' name='fileComplogo' id='fileComplogo'  />&nbsp;<a href='javascript:cancelImg()'>Cancel</a>";
}
function cancelImg()
{
	document.getElementById('fileDiv').innerHTML=bkp;
}
function getClick()
{	
	//alert('ok');return false;
	$('#closeButtonnn').trigger('click');
}

function checkDeletRow()
{
	if(confirm("Are you sure want to delete this request details"))
		return true;
	else
		return false;
	
}


function delFile(rfid,spanid){

//alert(rfid);

	if(confirm("Are you sure want to delete this file"))
	{
		var filename=$('#filename').val();
		
		//alert(filename);
		
		var Url="delRequestfiles.php";
		Url=Url+"?rfid="+rfid+"&filename="+filename;
		
		$.ajax({
	   type: "GET",
	   url: Url,
	   //data: "name=John&location=Boston",
	   success: function(msg){
		// alert( "Data Saved: " + msg );
		
		if(msg==1)
		{
			$("#"+spanid).html("<font color='red'>file deleted</font>");
			$("#"+spanid).fadeOut(3000);
		}else{
			alert("file could not be deleted. please contact your admin.");
		}
		
	   }
	 }); 
		
	}
	else
	{
		return false;
	}

}
///////////////////////////////////////
////  DATE PICKER   ////////////////////
///////////////////////////////////////

/**
 * DHTML date validation script for dd/mm/yyyy. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/datevalidation.asp)
 */
// Declaring valid date character, minimum year and maximum year



function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(dtStr){

	//var currentDate=new Date();

	var dtCh= "/";
	var minYear=2015;
	//var maxYear=currentDate.getFullYear();
	
	var maxYear=2016;
	
	//alert(maxYear);


	var daysInMonth = DaysArray(12);
	var pos1=dtStr.indexOf(dtCh);
	var pos2=dtStr.indexOf(dtCh,pos1+1);
	var strDay=dtStr.substring(0,pos1);
	var strMonth=dtStr.substring(pos1+1,pos2);
	var strYear=dtStr.substring(pos2+1);
	strYr=strYear;
	if (strDay.charAt(0)=="0" && strDay.length>1) 
	strDay=strDay.substring(1);
	
	if (strMonth.charAt(0)=="0" && strMonth.length>1) 
	strMonth=strMonth.substring(1);
	
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1)
		strYr=strYr.substring(1);
	}
	
	month=parseInt(strMonth);
	day=parseInt(strDay);
	year=parseInt(strYr);
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : dd/mm/yyyy  \n eg: 31/01/1999");
		return false;
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month");
		return false;
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day");
		return false;
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear);
		return false;
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date");
		return false;
	}
return true;
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



function getSelectValues(select) {
  var result = [];
  var options = select && select.options;
  var opt;


  for (var i=0, iLen=options.length; i<iLen; i++) {
    opt = options[i];

    if (opt.selected) {
      //result.push(opt.value || opt.text);
	  
	  result.push(opt.text);
    }
  }
  
  return result;
}
	function checkCost(fieldid)
	{
		var costcont=document.getElementById(fieldid).value;
		
		//alert(costcont);
		
		reg=/[^0-9]/;
		if(reg.test(costcont)){              
		document.getElementById(fieldid).value=null;
		
			alert("Only Numbers Allowed here");
			document.getElementById(fieldid).focus();
			return false;
		}       
		}
		
function actionhere(cmpid)
{
	window.location.href="travel-agent-company-admin.php?cmpid="+cmpid;
}

//============================================//
//===========FINANCE APPROVER=================//
//=============================================//

function financeApprover(n)
{
	empids=document.getElementsByName('chkuser[]');
	empidslen=empids.length;
	var checkd=false;
	
	for(i=0;i<empidslen;i++){
		if(empids[i].checked)
		{
			checkd=true;
			break;
			}
		}
		
		if(checkd==false)
		{
			alert("Please select atleast one employee.");
			return false;
			}
			
			switch(n)
			{
				/*case 1:
				
				if(confirm("Are you sure want to set them as Group Approvers"))
				return true;
				else
				return false;
				
				break;
				
				
				
				case 2:
				
				if(confirm("Are you sure want to remove them as Group Approvers"))
				return true;
				else
				return false;
				
				break;
				*/
				
				
				case 3:
				
				if(confirm("Are you sure want to set them as finance approvers"))
				return true;
				else
				return false;
				
				break;
				
				
				
				case 4:
				
				if(confirm("Are you sure want to remove them from finance approvers"))
				return true;
				else
				return false;
				
				break;
			}
			
		
	}
	
	
	//---------------------------------------------------------//
//-------------CHECK ANY DUPLICATE EMPLOYEE CODE-----------//  
//-----------------------------------------------------------//	
		
function checkempcode(empcode,n)
{
	
	//alert("Employee Code="+empcode+",, N="+n); //return false;
	
	empcodeval=document.getElementById('txtEmpcode').value;
	
	//alert('Empl Code Val='+empcodeval);
		
		var Url	=	"check-empcode.php?empcode="+empcode;
		
	
	$.ajax({url: Url, success: function(result){
									 
		//alert(result);
				
		$("#errtext").html(result);
		
		if(result)
		$("#txtEmpcode").focus();
		
	
	}});


	
}

// check username

function checkUsername(flname, str, n)
{
	//alert(str);
	
	/*if(str.length<4)
	{
		document.getElementById("usernameid").innerHTML='<font color="#FF0000" size="-1">Username should be atleast four characters</font>';
		//document.getElementById("usernameid").innerHTML="";
		return false;
	}*/
	
	if(str.length >= 4)
	{
		//alert(flname);
			
		$("#iamgeid"+n).css("display","block");
							  
		
		//return false;
		//alert("Hai"+str);
		
		var Url="travel-agent-check-username.php?q="+str;
		
		//alert(Url);
		
		
		 $.ajax({url: Url, success: function(result){
											 			
			if(result==1){
				
				$("#usernameid"+n).focus(flname);
				
				$("#usernameid"+n).html('<font color="#FF0000" size=-2>Username already exists. Please use another username</font>');
				
			} else {
			
				$("#usernameid"+n).html(null);
			
			}
			
		}});

	}
}



var hexcase=0;function hex_md5(a){return rstr2hex(rstr_md5(str2rstr_utf8(a)))}function hex_hmac_md5(a,b){return rstr2hex(rstr_hmac_md5(str2rstr_utf8(a),str2rstr_utf8(b)))}function md5_vm_test(){return hex_md5("abc").toLowerCase()=="900150983cd24fb0d6963f7d28e17f72"}function rstr_md5(a){return binl2rstr(binl_md5(rstr2binl(a),a.length*8))}function rstr_hmac_md5(c,f){var e=rstr2binl(c);if(e.length>16){e=binl_md5(e,c.length*8)}var a=Array(16),d=Array(16);for(var b=0;b<16;b++){a[b]=e[b]^909522486;d[b]=e[b]^1549556828}var g=binl_md5(a.concat(rstr2binl(f)),512+f.length*8);return binl2rstr(binl_md5(d.concat(g),512+128))}function rstr2hex(c){try{hexcase}catch(g){hexcase=0}var f=hexcase?"0123456789ABCDEF":"0123456789abcdef";var b="";var a;for(var d=0;d<c.length;d++){a=c.charCodeAt(d);b+=f.charAt((a>>>4)&15)+f.charAt(a&15)}return b}function str2rstr_utf8(c){var b="";var d=-1;var a,e;while(++d<c.length){a=c.charCodeAt(d);e=d+1<c.length?c.charCodeAt(d+1):0;if(55296<=a&&a<=56319&&56320<=e&&e<=57343){a=65536+((a&1023)<<10)+(e&1023);d++}if(a<=127){b+=String.fromCharCode(a)}else{if(a<=2047){b+=String.fromCharCode(192|((a>>>6)&31),128|(a&63))}else{if(a<=65535){b+=String.fromCharCode(224|((a>>>12)&15),128|((a>>>6)&63),128|(a&63))}else{if(a<=2097151){b+=String.fromCharCode(240|((a>>>18)&7),128|((a>>>12)&63),128|((a>>>6)&63),128|(a&63))}}}}}return b}function rstr2binl(b){var a=Array(b.length>>2);for(var c=0;c<a.length;c++){a[c]=0}for(var c=0;c<b.length*8;c+=8){a[c>>5]|=(b.charCodeAt(c/8)&255)<<(c%32)}return a}function binl2rstr(b){var a="";for(var c=0;c<b.length*32;c+=8){a+=String.fromCharCode((b[c>>5]>>>(c%32))&255)}return a}function binl_md5(p,k){p[k>>5]|=128<<((k)%32);p[(((k+64)>>>9)<<4)+14]=k;var o=1732584193;var n=-271733879;var m=-1732584194;var l=271733878;for(var g=0;g<p.length;g+=16){var j=o;var h=n;var f=m;var e=l;o=md5_ff(o,n,m,l,p[g+0],7,-680876936);l=md5_ff(l,o,n,m,p[g+1],12,-389564586);m=md5_ff(m,l,o,n,p[g+2],17,606105819);n=md5_ff(n,m,l,o,p[g+3],22,-1044525330);o=md5_ff(o,n,m,l,p[g+4],7,-176418897);l=md5_ff(l,o,n,m,p[g+5],12,1200080426);m=md5_ff(m,l,o,n,p[g+6],17,-1473231341);n=md5_ff(n,m,l,o,p[g+7],22,-45705983);o=md5_ff(o,n,m,l,p[g+8],7,1770035416);l=md5_ff(l,o,n,m,p[g+9],12,-1958414417);m=md5_ff(m,l,o,n,p[g+10],17,-42063);n=md5_ff(n,m,l,o,p[g+11],22,-1990404162);o=md5_ff(o,n,m,l,p[g+12],7,1804603682);l=md5_ff(l,o,n,m,p[g+13],12,-40341101);m=md5_ff(m,l,o,n,p[g+14],17,-1502002290);n=md5_ff(n,m,l,o,p[g+15],22,1236535329);o=md5_gg(o,n,m,l,p[g+1],5,-165796510);l=md5_gg(l,o,n,m,p[g+6],9,-1069501632);m=md5_gg(m,l,o,n,p[g+11],14,643717713);n=md5_gg(n,m,l,o,p[g+0],20,-373897302);o=md5_gg(o,n,m,l,p[g+5],5,-701558691);l=md5_gg(l,o,n,m,p[g+10],9,38016083);m=md5_gg(m,l,o,n,p[g+15],14,-660478335);n=md5_gg(n,m,l,o,p[g+4],20,-405537848);o=md5_gg(o,n,m,l,p[g+9],5,568446438);l=md5_gg(l,o,n,m,p[g+14],9,-1019803690);m=md5_gg(m,l,o,n,p[g+3],14,-187363961);n=md5_gg(n,m,l,o,p[g+8],20,1163531501);o=md5_gg(o,n,m,l,p[g+13],5,-1444681467);l=md5_gg(l,o,n,m,p[g+2],9,-51403784);m=md5_gg(m,l,o,n,p[g+7],14,1735328473);n=md5_gg(n,m,l,o,p[g+12],20,-1926607734);o=md5_hh(o,n,m,l,p[g+5],4,-378558);l=md5_hh(l,o,n,m,p[g+8],11,-2022574463);m=md5_hh(m,l,o,n,p[g+11],16,1839030562);n=md5_hh(n,m,l,o,p[g+14],23,-35309556);o=md5_hh(o,n,m,l,p[g+1],4,-1530992060);l=md5_hh(l,o,n,m,p[g+4],11,1272893353);m=md5_hh(m,l,o,n,p[g+7],16,-155497632);n=md5_hh(n,m,l,o,p[g+10],23,-1094730640);o=md5_hh(o,n,m,l,p[g+13],4,681279174);l=md5_hh(l,o,n,m,p[g+0],11,-358537222);m=md5_hh(m,l,o,n,p[g+3],16,-722521979);n=md5_hh(n,m,l,o,p[g+6],23,76029189);o=md5_hh(o,n,m,l,p[g+9],4,-640364487);l=md5_hh(l,o,n,m,p[g+12],11,-421815835);m=md5_hh(m,l,o,n,p[g+15],16,530742520);n=md5_hh(n,m,l,o,p[g+2],23,-995338651);o=md5_ii(o,n,m,l,p[g+0],6,-198630844);l=md5_ii(l,o,n,m,p[g+7],10,1126891415);m=md5_ii(m,l,o,n,p[g+14],15,-1416354905);n=md5_ii(n,m,l,o,p[g+5],21,-57434055);o=md5_ii(o,n,m,l,p[g+12],6,1700485571);l=md5_ii(l,o,n,m,p[g+3],10,-1894986606);m=md5_ii(m,l,o,n,p[g+10],15,-1051523);n=md5_ii(n,m,l,o,p[g+1],21,-2054922799);o=md5_ii(o,n,m,l,p[g+8],6,1873313359);l=md5_ii(l,o,n,m,p[g+15],10,-30611744);m=md5_ii(m,l,o,n,p[g+6],15,-1560198380);n=md5_ii(n,m,l,o,p[g+13],21,1309151649);o=md5_ii(o,n,m,l,p[g+4],6,-145523070);l=md5_ii(l,o,n,m,p[g+11],10,-1120210379);m=md5_ii(m,l,o,n,p[g+2],15,718787259);n=md5_ii(n,m,l,o,p[g+9],21,-343485551);o=safe_add(o,j);n=safe_add(n,h);m=safe_add(m,f);l=safe_add(l,e)}return Array(o,n,m,l)}function md5_cmn(h,e,d,c,g,f){return safe_add(bit_rol(safe_add(safe_add(e,h),safe_add(c,f)),g),d)}function md5_ff(g,f,k,j,e,i,h){return md5_cmn((f&k)|((~f)&j),g,f,e,i,h)}function md5_gg(g,f,k,j,e,i,h){return md5_cmn((f&j)|(k&(~j)),g,f,e,i,h)}function md5_hh(g,f,k,j,e,i,h){return md5_cmn(f^k^j,g,f,e,i,h)}function md5_ii(g,f,k,j,e,i,h){return md5_cmn(k^(f|(~j)),g,f,e,i,h)}function safe_add(a,d){var c=(a&65535)+(d&65535);var b=(a>>16)+(d>>16)+(c>>16);return(b<<16)|(c&65535)}function bit_rol(a,b){return(a<<b)|(a>>>(32-b))};
	
	
	function getHash(flname, password)
	{
		
		var id="#"+flname;
		
		str=$(id).val();
		
		if(str){
			
			var hashStr=hex_md5(str);
			
			//alert(hashStr);
			
			id='#'+password;
						
			$("#"+password).val(hashStr);
			
			//alert(str=$("#"+password).val());
		}
				
	
	}
	

</script>

