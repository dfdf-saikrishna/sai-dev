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
   
    $update = false;
    $company_data = array(
        'user_id'=>$data['company']['user_id'],
        'COM_Id'=>$compid,
        'MIL_Id'=>$data['company']['milId'],
        'MOD_Id'   => $data['company']['selectmileage'],
        'MIL_Units' => $data['company']['units'],
        'MIL_Amount' => $data['company']['txtMilAmount'],
    );
 //print_r( $company_data);die;
//        $compid = $_SESSION['compid'];
//        $posted = array_map('strip_tags_deep', array());
//        
//        $selMode	=	trim($posted['selectmileage']);
//	$selUnit	=	trim($posted['units']);
//	$txtAmount	=	trim($posted['txtMilAmount']);
//	$milid			=	$posted['milid'];
//        $rowtlid	= $wpdb->get_row("SELECT MIL_Id FROM mileage WHERE MOD_Id='$selMode' and COM_Id='$compid' AND MIL_Status=1 AND MIL_Active=1");
//         
//        $company_data = array(
//                'COM_Id'=>$compid,
//                'MIL_Id' => $rowtlid[MIL_Id],
//                'MIL_Status' => '2',
//                //'MIL_ClosedDate'=>NOW(),
//            );
      
//        $company_data1 = array(
//                'COM_Id'=>$compid,
//                'MIL_Id'=>$milid,
//                'MOD_Name'   =>$selMode ,
//                'MIL_Units' =>$selUnit,
//                'MIL_Amount' => $txtAmount,
//            );
//        $tablename = "mileage";
//        $wpdb->insert($tablename, $company_data1);
    if ($update) {
        $tablename = "mileage";
        $wpdb->update($tablename, $company_data);
    } else {
        $tablename = "mileage";
       $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}

