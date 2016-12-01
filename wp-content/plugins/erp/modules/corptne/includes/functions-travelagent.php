<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function erp_company_url_single_travelagents($sup_id) {

    $url = admin_url( 'admin.php?page=travelagents&action=view&id=' . $sup_id);

    return apply_filters( 'erp_company_url_single_travelagents', $url, $sup_id );
}
function travelagent_create( $args = array() ) {
    global $wpdb;
    $defaults = array(
        //'user_email'      => '',
        'company'        => array(
            
            'txtUsername'     => '',
            'txtAgencyName'      => '',
            'txtaAddress'     => '',
            'txtAgentName'       => '',
            'txtEmail'     => '',
            'txtPhn'           => '',
            'SUP_Type'=>'3',
            
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );
 
    $userdata = array(
        'user_login'   => $data['company']['txtUsername'],
        'user_email'   => $data['company']['txtAgencyName'],
        'first_name'   => $data['company']['txtaAddress'],
        'last_name'    => $data['company']['txtAgentName'],
        'user_url'     => $data['company']['txtEmail'],
        'display_name' => $data['company']['txtPhn'],
        //'display_name' => $data['company']['txtCompname'] . ' ' . $data['personal']['middle_name'] . ' ' . $data['personal']['last_name'],
    );

    // if user id exists, do an update
    $user_id = isset( $data['company']['user_id'] ) ? intval( $data['company']['user_id'] ) : 0;
    $update  = false;

    if ( $user_id ) {
        $update = true;
        $userdata['ID'] = $user_id;

    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password( 12 );
        $userdata['role'] = 'travelagent';
    }

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    
    //$avatar_url = wp_get_attachment_url( $data['company']['photo_id'] );
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
    $company_data = array(
        'user_id'   => $user_id,
        'SUP_Username'   => $data['company']['txtUsername'],
        'SUP_AgencyName'  => $data['company']['txtAgencyName'],
        'SUP_Address'   => $data['company']['txtaAddress'],
        'SUP_Name'    => $data['company']['txtUsername'],
        'SUP_Email'     => $data['company']['txtEmail'],
        'SUP_Contact'     => $data['company']['txtPhn'],
        'SUP_Type'=> '3',
    );
    if($update){
        $tablename = "superadmin";
        $company_data['user_id'] = $user_id;
        $wpdb->update( $tablename,$company_data,array( 'user_id' => $user_id ));    
    }
    else{
    $user_id  = wp_insert_user( $userdata );
    $tablename = "superadmin";
    $company_data['user_id'] = $user_id;
    $wpdb->insert( $tablename, $company_data);
    return $user_id;
    }
    //return $user_id;
    
}