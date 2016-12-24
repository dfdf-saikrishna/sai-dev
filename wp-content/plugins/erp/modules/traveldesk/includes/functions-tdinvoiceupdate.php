<?php
function traveldeskclaims_update( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'traveldeskclaimsupdate'        => array(
						'hiddenTickets'=>'',
						'totalAmount'=>'',
						'txtAccNo'=>'',
						'txtServiceChrgs'=>'',
						'txtServiceTax'=>'',
						'txtaRemarks'=>'',
						'quantity'=>'',
						)
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
	$data   = erp_parse_args_recursive( $posted, $defaults );
	$tdcid = $_GET['tdcid'];
	$totalAmount		=	trim($posted['totalAmount']);
	$txtaRemarks		=	trim(addslashes($posted['txtaRemarks']));
	$txtServiceTax		=	trim($posted['txtServiceTax']);
	$txtServiceChrgs	=	trim($posted['txtServiceChrgs'])*($posted['hiddenTickets']);
	$quantity			=	$posted['hiddenTickets'];
	$txtAccno			=	$posted['txtAccNo'];
if($txtServiceTax && $txtServiceChrgs)
	$txtServiceTaxamnt=$txtServiceChrgs * ($txtServiceTax / 100);
	$totalAmount+=$txtServiceTaxamnt;
if($txtServiceTax && $txtServiceChrgs)
	$totalAmount=$totalAmount + $txtServiceChrgs;
	$totalAmount=abs($totalAmount);
	$filename	=	$_FILES['filename'];
	
	$imagename	=$_FILES['fileattach']['name'];
	$imtype		=$_FILES['fileattach']['type'];
	$imsize		=$_FILES['fileattach']['size'];
	$tmpname 	=$_FILES['fileattach']['tmp_name'];
	$photoAllowed=0;
	if($imagename)
	{
		$allowedExts 		= 	array("doc", "docx", "pdf"); 
		$allowedMimeTypes 	= 	array("application/msword", 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf');
		$extension 			= 	end(explode('.', $imagename));
		$extension 			= 	strtolower($extension);
		$matchExtns			=	in_array($extension,$allowedExts);
		
		//echo $matchExtns;exit;
		
		if($matchExtns)
		{
			if ( in_array( $imtype, $allowedMimeTypes ) )
			$photoAllowed=0;
			else
			$photoAllowed=1;
			
		}
		else
		{
			$photoAllowed=1;			
		}
	
	}
	//if($photoAllowed)
	//{
		//header("location:$filename?msg=1&reqids=$reqids");
	//	exit;
	//}
//	if($tdcid=="" || $totalAmount==""){
		
		//header("location:$filename?msg=5&reqids=$reqids");
		//exit;
	
	//} else {	
		if($imagename)
		{
		
			$imdir		=	"../company/upload/$compid/bills_tickets/";
				
			$ext 		= 	substr(strrchr($imagename, "."), 1);
			
			$imagePath 	= 	md5(rand() * time()) . ".$ext";
			
			move_uploaded_file($tmpname, $imdir . $imagePath); 
		
		} else {
		$imagePath=$posted['oldimg'];
		}
		$tduserid = $_SESSION['tdid'];
		$tdcid =	$posted['tdcid'];
	$traveldeskclaims_update = array(
		'TD_Id'=> $tduserid, 
		'TDC_Amount'=>$totalAmount, 
		'TDC_ServiceTax'=>$txtServiceTax, 
		'TDC_ServiceCharges'=>$txtServiceChrgs, 
		'TDBA_Id'=>$txtAccno, 
		'TDC_Filename'=>$imagePath, 
		'TDC_Remarks'=>$txtaRemarks, 
		'TDC_Level'=>'1'
	);
	$tablename = "travel_desk_claims";
    $wpdb->update( $tablename, $traveldeskclaims_update,array( 'TDC_Id' => $tdcid ));
//}
}




?>
