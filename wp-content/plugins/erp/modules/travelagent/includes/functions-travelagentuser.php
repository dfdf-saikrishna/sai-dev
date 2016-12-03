<?php
//use WeDevs\ERP\Corptne\includes\Models\Employeelist;
/**
 * Delete an employee if removed from WordPress usre table
 *
 * @param  int  the user id
 *
 * @return void
 */
function travelagentuser_create( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'travelagentuser'        => array(
            'user_id'         => 0,
            'txtUsername'     => '',
            'txtAgencyName'      => '',
            'txtAgencyCode'     => '',
            'txtAgentName'       => '',
            'txtEmail'     => '',
            'txtPhn'           => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
	
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );

    // attempt to create the user
    $userdata = array(
        'user_login'   => $data['travelagentuser']['txtEmail'],
        'user_email'   => $data['travelagentuser']['txtEmail'],
        'first_name'   => $data['travelagentuser']['txtUsername'],
        'last_name'    => $data['travelagentuser']['txtUsername'],
        'user_url'     => $data['travelagentuser']['user_url'],
        'display_name' => $data['travelagentuser']['txtUsername'],
        );

    // if user id exists, do an update
    $user_id = isset( $data['travelagentuser']['user_id'] ) ? intval( $data['travelagentuser']['user_id'] ) : 0;
    $update  = false;

    if ( $user_id ) {
        $update = true;
        $userdata['ID'] = $user_id;

    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password( 12 );
        $userdata['role'] = 'travelagentuser';
    }

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
	
	$supid = $_SESSION['supid']; 
	$travelagentuser_data = array(
        'user_id' => $user_id,
        'SUP_Username' => $data['travelagentuser']['txtUsername'],
        'SUP_AgencyName' => $data['travelagentuser']['txtAgencyName'],
        'SUP_Name'   => $data['travelagentuser']['txtAgentName'],
        'SUP_Email'  => $data['travelagentuser']['txtEmail'],
        'SUP_Contact'   => $data['travelagentuser']['txtPhn'],
		'SUP_Address'=>$data['travelagentuser']['txtaAddress'],
		'SUP_Type'=>'4',
        'SUP_Refid' => $supid,
        'SUP_AgencyCode'  => $data['travelagentuser']['txtAgencyCode'],
    );
    if($update){
       $tablename = "superadmin";
       $travelagentuser_data['user_id'] = $user_id;
       $wpdb->update( $tablename,$travelagentuser_data,array( 'user_id' => $user_id ));    
    }
    else{ 
    $user_id  = wp_insert_user( $userdata );
    $tablename = "superadmin";
    $travelagentuser_data['user_id'] = $user_id;
    $wpdb->insert( $tablename, $travelagentuser_data);
    return $user_id;
    }
}				