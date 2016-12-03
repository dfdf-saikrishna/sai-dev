<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class Designation{

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        'adminid',
        'compid',
        'desId',
        'txtDes',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct($designation = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if ( is_int( $designation ) ) {

            $user = get_user_by( 'id', $designation );

            if ( $user ) {
                $this->id   = $designation;
                $this->user = $user;
            }

        } elseif ( is_a( $designation, 'WP_User' ) ) {

            $this->id   = $designation->ID;
            $this->user = $designation;

        } elseif ( is_email( $designation ) ) {

            $user = get_user_by( 'email', $designation );

            if ( $user ) {
                $this->id   = $designation;
                $this->user = $user;
            }

        }
//       
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
//            'txtDes' => '',
//            'desId' => '',
//        );
//        return apply_filters('erp_company_get_designation_fields', $defaults, $this->id, $this->user);
//      // var_dump($defaults);
//    }

    public function designation_array() {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $adminid = $_SESSION['adminid'];
        //echo $adminid;die;
        $defaults = array(
            'COM_Id'=>$compid,
            'ADM_Id'=>$adminid,
            'DES_Id' => '',
            'DES_Name' => '',
        );
        $designationlist = $wpdb->get_results("SELECT * FROM designation dpt,admin adm WHERE dpt.COM_Id='$compid' AND dpt.ADM_Id=adm.ADM_Id AND dpt.DES_Status=1 ORDER BY DES_Name ASC");
        $defaults['designationlist'] = $designationlist;
        //print_r($designationlist);die;
        return apply_filters('erp_company_get_designationlist_fields', $defaults, $this->id, $this->user);
        //return $defaults;
    }

    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ($this->id) {
            return admin_url('admin.php?page=erp-company-designation&id=' . $this->id);
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
