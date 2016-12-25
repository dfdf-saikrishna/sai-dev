<?php

function gradelimitscat_create($posted) {
    global $wpdb;
    $compid = $_SESSION['compid'];
    $adminid = $_SESSION['adminid'];
    $glID = $posted['company']['glId'];
    $egId = $posted['company']['egId'];
    $company_data = array(
        'COM_Id' => $compid,
        // 'ADM_Id'=>$data['company']['adminid'],
        'GL_Flight' => $posted['company']['txtflight'],
        'GL_Bus' => $posted['company']['txtBus'],
        'GL_Car' => $posted['company']['txtCar'],
        'GL_Others_Travels' => $posted['company']['txtOthers1'],
        'GL_Hotel' => $posted['company']['txtHotel'],
        'GL_Self' => $posted['company']['txtSelf'],
        'GL_Halt' => $posted['company']['txtHalt'],
        'GL_Boarding' => $posted['company']['txtBoarding'],
        'GL_Other_Te_Others' => $posted['company']['txtOthers'],
        'GL_Local_Conveyance' => $posted['company']['txtLocal'],
        'GL_Mobile' => $posted['company']['txtMobile'],
        'GL_ClientMeeting' => $posted['company']['txtClient'],
        'GL_Others_Other_te' => $posted['company']['txtOthers'],
        'GL_DataCard' => $posted['company']['txtData'],
        'GL_Marketing' => $posted['company']['txtMarketing'],
        'GL_Twowheeler' => $posted['company']['txtTwo'],
        'GL_Fourwheeler' => $posted['company']['txtFour'],
        'GL_Internet' => $posted['company']['txtInternet'],
        'GL_UpdatedBy'=>$adminid,
        'GL_UpdatedDate'=>'Now()',
    );
        $tablename = "grade_limits";
      
        $company_data['EG_Id'] = $egId;
        $wpdb->update($tablename, $company_data, array('EG_Id' => $egId));
        return "success";
}
