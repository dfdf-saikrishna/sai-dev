<?php
// MY COMPANY DETAILS


function companyDetails($column="*", $compid=false)
{
	global $empuserid; 
	
	if(!$compid) global $compid; 
	
	global $filename;
	
	//echo $column; exit;
	
	$companyDetails=select_query("SELECT $column FROM company WHERE COM_Id='$compid' AND COM_Status=0");
	
	return $companyDetails;
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
		
		
		mail("rahul@thefirstventure.com", "query failed", $mailmsg);
		
		
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


?>
