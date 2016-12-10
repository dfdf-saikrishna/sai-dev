<?php
//INDIAN MONEY FORMAT

function IND_money_format1($money){
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

function companyDetails($column="*", $cmpid=false)
{
	global $empuserid; 
	
	if(!$cmpid) global $cmpid; 
	
	global $filename;
	
	//echo $column; exit;
	
	
	$companyDetails=select_query("company", $column, "COM_Id='$cmpid' AND COM_Status=0", $filename, 0);
	
	return $companyDetails;
}

/*
 * [erp_hr_url_single_companyview description]
 *
 * @param  int  company id
 *
 * @return string  url of the companyview details page
 */
function erp_invoicedetails_url_single_view($tdcid,$cmpid) {	
    $url = admin_url( 'admin.php?page=ViewInvoice&action=view&tdcid=' . $tdcid.'&cmpid='.$cmpid);

    return apply_filters( 'erp_invoicedetails_url_single_view', $url, $tdcid,$cmpid);
}

function bank_details($TDBA_Id=false)
{
	if(!$TDBA_Id) global $TDBA_Id; 
	
	//echo $column; exit;
				  
	$bank_details=select_query("travel_desk_bank_account", "TDBA_AccountNumber", "TDBA_Id='$TDBA_Id'");
	
	return $bank_details;
}
function rawSelectAllQuery($selsql, $filename, $show=false){

	global $con;	
	global $wpdb;
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
