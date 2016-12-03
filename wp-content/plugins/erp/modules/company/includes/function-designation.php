<?php

function erp_company_url_single_designation($egId) {

    $url = admin_url( 'admin.php?page=designation=view&id=' . $egId);

    return apply_filters( 'erp_company_url_single_designation', $url, $egId );
}
function designation_create($args = array()) {
    global $wpdb;
     $compid = $_SESSION['compid'];
      $adminid = $_SESSION['adminid'];
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'compid'=>$compid,
            'ADM_Id'=>$adminid,
            'txtDes' => '',
            'desId' => '',
        )
    );
    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    $user_id = $data['company']['desId']; 
    $update = false;
    if ( $user_id ) {
        $update = true;
        $company_data['DES_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id'=>$compid,
        'ADM_Id'=>$data['company']['adminid'],
        'DES_Name' => $data['company']['txtDes'],
    );
    if ($update) {
        $tablename = "designation";
        $company_data['DES_Id'] = $user_id;
        $wpdb->update($tablename, $company_data,array( 'DES_Id' => $user_id ));
    } else {
        $tablename = "designation";
       $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}