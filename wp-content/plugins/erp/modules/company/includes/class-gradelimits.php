<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class GradeLimits {

    private $erp_rows = array(
        'compid',
        'depId',
        'txtDep',
    );

    public function __construct($gradelimits = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if (is_int($gradelimits)) {

            $user = get_user_by('id', $gradelimits);

            if ($user) {
                $this->id = $gradelimits;
                $this->user = $user;
            }
        } elseif (is_a($gradelimits, 'WP_User')) {

            $this->id = $gradelimits->ID;
            $this->user = $gradelimits;
        } elseif (is_email($gradelimits)) {

            $user = get_user_by('email', $gradelimits);

            if ($user) {
                $this->id = $gradelimits;
                $this->user = $user;
            }
        }
    }

    public function __get($key) {

        if (in_array($key, $this->erp_rows)) {
            $this->erp = $this->get_erp_row();
        }

        if (isset($this->erp->$key)) {
            return stripslashes($this->erp->$key);
        }

        if (isset($this->user->$key)) {
            return stripslashes($this->user->$key);
        }
    }

    public function gradelimits_array() {
        global $wpdb;
        $compid = $_SESSION['compid'];
        //echo $compid;die;
        $adminid = $_SESSION['adminid'];
        $defaults = array(
            'ADM_Id' => $adminid,
            'COM_Id' => $compid,
            'GL_Flight' => ' ',
            'GL_Bus' => ' ',
            'GL_Car' => ' ',
            'GL_Others_Travels' => ' ',
            'GL_Hotel' => ' ',
            'GL_Self' => ' ',
            'GL_Halt' => ' ',
            'GL_Boarding' => ' ',
            'GL_Other_Te_Others' => ' ',
            'GL_Local_Conveyance' => ' ',
            'GL_Mobile' => ' ',
            'GL_ClientMeeting' => ' ',
            'GL_Others_Other_te' => ' ',
            'GL_DataCard' => ' ',
            'GL_Marketing' => ' ',
            'GL_Twowheeler' => ' ',
            'GL_Fourwheeler' => ' ',
            'GL_Internet' => ' ',
        );
        $selcom = $wpdb->get_results("SELECT * FROM employee_grades WHERE COM_Id='$compid' AND EG_Status=1 ORDER BY EG_Id DESC");
        //print_r($selcom);die;
        $egId=$selcom[0]->EG_Id;
        //echo $egId;
        $gradelimitslist = $wpdb->get_results("SELECT * FROM grade_limits  WHERE EG_Id='$egId' AND GL_Status=1");
        //print_r($gradelimitslist);die;
        $defaults['gradelimitslist'] = $gradelimitslist;

        return apply_filters('erp_company_get_gradelimitslist_fields', $defaults, $this->id, $this->user);
    }

}
