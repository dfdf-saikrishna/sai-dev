<?php

function erp_company_url_single_subcategory($ecId) {

    $url = admin_url('admin.php?page=Subcategory=view&id=' . $ecId);

    return apply_filters('erp_company_url_single_Subcategory', $url, $ecId);
}

function subcategory_create($args = array()) {
    global $wpdb;
    $compid = $_SESSION['compid'];
    //echo $compid;die;
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'compid' => $compid,
            'ecid'=>'',
            'modId'=>'',
            'selExpenseCategory' => '',
            'txtaModes' => '',
        )
    );

    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    $user_id = $data['company']['modeId'];
    $update = false;
    if ($user_id) {
        $update = true;
        $company_data['MOD_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id' => $compid,
        'EC_Id' => $data['company']['selExpenseCategory'],
        'MOD_Name' => $data['company']['txtaModes'],
    );
    if ($update) {
        $tablename = "mode";
        $wpdb->update($tablename, $company_data, array('MOD_Id' => $user_id));
    } else {
        $tablename = "mode";
        $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}
