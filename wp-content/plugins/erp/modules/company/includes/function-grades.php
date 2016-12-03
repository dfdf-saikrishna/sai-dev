<?php

function erp_company_url_single_gardes($egId) {

    $url = admin_url( 'admin.php?page=grades=view&id=' . $egId);

    return apply_filters( 'erp_company_url_single_grades', $url, $egId );
}
function grades_create($args = array()) {
    global $wpdb;
     $compid = $_SESSION['compid'];
    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'compid'=>$compid,
            'txtGrade' => '',
            'egId' => '',
        )
    );
    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    $user_id = $data['company']['egId']; 
    $update = false;
    if ( $user_id ) {
        $update = true;
        $company_data['EG_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id'=>$compid,
        //'EG_Id'=>$data['company']['egId'],
        'EG_Name' => $data['company']['txtGrade'],
    );
    if ($update) {
        $tablename = "employee_grades";
        //company[egId]
        $company_data['EG_Id'] = $user_id;
        $wpdb->update($tablename, $company_data,array( 'EG_Id' => $user_id ));
    } else {
        $tablename = "employee_grades";
       $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}