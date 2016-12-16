<?php
function travelagentclaims_create( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'travelagentclaims'        => array(
						'hiddenTickets'=>'',
						'reqids'=>'',
						'totalAmount'=>'',
						'txtAccNo'=>'',
						'txtInvoiceNo'=>'',
						'txtServiceChrgs'=>'',
						'txtServiceTax'=>'',
						'txtaRemarks'=>'',
						'quantity'=>'',
						'invoiceNo' => 'INV'.genExpreqcode(),
						'cmpid'=>'',
						)
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
	$data   = erp_parse_args_recursive( $posted, $defaults );
	$supid = $_SESSION['supid'];
	$compid = $_GET['cmpid'];
	$selcompanies = $wpdb->get_results("SELECT COM_Id FROM company WHERE SUP_Id='$supid' AND COM_Id = '$compid' AND COM_Status=0");	
	if (empty($selcompanies)) {
       // header("Location: /wp-content/themes/euro/php/adminpage.php"); 
    }
	
	$reqid = $_GET['id'];
    if ( is_wp_error( $reqid ) ) {
        return $reqid;
    }
	
	$supid = $_SESSION['supid']; 
	$compid = $_REQUEST['cmpid'];
$txtServiceChrgs = trim($posted['txtServiceChrgs']) * ($posted['hiddenTickets']);
	 if ($posted['txtServiceTax'] && $posted['txtServiceChrgs']){
	$txtServiceTaxamnt = $posted['txtServiceChrgs'] * ($posted['txtServiceTax'] / 100);
		$totalAmount+=$txtServiceTaxamnt;
	 }
	  if ($posted['txtServiceTax'] && $posted['txtServiceChrgs']){
			$totalAmount = $totalAmount + $posted['txtServiceChrgs'];
		$totalAmount = abs($totalAmount);
	  }
	$travelagentclaims_data = array(
        'SUP_Id' => $supid,
        'COM_Id' => $_REQUEST['cmpid'],
        'TDC_ReferenceNo'   => 'INV'.genExpreqcode(),
        'TDC_Quantity'  => $posted['hiddenTickets'],
        'TDC_Amount'   => $totalAmount,
		'TDC_ServiceTax'=>$posted['txtServiceTax'],
		'TDC_ServiceCharges'=>$txtServiceChrgs,
		'TDC_InvoiceNo'=>$posted['txtInvoiceNo'],
		'TDBA_Id'=>$posted['txtAccNo'],
		'TDC_Filename'=>'imagepath',
		'TDC_Remarks'=>$posted['txtaRemarks'],
		'TDC_Type'=>'2',
		'TDC_Level'=>'2',
    );
    $tablename = "travel_desk_claims";
    $wpdb->insert( $tablename, $travelagentclaims_data);
	$insertid = $wpdb->insert_id;
	if(!empty($insertid)){
		$reqidarry = explode(",", $posted['reqids']);


            $totalcosts = 0;

            foreach ($reqidarry as $vals) {
                $getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id) FROM request_details rd, booking_status bs WHERE rd.REQ_Id=$vals AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3)  AND BS_Active=1");
                $totalcosts = 0;
                foreach ($getvals as $values) {
                    $countAll = count($wpdb->get_results("SELECT BS_Id FROM booking_status WHERE RD_Id='$values->RD_Id' AND BS_Active=1"));


                    if ($countAll == 2) {

                        if ($rowcn = $wpdb->get_results("SELECT BA_Id, BS_CancellationAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=3 AND BS_Active=1")) {

                            if ($rowcn[0]->BA_Id== 4 || $rowcn[0]->BA_Id == 6) {

                                $totalcosts += $rowcn[0]->BS_CancellationAmnt;
                            }
                        } else {

                            $rowbk = $wpdb->get_results("SELECTT BS_TicketAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=1 AND BS_Active=1");

                            $totalcosts += $rowbk[0]->BS_TicketAmnt;
                        }
                    } else {

                        $rowbk = $wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=1 AND BS_Active=1");

                        $totalcosts += $rowbk[0]->BS_TicketAmnt;
                    }
                }

                $qty = count($getvals);

		$travel_desk_claim_requests_data = array(
        'TDC_Id' => $insertid,
        'REQ_Id' => $vals,
        'TDCR_Quantity'   => $qty,
        'TDCR_Amount'  => $totalcosts,
			);
         $wpdb->insert("travel_desk_claim_requests",$travel_desk_claim_requests_data);
       }
	}
}
function companyDetails($column="*", $cmpid=false)
{
	global $wpdb;
	if(!$cmpid) global $cmpid; 
	
	$companyDetails=$wpdb->get_results("SELECT $column FROM company WHERE COM_Id='$cmpid' AND COM_Status=0");
	
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
