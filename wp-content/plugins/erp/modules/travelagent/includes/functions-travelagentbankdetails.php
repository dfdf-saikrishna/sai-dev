<?php
//use WeDevs\ERP\Corptne\includes\Models\Employeelist;
/**
 * Delete an employee if removed from WordPress usre table
 *
 * @param  int  the user id
 *
 * @return void
 */
function travelagentbankdetails_create( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'travelagentbankdetails'        => array(
            'txtFullname'     => '',
            'txtAccnumber'      => '',
            'txtIfsc'     => '',
            'txtBankName'       => '',
            'txtBranchName'     => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );

    // if TDBA_Id exists, do an update
    $TDBA_Id = $data['travelagentbankdetails']['TDBA_Id'];
    $update  = false;

    if ( $TDBA_Id ) {
        $update = true;
		$travelagentbankdetails_data['TDBA_Id'] = $TDBA_Id;
    } 

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    if ( is_wp_error( $TDBA_Id ) ) {
        return $TDBA_Id;
    }
	
	$supid = $_SESSION['supid']; 
	$travelagentbankdetails_data = array(
        'TDBA_Fullname' => $data['travelagentbankdetails']['txtFullname'],
        'TDBA_AccountNumber' => $data['travelagentbankdetails']['txtAccnumber'],
        'TDBA_BankIfscCode'   => $data['travelagentbankdetails']['txtIfsc'],
        'TDBA_BankName'  => $data['travelagentbankdetails']['txtBankName'],
        'TDBA_BranchName'   => $data['travelagentbankdetails']['txtBranchName'],
		'TDBA_Type'=>'2',
        'SUP_Id' => $supid,
    );
    if($update){
       $tablename = "travel_desk_bank_account";
	   //$travelagentbankdetails_data['TDBA_Status']='2';
	   //$travelagentbankdetails_data['TDBA_UpdatedDate'];	 
       $travelagentbankdetails_data['TDBA_Id'] = $TDBA_Id;
       $wpdb->update( $tablename,$travelagentbankdetails_data,array( 'TDBA_Id' => $TDBA_Id ));    
    }
    else{ 
    $tablename = "travel_desk_bank_account";
    $wpdb->insert( $tablename, $travelagentbankdetails_data);
    return $TDBA_Id;
    }
}				