<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class Mileage {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        'compid',
        'selectmileage',
        'units',
        'txtMilAmount',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct($mileage = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if ( is_int( $mileage ) ) {

            $user = get_user_by( 'id', $mileage );

            if ( $user ) {
                $this->id   = $mileage;
                $this->user = $user;
            }

        } elseif ( is_a( $mileage, 'WP_User' ) ) {

            $this->id   = $mileage->ID;
            $this->user = $mileage;

        } elseif ( is_email( $mileage ) ) {

            $user = get_user_by( 'email', $mileage );

            if ( $user ) {
                $this->id   = $mileage;
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
            'selectmileage' => '',
            'units' => '',
            'txtMilAmount' => '',
                //'txtadescdeal'     => '',
        );
        return apply_filters('erp_company_get_mileage_fields', $defaults, $this->id, $this->user);
      // var_dump($defaults);
    }

    public function mileage_array() {
        global $wpdb;
        $compid = $_SESSION['compid'];
        //echo $compid;
        $defaults = array(
            'COM_Id'=> '',
            'MOD_Id' => '',
            'MIL_Units' => '',
            'MIL_Amount' => '',
                //'ADM_Username'     => '',
        );
        $mileagelist = $wpdb->get_results("SELECT * FROM mileage as mil, mode as mo WHERE mil.COM_Id= '$compid' AND mil.MOD_Id=mo.MOD_Id AND MIL_Active=1 ORDER BY MIL_Id ASC");
        $defaults['mileagelist'] = $mileagelist;
        //print_r($mileagelist);die;

        return apply_filters('erp_company_get_mileagelist_fields', $defaults, $this->id, $this->user);
        //return $defaults;
    }

    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ($this->id) {
            return admin_url('admin.php?page=erp-company-mileage&id=' . $this->id);
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
