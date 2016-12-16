<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class CostCenter{

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        'compid',
        'CcId',
        'txtCostCenterCode',
        'txtCostCenterName',
        'txtCostCenterLoc',
        'txtCostCenterDesc',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct($costcenter = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if (is_int($costcenter)) {

            $user = get_user_by('id', $costcenter);

            if ($user) {
                $this->id = $costcenter;
                $this->user = $user;
            }
        } elseif (is_a($costcenter, 'WP_User')) {

            $this->id = $costcenter->ID;
            $this->user = $costcenter;
        } elseif (is_email($costcenter)) {

            $user = get_user_by('email', $costcenter);

            if ($user) {
                $this->id = $costcenter;
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

//    /**
//     * Get the user info as an array
//     *
//     * @return array
//     */
//    public function to_array() {
//         global $wpdb;
//        $compid = $_SESSION['compid'];
//        $defaults = array(
//            'compid'=> $compid,
//            'txtDep' => '',
//            'desId' => '',
//        );
//        return apply_filters('erp_company_get_costcenter_fields', $defaults, $this->id, $this->user);
//      // var_dump($defaults);
//    }

    public function costcenter_array() {
        global $wpdb;
        $compid = $_SESSION['compid'];
        //echo $compid;die;
        //$adminid = $_SESSION['adminid'];
        $defaults = array(
            'COM_Id' => $compid,
            'CC_Id' => '',
            'CC_Code' => '',
            'CC_Name' => '',
            'CC_Location' => '',
            'CC_Description' => '',
        );
        $costcenterlist = $wpdb->get_results("SELECT * FROM cost_center WHERE COM_Id='$compid' AND CC_Active=1 ORDER BY CC_Id DESC");
        $defaults['costcenterlist'] = $costcenterlist;
        //print_r($costcenterlist);die;
        return apply_filters('erp_company_get_costcenterlist_fields', $defaults, $this->id, $this->user);
        //return $defaults;
    }

    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ($this->id) {
            return admin_url('admin.php?page=erp-company-costcenter&id=' . $this->id);
        }
    }

    /**
     * Get an HTML link to single employee view
     *
     * @return string url to details
     */
    public function get_link() {
        return sprintf('<a href="%s">%s</a>', $this->get_details_url());
    }

}

//public function desgination_array() {
//        global $wpdb;
//        $compid = $_SESSION['compid'];
//        //echo $compid;die;
//        $defaults = array(
//            'COM_Id'=> '',
//            'DES_Id' => '',
//            'DES_Name' => '',
//        );
//        $desginationlist = $wpdb->get_results("SELECT * FROM department dpt, admin adm WHERE dpt.COM_Id='$compid' AND dpt.ADM_Id=adm.ADM_Id AND dpt.DEP_Status=1 ORDER BY DEP_Name ASC");
//        $defaults['desginationlist'] = $desginationlist;
//       print_r($desginationlist);die;
//        return apply_filters('erp_company_get_desginationlist_fields', $defaults, $this->id, $this->user);
//        //return $defaults;
//    }