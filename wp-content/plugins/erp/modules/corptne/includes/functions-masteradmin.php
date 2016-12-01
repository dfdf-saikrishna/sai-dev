<?php
/**
 * Create a new employee
 *
 * @param  array  arguments
 *
 * @return int  employee id
 */
function masteradmin_create( $args = array() ) {
    global $wpdb;
    $defaults = array(
        'masteradmin'        => array(
            'user_id'         => 0,
            'txtUsername'     => '',
            'txtName'      => '',
            'txtEmail'     => '',
            'txtMob'       => '',
            'selAccess'     => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );
    // attempt to create the user
    $userdata = array(
        'user_login'   => $data['masteradmin']['txtEmail'],
        'user_email'   => $data['masteradmin']['txtEmail'],
        'first_name'   => $data['masteradmin']['txtUsername'],
        'last_name'    => $data['masteradmin']['txtName'],
        'user_url'     => $data['masteradmin']['user_url'],
        'display_name' => $data['masteradmin']['txtUsername'],
       );

    // if user id exists, do an update
    $user_id = isset( $data['masteradmin']['user_id'] ) ? intval( $data['masteradmin']['user_id'] ) : 0;
    $update  = false;

    if ( $user_id ) {
        $update = true;
        $userdata['ID'] = $user_id;

    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password( 12 );
        $userdata['role'] = 'masteradmin';
    }

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
    $masteradmin_data = array(
	
	'SUP_Username'        => $data['masteradmin']['txtUsername'],
    'SUP_Name'     => $data['masteradmin']['txtName'],
    'SUP_Email'      => $data['masteradmin']['txtEmail'],
    'SUP_Contact'     => $data['masteradmin']['txtMob'],
	'SUP_Type'     => '2',
	'SUP_Access'     => $data['masteradmin']['selAccess'],
    );
    if($update){
        $tablename = "superadmin";
        $masteradmin_data['user_id'] = $user_id;
        $wpdb->update( $tablename,$masteradmin_data,array( 'user_id' => $user_id ));    
    }
    else{
    $user_id  = wp_insert_user( $userdata );
    $tablename = "superadmin";
    $masteradmin_data['user_id'] = $user_id;
    $wpdb->insert( $tablename, $masteradmin_data);
    return $user_id;
    }
}
/*
 * [erp_hr_url_single_companyview description]
 *
 * @param  int  company id
 *
 * @return string  url of the companyview details page
 */
function erp_admin_url_single_masteradminview($com_id) {

    $url = admin_url( 'admin.php?page=masteradminview&action=view&id=' . $com_id);

    return apply_filters( 'erp_admin_url_single_masteradminview', $url, $com_id );
}

