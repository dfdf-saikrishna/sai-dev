<?php
//use WeDevs\ERP\Corptne\includes\Models\Employeelist;
/**
 * Delete an employee if removed from WordPress usre table
 *
 * @param  int  the user id
 *
 * @return void
 */
function traveldeskbankdetails_create( $args = array() ) {
    global $wpdb;

	$tdbaid				=	$_POST['tdbaid'];
	
    $defaults = array(
        'traveldeskbankdetails'        => array(
            'txtFullname'     => '',
            'txtAccnumber'      => '',
            'txtIfsc'     => '',
            'txtBankName'       => '',
            'txtBranchName'     => '',
			'txtIssuedAt' => '',
			'txtAccountType' => '',
			'txtIssuedDate' => '',
	
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );

    // if TDBA_Id exists, do an update
    $TDBA_Id = $data['traveldeskbankdetails']['TDBA_Id'];
    $update  = false;

    if ( $TDBA_Id ) {
        $update = true;
		$traveldeskbankdetails['TDBA_Id'] = $TDBA_Id;
    } 

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    if ( is_wp_error( $TDBA_Id ) ) {
        return $TDBA_Id;
    }
	$tdid = $_SESSION['tdid'];
	$traveldeskbankdetails = array(
        'TDBA_Fullname' => $data['traveldeskbankdetails']['txtFullname'],
        'TDBA_AccountNumber' => $data['traveldeskbankdetails']['txtAccnumber'],
        'TDBA_BankIfscCode'   => $data['traveldeskbankdetails']['txtIfsc'],
        'TDBA_BankName'  => $data['traveldeskbankdetails']['txtBankName'],
        'TDBA_BranchName'   => $data['traveldeskbankdetails']['txtBranchName'],
		'TDBA_IssuedAt'=>$data['traveldeskbankdetails']['txtIssuedAt'],
		'TDBA_AccountType'=>$data['traveldeskbankdetails']['txtAccountType'],
		'TDBA_DateofIssue'=>$data['traveldeskbankdetails']['txtIssuedDate'],
		'TD_Id'=>$tdid,  		
       );
    if($update){
       $tablename = "travel_desk_bank_account";
	   $traveldeskbankdetails['TDBA_Status']='2';
       $traveldeskbankdetails['TDBA_Id'] = $TDBA_Id;
       $update = $wpdb->update( $tablename,$traveldeskbankdetails,array( 'TDBA_Id' => $TDBA_Id ));
	   if($update){
	   $traveldeskbankdetails['TDBA_Id'] ='';
	   $traveldeskbankdetails['TDBA_Status']='1';
	   $wpdb->insert( $tablename,$traveldeskbankdetails);
	   }
    }
    else{ 
    $tablename = "travel_desk_bank_account";
    $wpdb->insert( $tablename, $traveldeskbankdetails);
    return $TDBA_Id;
    }
}				