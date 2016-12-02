<?php
function get_mileage_type() {
    global $wpdb;
    $mileage = $wpdb->get_results("SELECT * FROM mode WHERE EC_Id='5' AND MOD_Status=1");
    return $mileage;
}
function erp_company_url_single_mileage($milId) {

    $url = admin_url( 'admin.php?page=Mileage=view&id=' . $milId);

    return apply_filters( 'erp_company_url_single_Mileage', $url, $milId );
}
function mileage_create($args = array()) {
    global $wpdb;
     $compid = $_SESSION['compid'];
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'user_id'=>0,
            'compid'=>$compid,
            'selectmileage' => '',
            'units' => '',
            'txtMilAmount' => '',
        )
    );

    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
      $user_id = $data['company']['milId']; 
    $update = false;
    if ( $user_id ) {
        $update = true;
        $company_data['MIL_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id'=>$compid,
        //'MIL_Id'=>$data['company']['milId'],
        'MOD_Id'   => $data['company']['selectmileage'],
        'MIL_Units' => $data['company']['units'],
        'MIL_Amount' => $data['company']['txtMilAmount'],
    );
    if ($update) {
        $tablename = "mileage";
        $wpdb->update($tablename, $company_data ,array( 'MIL_Id' => $user_id ));
    } else {
        $tablename = "mileage";
       $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}

