<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class Grades{

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        'compid',
        'egId',
        'txtGrade',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct($grades = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if ( is_int( $grades ) ) {

            $user = get_user_by( 'id', $grades );

            if ( $user ) {
                $this->id   = $grades;
                $this->user = $user;
            }

        } elseif ( is_a( $grades, 'WP_User' ) ) {

            $this->id   = $grades->ID;
            $this->user = $grades;

        } elseif ( is_email( $grades ) ) {

            $user = get_user_by( 'email', $grades );

            if ( $user ) {
                $this->id   = $grades;
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

    /**
     * Get the user info as an array
     *
     * @return array
     */
    public function to_array() {
         global $wpdb;
        $compid = $_SESSION['compid'];
        $defaults = array(
            'compid'=> $compid,
            'txtGrade' => '',
            'egId' => '',
        );
        return apply_filters('erp_company_get_grades_fields', $defaults, $this->id, $this->user);
      // var_dump($defaults);
    }

    public function grades_array() {
        global $wpdb;
        $compid = $_SESSION['compid'];
        //echo $compid;die;
        $defaults = array(
            'COM_Id'=> '',
            'EG_Id' => '',
            'EG_Name' => '',
        );
        $gradeslist = $wpdb->get_results("SELECT * FROM employee_grades WHERE COM_Id=$compid AND EG_Status=1 ORDER BY EG_Name ASC");
        $defaults['gradeslist'] = $gradeslist;
       // print_r($gradeslist);die;
        return apply_filters('erp_company_get_gradeslist_fields', $defaults, $this->id, $this->user);
        //return $defaults;
    }

    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ($this->id) {
            return admin_url('admin.php?page=erp-company-grades&id=' . $this->id);
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
