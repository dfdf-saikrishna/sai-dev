<?php

function erp_company_url_single_costcenter($ccId) {

    $url = admin_url('admin.php?page=costcenter=view&id=' . $ccId);

    return apply_filters('erp_company_url_single_costcenter', $url, $ccId);
}
//
//function delete($ccId) {
//    global $wpdb;
//    $compid = $_SESSION['compid'];
//    $selsql = $wpdb->get_results("SELECT * FROM cost_center WHERE COM_Id='$compid' AND CC_Active=1 ORDER BY CC_Id DESC");
//    foreach ($selsql as $rowcom) {
//        $cnt = count($wpdb->get_results("SELECT REQ_Id FROM  requests WHERE CC_Id=$rowcom->CC_Id AND COM_Id='$compid' AND REQ_Active != 9"));
//        if ($rowcom->CC_Status == 1) {
//            if ($cnt > 0)
//
//                return Closecc();
//            else
//                return $disabled=1;
//        }
//        else {
//
//            return approvals(5);
//        }
//    }
//}

function Closecc() {
    global $wpdb;
    $compid = $_SESSION['compid'];
    //echo $compid;die;
    $ccid = $_POST['ccId'];
    if ($cnt = count($wpdb->get_results("SELECT CC_Id FROM cost_center WHERE CC_Id='$ccid' AND COM_Id='$compid' AND CC_Active = 1"))) {

        $cnt = count($wpdb->get_results("SELECT REQ_Id FROM  requests WHERE CC_Id='$ccid' AND COM_Id='$compid' AND REQ_Active != 9"));

        if ($cnt > 0) {

            if ($upd = $wpdb->query("UPDATE cost_center SET CC_Status=2 AND CC_ClosedDate=NOW() WHERE CC_Id='$ccid' AND CC_Status=1 AND CC_Active=1")) {
                 header("location:$filename?msg='Cost Center Closed Successfully'");
               // echo "";
                exit;
            } else {
                echo"Error. Please try again.";
                exit;
            }
        } else {
            echo "Sorry. None Expense Request assigned with that Cost Center. <br>Cost Center cannot be closed. ";
            exit;
        }
    } else {
        echo"Error. Please try again.";
        exit;
    }
}

function costcenter_create($args = array()) {
    global $wpdb;
    $compid = $_SESSION['compid'];

    $defaults = array(
        //'user_email'      => '',
        'company' => array(
            'compid' => $compid,
            'ccId',
            'txtCostCenterCode' => '',
            'txtCostCenterName' => '',
            'txtCostCenterLoc' => '',
            'txtCostCenterDesc' => '',
        )
    );
    $posted = array_map('strip_tags_deep', $args);
    $posted = array_map('trim_deep', $posted);
    $data = erp_parse_args_recursive($posted, $defaults);
    $user_id = $data['company']['ccId'];
    $update = false;
    if ($user_id) {
        $update = true;
        $company_data['CC_Id'] = $user_id;
    }
    $company_data = array(
        'COM_Id' => $compid,
        //'PC_Id' => $data['company']['pcId'],
        'CC_Code' => $data['company']['txtCostCenterCode'],
        'CC_Name' => $data['company']['txtCostCenterName'],
        'CC_Location' => $data['company']['txtCostCenterLoc'],
        'CC_Description' => $data['company']['txtCostCenterDesc'],
    );
    if ($update) {
        $tablename = "cost_center";
        $company_data['CC_Id'] = $user_id;
        $wpdb->update($tablename, $company_data, array('CC_Id' => $user_id));
    } else {
        $tablename = "cost_center";
        $wpdb->insert($tablename, $company_data);
        return $company_data;
    }
}
