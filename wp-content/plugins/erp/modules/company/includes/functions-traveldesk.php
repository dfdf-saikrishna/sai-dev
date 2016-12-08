<?php

function erp_company_url_single_traveldesk($tlid) {

    $url = admin_url('admin.php?page=traveldesk=view&id=' . $tlid);

    return apply_filters('erp_company_url_single_traveldesk', $url, $tlid);
}

function traveldesk_create($args = array()) {
    global $wpdb;
    $compid = $_SESSION['compid'];
    //echo $compid;die;
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'user_id' => 0,
            'compid' => $compid,
            'txtUsername' => '',
            'txtEmail' => '',
            'tdid' => '',
            'TD_Type' => '1',
        )
    );

    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    //print_r($posted);die;
    $userdata = array(
        'user_login' => $data['company']['txtEmail'],
        'user_email' => $data['company']['txtEmail'],
       // 'first_name' => $data['company']['user_id'],
            //'display_name' => $data['company']['txtCompname'] . ' ' . $data['personal']['middle_name'] . ' ' . $data['personal']['last_name'],
    );
    // if user id exists, do an update
    $user_id = isset($data['company']['user_id']) ? intval($data['company']['user_id']) : 0;
    $update = false;
    if ($user_id) {
        $update = true;
        $userdata['ID'] = $user_id;
    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password(12);
        $userdata['role'] = 'traveldesk';
    }
    if (is_wp_error($user_id)) {
        return $user_id;
    }
    $company_data = array(
        //'user_id' => $user_id,
        'COM_Id' => $compid,
        'TD_Username' => $data['company']['txtUsername'],
        'TD_Email' => $data['company']['txtEmail'],
        //'TD_Id' => $data['company']['tdid'],
    );
    if ($update) {
        $tablename = "travel_desk";
        $company_data['user_id'] = $user_id;
        //print_r($update);die;
        $wpdb->update($tablename, $company_data, array('user_id' => $user_id));
    } else {
        $user_id = wp_insert_user($userdata);
        $tablename = "travel_desk";
        $company_data['user_id'] = $user_id;
        $wpdb->insert($tablename, $company_data);
        return $user_id;
    }
}
