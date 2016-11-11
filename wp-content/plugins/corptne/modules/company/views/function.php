<?php
error_reporting(0);

/*ini_set("display_startup_errors", "On");
ini_set("display_errors", "On");
error_reporting(-1);*/

if(session_id() == '') {
    session_start();
}
$empuserid	=	$_SESSION['empuserid'];
$compid		=	$_SESSION['compid'];

include_once("admin/database.php");

$filename=basename($_SERVER['PHP_SELF']);

date_default_timezone_set("Asia/Kolkata");

$curdatetime = date('Y-m-d H:i:s');

require("mailnotifications.php");


function getNumRowsQuery($selsql, $filename=false, $show=false){

	global $con;
	
	if($show){
		echo $selsql;
		exit;
	}
	
	$ressql	=	$con->query($selsql);
	
	$num_rows = $ressql->num_rows;
	
	$error=0; //query success
			
	if (!$ressql) {
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$error=1; //query failed
	}
	
	if($error){
		
		$mailmsg="Get Num Rows Query = ".$selsql."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
		
		
		mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
		
		$insert=addslashes($selsql);
		
		sqlCommand($insert,$filename,$error, $errordesc1);
	}
	
	
	$ressql->free();
	
	return $num_rows;
	
	
	

}


//RAW EXEC QUERY 

function rawExeQuery($selsql, $filename=false, $show=false){

	global $con;
	
	if($show){
		echo $selsql;
		exit;
	}
	
	$ressql = $con->query($selsql);
				
	if (!$ressql) {
		
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$mailmsg="Raw Exec Query = ".$selsql."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
		
		
		mail("slakshmi@thefirstventure.com", " CorpTnE - MySql Query Failed ", $mailmsg);
		
		$insert=addslashes($selsql);
		
		sqlCommand($insert, $filename, $error, $errordesc1);
		
		//$ressql->free();
		
		return 0;
	
	} else {
			
		return 1;
	
	}
	
	
	

}

// Raw Select all query

function rawSelectAllQuery($selsql, $filename, $show=false){

	global $con;
	
	
	if($show){
		echo $selsql;
		//exit;
	}
	
	$ressql=$con->query($selsql);
	
	$error=0; //query success
			
	if (!$ressql) {
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$error=1; //query failed
	}
	
	if($error)
	{
		
		
		$mailmsg="Select All query = ".$selsql."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
		
		
		mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
		
		
		$insert=addslashes($selsql);
		
		sqlCommand($insert, $filename, $error, $errordesc1);
		
	}	else { 
		
		$temp_arr=array();
		
		while($rowsql=$ressql->fetch_assoc()){
			$temp_array[]=$rowsql;
		}
	
	}
	
	//$ressql->free();
	
	return $temp_array;
	
	

}

function rawSelectQuery($selsql, $filename=false, $show=false){

	global $con;
	
	if($show){
		echo $selsql;
		exit;
	}
	
	$ressql=$con->query($selsql);
	
	
			
	if (!$ressql) {
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$mailmsg="Raw Select Query = ".$selsql."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
		
		
		mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
		
		$insert=addslashes($selsql);
		
		sqlCommand($insert,$filename,$error, $errordesc1);
	}
	
	
	
	$rowsql=$ressql->fetch_assoc();	
	
	//$ressql->free();
	
	return $rowsql;
	
	
	

}



function insert_query($table_name, $field_name, $variables, $filename, $show=false){

	global $con;
	
	$insert="INSERT INTO $table_name ($field_name) VALUES ($variables)";
	
	if($show){
		echo $insert;exit;
	}
	
	//echo $insert; exit;
	$result=$con->query($insert);
	
	$lastid=$con->insert_id;
	
	$error=0; //query success
		
		if (!$result) {
		
			$errordesc=$con->error; //error desc
			$errordesc1=addslashes($errordesc);
			
			$error=1; //query failed
		}
		
		if($error)
		{
			
			$mailmsg="Insert query = ".$insert."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
			
			$insert=addslashes($insert);
			
			sqlCommand($insert, $filename, $error, $errordesc1);
		}
		
		
		//$result->free();
		
		return $lastid;
		
		
		

}

function select_query($table_name, $field_name, $condition=false, $filename=false, $show=false){

	global $con;
	
	if($condition)
	$selsql="SELECT $field_name FROM $table_name WHERE $condition";
	else
	$selsql="SELECT $field_name FROM $table_name";
	
	if($show){
		echo $selsql;
		exit;
	}
	
	$ressql=$con->query($selsql);
	$rowsql=$ressql->fetch_assoc();
	
	$error=0; //query success
			
	if (!$ressql) {
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$error=1; //query failed
	}
	
	if($error){
		
		$mailmsg="Select query = ".$selsql."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
		
		
		mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
		
		$insert=addslashes($selsql);
		
		sqlCommand($insert,$filename,$error, $errordesc1);
	}
	
	//$ressql->free();
	
	return $rowsql;
	
	
	

}


function select_all($table_name, $field_name, $condition=false, $filename, $show=false){

	global $con;
	
	if($condition)
	$selsql="SELECT $field_name FROM $table_name WHERE $condition";
	else
	$selsql="SELECT $field_name FROM $table_name";	
	
	
	if($show){
		echo $selsql;
		//exit;
	}
	
	$ressql=$con->query($selsql);
	
	$error=0; //query success
			
	if (!$ressql) {
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$error=1; //query failed
	}
	
	if($error)
	{
		
		
		$mailmsg="Select All query = ".$selsql."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
		
		
		mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
		
		
		$insert=addslashes($selsql);
		
		sqlCommand($insert, $filename, $error, $errordesc1);
		
	}	else { 
		
		$temp_arr=array();
		
		while($rowsql=$ressql->fetch_assoc()){
			$temp_array[]=$rowsql;
		}
	
	}
	
	//$ressql->free();
	
	return $temp_array;
	
	

}


function update_query($table_name, $field_name, $condition=false, $filename, $show=false){

	global $con;
	
	if($condition)
	$update="UPDATE $table_name SET $field_name WHERE $condition ";
	else
	$update="UPDATE $table_name SET $field_name";
	
	if($show){
		echo $update;
		exit;
	}
	
	$result=$con->query($update);
	
	$error=0; //query success
	
	
		
		if (!$result) {
		
			$errordesc=$con->error; //error desc
			$errordesc1=addslashes($errordesc);
			
			$error=1; //query failed
		}
		
		//echo "Status=".$error;
		
		if($error){
		
			
			
			$mailmsg="Update query = ".$update."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
			
			
			$update=addslashes($update);
			
			sqlCommand($update,$filename,$error, $errordesc1);
			
		}
		
		
		//$result->free();
		
		if($error){
			return 0;
		}else{
			return 1;
		}
		
		
		

}

function delete_query($table_name,$condition,$filename){

	global $con;


	$delete="DELETE FROM $table_name WHERE $condition";
	$result=$con->query($delete);
	
	$error=0; //query success
		
		if (!$result) {
		
			$errordesc=$con->error; //error desc
			$errordesc1=addslashes($errordesc);
			
			$error=1; //query failed
		}
		if($error)
		{
			
			
			$mailmsg="Delete query = ".$delete."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
			
			
			$delete=addslashes($delete);
			
			sqlCommand($delete,$filename,$error, $errordesc1);
		}
		
		//$result->free();
	
}

function max_query($table_name,$fieldname,$condition=false,$filename){

	global $con;
	
	$selmax="SELECT MAX($fieldname) AS maxid FROM $table_name $condition";
	
	$resmax=$con->query($selmax);
	$rowmax=$resmax->fetch_assoc();
	
	$error=0; //query success
	
	if (!$resmax){
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$error=1; //query failed
	}
	
	if($error){
	
		
		
		$mailmsg="Max query = ".$selmax."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
			
			$selmax=addslashes($selmax);
		
		sqlCommand($selmax,$filename,$error, $errordesc1);
	}
	
	
	//$resmax->free();
	
	return $maxid[maxid];
	
	
	

}




/*///////////////////////////////////////////////
               COUNT QUERY 
//////////////////////////////////////////////*/
function count_query($table_name,$fieldname,$condition,$filename, $show=false){

	global $con;
	
	$selcount="SELECT COUNT($fieldname) AS cnt FROM $table_name $condition";
	if($show){
		echo $selcount; exit;
	}
	$rescount=$con->query($selcount);
	$rowcount=$rescount->fetch_assoc();
	
	$error=0;
	if (!$rescount) {
	
		$errordesc=$con->error; //error desc
		$errordesc1=addslashes($errordesc);
		
		$error=1; //query failed
	}
	if($error==1)
	{
		
		
		$mailmsg="Count query = ".$selcount."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("slakshmi@thefirstventure.com", "query failed", $mailmsg);
			
			
			$delete=addslashes($selcount);
		
		sqlCommand($selcount,$filename,$error, $errordesc1);
	}
		
		
		//$rescount->free();
		
		
		
		if(!$error)
		return $rowcount['cnt'];
		
		
		

}

/*///////////////////////////////////////////////
              SUM QUERY
//////////////////////////////////////////////*/

function sum_query($table, $field, $condition, $filename, $show=false){

	global $con;
	
	$query="SELECT SUM($field) AS total FROM $table WHERE $condition ";
	
	if($show){
		echo $query; exit;
	}
	
	$result=$con->query($query);
	
	$error=0; //query success
		
		if (!$result) {
		
			$errordesc=$con->error; //error desc
			$errordesc1=addslashes($errordesc);
			
			$error=1; //query failed
		}
		if($error)
		{
			
			
			$mailmsg="Sum query = ".$query."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("rahul@thefirstventure.com", "query failed", $mailmsg);
			
			$delete=addslashes($delete);
			
			sqlCommand($query,$filename,$error, $errordesc1);
			
		}

	$row=$result->fetch_assoc();
	
	
	//$result->free();
		
	return $row['total'];
	
	
}

function distinct_query($table_name,$field_name,$condition,$filename){

global $con;
	
	$seldistinct="SELECT DISTINCT($field_name) AS fieldcontent FROM $table_name WHERE $condition";
	$result=$con->query($seldistinct);
	$row=$result->fetch_assoc();
		
	$error=0; //query success
		
		if (!$result) {
		
			$errordesc=$con->error; //error desc
			$errordesc1=addslashes($errordesc);
			
			$error=1; //query failed
		}
		
		if($error)
		{
			
			
			$mailmsg="Distinct query = ".$seldistinct."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
			
			
			mail("rahul@thefirstventure.com", "Query Failed", $mailmsg);
			
			
			$seldistinct=addslashes($seldistinct);
			
			sqlCommand($seldistinct,$filename,$error, $errordesc1);
		}
		
		
		//$result->free();
		
		return $row['fieldcontent'];
		
		

}



function sqlCommand($query, $filename, $error, $errordesc){

	global $con;
	
	
	if($_SERVER['HTTP_HOST']=='localhost')
	{
	
		echo 'Failed Query='.$query."<br><br>";
		
		echo 'Filename='.$filename."<br>";
		
		echo 'Error='.$errordesc;
		
		exit;
	 
	 }

	//INSERT INTO SQL_COMMAND
	$sqlquery=insert_query("sql_commands","SC_Query, SC_Filename, SC_Result, SC_Errordescription","'$query','$filename', $error, '$errordesc'",$filename);
	//echo $sqlquery;
	$con->query($sqlquery);

}


// TOTAL BOOKING CANCELLATION REQUEST COUNT. ONLY USED IN TRAVEL AGENT, NON CORPTNE USER. THIS IS INCLUDING REMOVED REQUEST COUNT ALSO

function getCountRequests($type, $compid) {
					
					
	switch ($type) {

		case 1:
			$q = 'AND bs.BS_Status=1 AND bs.BA_Id=1';
			break;
	
		case 2:
			$q = 'AND bs.BS_Status=3 AND bs.BA_Id=1';
			break;
	
		case 3:
			$q = 'AND bs.BS_Status=1';
			break;
	
		case 4:
			$q = 'AND bs.BS_Status=3';
			break;
	}

	global $filename;

	//global $compid;

	$sel = select_all("requests req, request_details rd, booking_status bs", "DISTINCT(req.REQ_Id), req.*", "req.COM_Id='$compid' $q AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND BS_Active=1 ORDER BY bs.BS_Id DESC", $filename, 0);
	
	
	

	return count($sel);
}


function escapeStr($val){
	
	
	global $con;
	
	return $con->real_escape_string($val);

}





function ihvdelegated($n){

	global $empuserid;
	global $filename;
	
	global $con;
		
	$curdate=date('Y-m-d');
	
	if($n==1){
		
		$seldeleg=count_query("delegate", "*","WHERE DLG_FromEmpid='$empuserid' AND DLG_ToDate > '$curdate' AND DLG_Status=1 AND DLG_Active=1", $filename);
	
	} else if($n==2) {
			
		$seldeleg="SELECT * FROM delegate delg, employees emp WHERE delg.DLG_ToEmpid='$empuserid' AND delg.DLG_FromEmpid = emp.EMP_Id AND DLG_ToDate > '$curdate' AND DLG_Status=1 AND DLG_Active=1";
		$resql=$con->query($seldeleg);
		$seldeleg = array();
		while($rowsl=$resql->fetch_assoc()){
		
		//$seldeleg[]=array("empcode" => $rowsl['EMP_Code']);
		$seldeleg[] =$rowsl;
		}
		
	}
	
	return $seldeleg;
	
	
	$resql->free();
}

function generateRandomString($length = 7)
{
    return substr(sha1(rand()), 0, $length);
} 

/*/////////////////////////////////////////
 			TRAVEL EXPENSE TYPES  
/////////////////////////////////////////*/

function getTnetype($n)
{
	$tnetype=select_query("request_type","*","RT_Id='$n'",$filename);
	
	return $tnetype['RT_Requestcode'];
}

/*////////////////////////////////////
		 GENERATE REQUEST IDS 
///////////////////////////////////*/

function genExpreqcode($n, $f=false){

	global $compid; global $filename;
	
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
	
	$code=select_query("code", "*", NULL, $filename);
	
	
	if($tnetype)	
	$requestcode=$tnetype.$compid.$m.$y.$code[code];
	else
	$requestcode=$compid.$m.$y.$code[code];
	
	update_query("code", "code=code+1", NULL, $filename, 0);
	
	return $requestcode;

}



/*/////////////////////////////////////////////
               STRING TO UPPERCASE  
//////////////////////////////////////////////////*/

function uppercaseWords($string){

	$string=ucwords(strtolower($string));
	return $string;
}


/*/////////////////////////////////////////////
               REMOVE QUOTES       
//////////////////////////////////////////////*/

function removeQuotes($string){

$a=array("'", '"');

$replaced = str_replace($a,"", $string);

return $replaced;
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9.\-]/', '', $string); // Removes special chars.
}




// CLAIM APPROVAL STATUS

function tdclaimapprovals($string){

	switch($string)
	{
		
		case 1:
		$getapprov='<span class="label label-warning">Pending</span>';
		break;
		
		case 2:
		$getapprov='<span class="label label-success">Approved</span>';
		break;
		
		case 3:
		$getapprov='<span class="label label-danger">Rejected</span>';
		break;
		
		case 4:
		$getapprov='<span class="label label-default">N/A</span>';
		break;
	
	}
	
	return $getapprov;
}

/*//////////////////////////////////////////////////
               APPROVALS        
///////////////////////////////////////////////////*/

function approvals($string){

switch($string)
{
	case 1:
	$getapprov='<span class="label label-warning">Pending</span>';
	break;
	
	case 2:
	$getapprov='<span class="label label-success">Settled</span>';
	break;
	
	case 3:
	$getapprov='<span class="label label-theme-inverse">Skip Level</span>';
	break;
	
	case 4:
	$getapprov='<span class="label label-danger">Rejected</span>';
	break;
	
	case 5:
	$getapprov='<span class="label label-default">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
	break;
	
	/*case 6:
	$getapprov='<span class="label label-info">Claimed</span>';
	break;*/
	
	case 9:
	$getapprov='<span class="label label-danger">Rejected</span>';
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
	$getapprov='<span class="label label-warning">Pending</span>';
	break;
	
	case 2:
	$getapprov='<span class="label label-success">Booked</span>';
	break;
	
	case 3:
	$getapprov='<span class="label label-info">Failed</span>';
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
	$getapprov='<span class="label label-danger">Cancelled</span>';
	break;
	
	
	default:
	$getapprov='<span class="label label-default">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
	
}

return $getapprov;


}

/*////////////////////////////////////////////////////
              GET COMPANY POLICY TYPE       
////////////////////////////////////////////////////*/

function compPolicy($compid){

	//global $filename;
	
	$filename="header.php";
	
	$selpolicy=select_query("company","COM_Pretrv_POL_Id, COM_Posttrv_POL_Id, COM_Othertrv_POL_Id, COM_Mileage_POL_Id, COM_Utility_POL_Id","COM_Id='$compid'",$filename);
	
	return $selpolicy;

}


function generateFilesFolders($dir){

	if(!file_exists($dir))
	{
		mkdir($dir, 0777, true);
	}
	
	if(!file_exists($dir.'/index.html'))
	{
		fopen($dir.'/index.html', "w");
	}

}


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



/////////////////////////////////////////////
// 			Grade Limit amount 
/////////////////////////////////////////////

function getGradeLimit($modeid, $empuserid, $filename)
{
	
	if($selgrmlimit=select_query("employees emp, grade_limits gl"," gl.* ","emp.EMP_Id='$empuserid' AND emp.EG_Id=gl.EG_Id AND gl.GL_Status=1 ORDER BY gl.GL_Id ASC", $filename, 0))
	{
			
		$selgrdLim=array_values($selgrmlimit);
		
		if($modeid)
		{
		
			$selall=select_all("`mode`", "MOD_Id, MOD_Name", "COM_Id = 0 and MOD_Status=1 ORDER BY MOD_Id ASC", $filename, $show=false);
			
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


//EMPLOYEE DETAILS

function myDetails($empid=NULL)
{
	global $empuserid;
	
	if(!$empid)
	$empid=$empuserid;
	
	 global $compid; global $filename;
	
	$mydetails=select_query("employees","*","EMP_Id='$empid' AND COM_Id='$compid' AND EMP_Status=1",$filename);
	
	return $mydetails;
}

// MY COMPANY DETAILS


function companyDetails($column="*", $compid=false)
{
	global $empuserid; 
	
	if(!$compid) global $compid; 
	
	global $filename;
	
	//echo $column; exit;
	
	
	$companyDetails=select_query("company", $column, "COM_Id='$compid' AND COM_Status=0", $filename, 0);
	
	return $companyDetails;
}



// im approver or not

function isApprover()
{
	global $empuserid; global $compid; global $filename;
	
	$mydetails	=	myDetails();
	
	$selrow=select_query("employees","*","EMP_Funcrepmngrcode='$mydetails[EMP_Code]' OR EMP_Reprtnmngrcode='$mydetails[EMP_Code]' AND EMP_Status=1",$filename);
	
	return $selrow;

}


/*
	GET QUOTE

*/

function getFlightLogo($fln){
	
	switch ($fln) {
		
		case "IndiGo":
		$airlogoclass="L6E_sm";
		break;
		
		case "SpiceJet":
		$airlogoclass="LSG_sm";
		break;
		
		case "Jet Airways":
		$airlogoclass="L9W_sm";
		break;
		
		case "Air India":
		$airlogoclass="LAI_sm";
		break;
		
		case "Air Vistara":
		$airlogoclass="LUK_sm";
		break;
		
		case "GoAir":
		$airlogoclass="LG8-s";
		break;
		
		case "Air Asia":
		$airlogoclass="LI5_sm";
		break;
		
		case "Bus":
		$airlogoclass="LM_bus";
		break;
		
		default:
		$airlogoclass="LMA_sm";
			
	}
	
	return  $airlogoclass;
}

$protocol = 'http'.(!empty($_SERVER['HTTPS']) ? 's:' : ':');

$hostUrl = $protocol.'//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);


function uploadImage($name,$size,$type,$temp,$uploadDir)
{
	
	
	//exit;
	if ($size > 4096000) 
	{
		echo "<script language = 'javascript'>
		alert('The photo size is too large, Please upload file less than 2 MB')
		</script>";
	}
/*	elseif ($_FILES[$inputName]['type'] == "image/png") 
	{
		echo "<script language = 'javascript'>
		alert('The photo type(png) is not supported for upload')
		window.location.href = 'images-add.php' </script>";
	}
*/	else 
	{
		if ($type == "image/gif" || $type == "image/jpg" || $type == "image/pjpeg" || $type == "image/jpeg"){
		$imagePath = '';
		$thumbnailPath = '';
		$thumbnailPath1 = '';
		// if a file is given
		if (trim($temp) != '') 
		{
		//echo strrchr("as.jpg",".");
			$ext = substr(strrchr($name, "."), 1);// echo $ext;
			// generate a random new file name to avoid name conflict
			// then save the image under the new file name
			$imagePath = md5(rand() * time()) . ".$ext";
		
			$result    =createThumbnail($temp, $uploadDir."large/" . $imagePath, 600);// move_uploaded_file($temp, $uploadDir . $imagePath);
			if ($result) 
			{
			$imagePath=$result;
			$_SESSION['flag'] = 1;
			// create thumbnail
			$thumbnailPath1 =  md5(rand() * time()) . ".$ext";
			$thumbnailPath2 =  md5(rand() * time()) . ".$ext";
			$result1 = createThumbnail($temp, $uploadDir."medium/" . $thumbnailPath1, 150);
			$result2 = createThumbnail($temp, $uploadDir."small/" . $thumbnailPath2, 75);
			// create thumbnail failed, delete the image
				if (!$result1 && !$result2 ) 
				{
					unlink($uploadDir."large/" . $imagePath);
					unlink($uploadDir."medium/" . $thumbnailPath1);
					unlink($uploadDir ."small/" . $thumbnailPath2);
					$imagePath = $thumbnailPath1 =$thumbnailPath2= '';
				} 
				else 
				{
					$thumbnailPath1 = $result1;
					$thumbnailPath2 = $result2;
				}	
			} 
			else 
			{
				// the image cannot be uploaded
				$_SESSION['flag'] = 0;
				echo "<script language = 'javascript'>
		alert('The photo cannot be uploaded') </script>";
			}
			}
			//echo $imagePath."   " .$thumbnailPath1."  ".$thumbnailPath2;
		return array('large' => $imagePath, 'medium' => $thumbnailPath1 , 'small' => $thumbnailPath2);
		}
	}
	
}
/*
	Create a thumbnail of $srcFile and save it to $destFile.
	The thumbnail will be $width pixels.
*/
function createThumbnail($srcFile, $destFile, $width, $quality = 75)
{
	$thumbnail = '';
	
	if (file_exists($srcFile)  && isset($destFile))
	{
		$size        = getimagesize($srcFile);
		$w           = number_format($width, 0, ',', '');
		$h           = number_format(($size[1] / $size[0]) * $width, 0, ',', '');
		
		
		$thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
	}
	
	// return the thumbnail file name on success or blank on fail
	return basename($thumbnail);
}
function copyImage($srcFile, $destFile, $w, $h, $quality = 75)
{
    $tmpSrc     = pathinfo(strtolower($srcFile));
    $tmpDest    = pathinfo(strtolower($destFile));
    $size       = getimagesize($srcFile);

    if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg")
    {
	
       $destFile  = substr_replace($destFile, 'jpg', -3);
       $dest      = imagecreatetruecolor($w, $h);
       //imageantialias($dest, TRUE);
    } 
	elseif ($tmpDest['extension'] == "jpeg")
	{
		$dest = imagecreatetruecolor($w, $h);
	}
	elseif ($tmpDest['extension'] == "png") 
	{
       $dest = imagecreatetruecolor($w, $h);
       //imageantialias($dest, TRUE);
    }
	else
	{
      return false;
    }
    switch($size[2])
    {
       case 1:       //GIF
           $src = imagecreatefromgif($srcFile);
           break;
       case 2:       //JPEG
           $src = imagecreatefromjpeg($srcFile);
           break;
       case 3:       //PNG
           $src = imagecreatefrompng($srcFile);
           break;
       default:
           return false;
           break;
    }
    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
    switch($size[2])
    {
       case 1:
       case 2:
           imagejpeg($dest,$destFile, $quality);
           break;
       case 3:
           imagepng($dest,$destFile);
    }
    return $destFile;
}


/** 
*  Function:   convert_number 
*
*  Description: 
*  Converts a given integer (in range [0..1T-1], inclusive) into 
*  alphabetical format ("one", "two", etc.)
*
*  @int
*
*  @return string
*
*/ 
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 


// markup checked

function maxlengthMarkValue($mcid){
										
	$maxlength=null;
	
	switch($mcid){
	
		case 1:
		$maxlength='4';
		break;
		
		case 2:
		$maxlength='3';
		break;
		
		default:
		$maxlength='3';
	}
	
	return $maxlength;

}


// GET MARK UP/DOWN CALCULATION	


function getMarkFare($markstatus, $mcid, $fare, $price){
	
	$amnt = null;
	
	//echo $markstatus.'-'.$mcid.'-'.$fare.'-'.$price; exit;
	
	switch($markstatus){
						
		case 1: {// mark up
						
			switch($mcid){
				case 1:{ //absolute amount
					$amnt = $price + $fare;
				break;
				}
				
				case 2:{ // percentage 
					$amnt = $price + ( (($price * $fare)/100) );
				break;
				}
			}
			
			
		break;
		}
		
		
		case 2:{ // mark down
						
			switch($mcid){
				case 1:{ //absolute amount
					$amnt = $price - $fare;
				break;
				}
				
				case 2:{ // percentage 
					$amnt = $price - ( (($price * $fare)/100) );
				break;
				}
			}
			
		break;
		}
		
	}
	
	
	return $amnt; 

}



function commaSep_QuotesSep($string) {
    return "['". implode("','", explode(',', $string)) ."']";
}

function dateConversion($string){
	
	if($string){
	
		return implode("-", array_reverse(explode("/", $string)));
	}

}

function removedByClient(){

	return '<br><span class="text-danger">Removed by Client.</span>';
}


function removedByUser(){

	return '<br><span class="text-danger">Removed by User.</span>';
}


?>