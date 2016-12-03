<?php
//use WeDevs\ERP\Corptne\includes\Models\Employeelist;
/**
 * Delete an employee if removed from WordPress usre table
 *
 * @param  int  the user id
 *
 * @return void
 */
function travelagentclient_create( $args = array() ) {
     global $wpdb;
    $defaults = array(
        'travelagentclient'        => array(
            'user_id'         => 0,
            'txtCompname' => '',
			'txtEmpCodePrefx' => '',
			'txtCompemail' => '',
			'txtCompmob' => '',
			'txtComplandline' => '',
			'txtaCompaddr' => '',
			'txtCompoloc' => '',
			'txtCompcity' => '',
			'txtCompstate' => '',
			'txtCompcntp1name' => '',
			'txtCompcntp1email' => '',
			'txtCompcntp1mob' => '',
			'txtCompcntp2name' => '',
			'txtCompcntp2email' => '',
			'txtCompcntp2mob' => '',
			'txtSalespersname' => '',
			'txtSalesperemail' => '',
			'txtSalespercontno' => '',
			'txtadescdeal' => '',
			'selCT' => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );

    // attempt to create the user
    $userdata = array(
        'user_login'   => $data['travelagentclient']['txtCompemail'],
        'user_email'   => $data['travelagentclient']['txtCompemail'],
        'first_name'   => $data['travelagentclient']['txtCompname'],
        'last_name'    => $data['travelagentclient']['txtCompname'],
        'user_url'     => $data['travelagentclient']['user_url'],
        'display_name' => $data['travelagentclient']['txtCompname'],
        );

    // if user id exists, do an update
    $user_id = isset( $data['travelagentclient']['user_id'] ) ? intval( $data['travelagentclient']['user_id'] ) : 0;
    $update  = false;

    if ( $user_id ) {
        $update = true;
        $userdata['ID'] = $user_id;

    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password( 12 );
        $userdata['role'] = 'travelagentclient';
    }

    $userdata = apply_filters( 'erp_hr_travelagentclient_args', $userdata );
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
	
	$supid = $_SESSION['supid']; 
	$travelagentclient_data = array(
	'Name'=>'fghfgh',
        'COM_Name' =>$data['travelagentclient']['txtCompname'],
		'COMp_Prefix' =>$data['travelagentclient']['txtEmpCodePrefx'],
		'COM_Email' =>$data['travelagentclient']['txtCompemail'],
		'COM_Mobile' =>$data['travelagentclient']['txtCompmob'],
		'COM_Landline' =>$data['travelagentclient'][ 'txtComplandline'],
		'COM_Address' =>$data['travelagentclient']['txtaCompaddr'],
		'COM_Location' =>$data['travelagentclient']['txtCompoloc'],
		'COM_City' =>$data['travelagentclient']['txtCompcity'],
		'COM_State' =>$data['travelagentclient']['txtCompstate'],
		'COM_Cp1username' =>$data['travelagentclient']['txtCompcntp1name'],
		'COM_Cp1email' =>$data['travelagentclient']['txtCompcntp1email'],
		'COM_Cp1mobile' =>$data['travelagentclient']['txtCompcntp1mob'],
		'COM_Cp2username' =>$data['travelagentclient']['txtCompcntp2name'],
		'COM_Cp2email' =>$data['travelagentclient']['txtCompcntp2email'],
		'COM_Cp2mobile' =>$data['travelagentclient']['txtCompcntp2mob'],
		'COM_Spname' =>$data['travelagentclient']['txtSalespersname'],
		'COM_Spemail' =>$data['travelagentclient']['txtSalesperemail'],
		'COM_Spcontactno' =>$data['travelagentclient']['txtSalespercontno'],
		'COM_Descdeal' =>$data['travelagentclient']['txtadescdeal'],
		'SUP_Id'=>$supid,
		'CT_Id' =>$data['travelagentclient']['selCT'],
		'COM_Flight'=>'1',
		'COM_Bus'=>'1',
		'COM_Hotel'=>'1',
		'COM_Logo'=>'url',
    );
    if($update){
       $tablename = "company";
       $travelagentclient_data['user_id'] = $user_id;
       $wpdb->update( $tablename,$travelagentclient_data,array( 'user_id' => $user_id ));    
    }
    else{ 
    $user_id  = wp_insert_user( $userdata );
	$tablename = "company";
	$travelagentclient_data['user_id'] = $user_id;	
	$wpdb->insert( $tablename, $travelagentclient_data);	
    return $user_id;
    }
	return $travelagentclient_data;
}	
function get_markupdown_list(){
	global $wpdb;
	$markupdownlist = $wpdb->get_results( "SELECT * FROM markupdown_category");
	return $markupdownlist;
	}	

function get_bankaccount_list(){
	global $wpdb;
	$supid = $_SESSION['supid']; 
	$bankaccountlist = $wpdb->get_results("SELECT * FROM travel_desk_bank_account WHERE SUP_Id = $supid AND TDBA_Type = 2 AND TDBA_Status = 1");
	return $bankaccountlist;
	}

function get_allocation_list(){
	global $wpdb;
	$supid = $_SESSION['supid']; 
	$allocationlist = $wpdb->get_results("SELECT  sup.SUP_Id, sup.SUP_Name, sup.SUP_Username FROM superadmin sup WHERE
					  sup.SUP_Refid = $supid AND SUP_Status = 1 AND SUP_Type = 4 AND SUP_Access = 1 ORDER BY SUP_Name");
	return $allocationlist;
	}	