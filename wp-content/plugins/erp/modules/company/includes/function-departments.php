<?php

function erp_company_url_single_departments($egId) {

    $url = admin_url( 'admin.php?page=departments=view&id=' . $egId);

    return apply_filters( 'erp_company_url_single_departments', $url, $egId );
}
function departments_create($args = array()) {
    global $wpdb;
     $compid = $_SESSION['compid'];
    $adminid = $_SESSION['adminid'];
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'compid'=>$compid,
            'ADM_Id'=>$adminid,
            'txtDep' => '',
            'depId' => '',
        )
    );
    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    $user_id = $data['company']['depId']; 
    $update = false;
    if ( $user_id ) {
        $update = true;
        $company_data['DEP_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id'=>$compid,
        'ADM_Id'=>$data['company']['adminid'],
        'DEP_Name' => $data['company']['txtDep'],
    );
    if ($update) {
        $tablename = "department";
        //company[egId]
        $company_data['DEP_Id'] = $user_id;
        $wpdb->update($tablename, $company_data,array( 'DEP_Id' => $user_id ));
    } else {
        $tablename = "department";
       $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}