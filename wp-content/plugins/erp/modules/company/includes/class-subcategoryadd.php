<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class SubCategory {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        'compid',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct($subcategory = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if ( is_int( $subcategory ) ) {

            $user = get_user_by( 'id', $subcategory );

            if ( $user ) {
                $this->id   = $subcategory;
                $this->user = $user;
            }

        } elseif ( is_a( $subcategory, 'WP_User' ) ) {

            $this->id   = $subcategory->ID;
            $this->user = $subcategory;

        } elseif ( is_email( $subcategory ) ) {

            $user = get_user_by( 'email', $subcategory );

            if ( $user ) {
                $this->id   = $subcategory;
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
            'selExpenseCategory' => '',
            'txtaModes' => '',
                //'txtadescdeal'     => '',
        );
        return apply_filters('erp_company_get_subcategory_fields', $defaults, $this->id, $this->user);
      // var_dump($defaults);
    }

    public function subcategory_array() {
        global $wpdb;
        $compid = $_SESSION['compid'];
        //echo $compid;
        $defaults = array(
            'COM_Id'=> '',
            'EC_Id' => '',
            'EC_Name' => '',
            'MOD_Name'=>'',
                //'ADM_Username'     => '',
        );
        $subcategorylist = $wpdb->get_results("SELECT * FROM mode WHERE COM_Id IN (0, $compid) AND MOD_Status=1 ");
        $defaults['subcategorylist'] = $subcategorylist;
        //print_r($subcategorylist);die;

        return apply_filters('erp_company_get_subcategorylist_fields', $defaults, $this->id, $this->user);
        //return $defaults;
    }

    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ($this->id) {
            return admin_url('admin.php?page=erp-company-subcategory&id=' . $this->id);
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
