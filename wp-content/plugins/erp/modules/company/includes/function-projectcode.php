<?php

function erp_company_url_single_projectcode($pcId) {

    $url = admin_url('admin.php?page=projectcode=view&id=' . $pcId);

    return apply_filters('erp_company_url_single_projectcode', $url, $pcId);
}

function projectcode_create($args = array()) {
    global $wpdb;
    $compid = $_SESSION['compid'];
  
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'compid' => $compid,
            'pcId',
            'txtProjectCode' => '',
            'txtProjectName' => '',
            'txtProjectLoc' => '',
            'txtProjectDesc' => '',
        )
    );
    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    $user_id = $data['company']['pcId'];
    $update = false;
    if ($user_id) {
        $update = true;
        $company_data['PC_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id' => $compid,
        //'PC_Id' => $data['company']['pcId'],
        'PC_Code' => $data['company']['txtProjectCode'],
        'PC_Name' => $data['company']['txtProjectName'],
        'PC_Location' => $data['company']['txtProjectLoc'],
        'PC_Description'=> $data['company']['txtProjectDesc'],
    );
    if ($update) {
        $tablename = "project_code";
        $company_data['PC_Id'] = $user_id;
        $wpdb->update($tablename, $company_data, array('PC_Id' => $user_id));
    } else {
        $tablename = "project_code";
        $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}
