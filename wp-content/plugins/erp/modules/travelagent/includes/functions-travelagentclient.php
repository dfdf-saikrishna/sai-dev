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
			'txtComTrvDeskUsername' => '',
			'selCT' => '',
			'selFlightTerms' => '',
			'radioFlightMarkStatus' => '',
			'txtFlightMarkFare' => '',
			'selBusTerms' => '',
			'radioBusMarkStatus' => '',
			'txtBusMarkFare' => '',
			'selHotelTerms' => '',
			'radioHotelMarkStatus' => '',
			'txtHotelMarkFare' => '',
			'selTrvAgntUser' => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );

    // attempt to create the user
    $userdata = array(
        'user_login'   => $data['travelagentclient']['txtEmail'],
        'user_email'   => $data['travelagentclient']['txtEmail'],
        'first_name'   => $data['travelagentclient']['txtUsername'],
        'last_name'    => $data['travelagentclient']['txtUsername'],
        'user_url'     => $data['travelagentclient']['user_url'],
        'display_name' => $data['travelagentclient']['txtUsername'],
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

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
	
	$supid = $_SESSION['supid']; 
	$travelagentclient_data = array(
        'user_id' => $user_id,
        'SUP_Username' => $data['travelagentclient']['txtUsername'],
        'SUP_AgencyName' => $data['travelagentclient']['txtAgencyName'],
        'SUP_Name'   => $data['travelagentclient']['txtAgentName'],
        'SUP_Email'  => $data['travelagentclient']['txtEmail'],
        'SUP_Contact'   => $data['travelagentclient']['txtPhn'],
		'SUP_Address'=>$data['travelagentclient']['txtaAddress'],
		'SUP_Type'=>'4',
        'SUP_Refid' => $supid,
        'SUP_AgencyCode'  => $data['travelagentclient']['txtAgencyCode'],
    );
    if($update){
       $tablename = "superadmin";
       $travelagentclient_data['user_id'] = $user_id;
       $wpdb->update( $tablename,$travelagentclient_data,array( 'user_id' => $user_id ));    
    }
    else{ 
    $user_id  = wp_insert_user( $userdata );
    $tablename = "superadmin";
    $travelagentclient_data['user_id'] = $user_id;
    $wpdb->insert( $tablename, $travelagentclient_data);
    return $user_id;
    }
}				