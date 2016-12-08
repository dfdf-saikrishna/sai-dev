<?php

namespace WeDevs\ERP\Company;

//use WeDevs\ERP\HRM\Models\Dependents;
//use WeDevs\ERP\HRM\Models\Education;
//use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Mileage Class
 */
class TravelDesk {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        'txtUsername',
        'txtEmail',
            //'txtMilAmount',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct($traveldesk = null) {

        $this->id = 0;
        $this->user = new \stdClass();
        $this->erp = new \stdClass();
        if (is_int($traveldesk)) {

            $user = get_user_by('id', $traveldesk);

            if ($user) {
                $this->id = $traveldesk;
                $this->user = $user;
            }
        } elseif (is_a($traveldesk, 'WP_User')) {

            $this->id = $traveldesk->ID;
            $this->user = $traveldesk;
        } elseif (is_email($traveldesk)) {

            $user = get_user_by('email', $traveldesk);

            if ($user) {
                $this->id = $traveldesk;
                //echo $traveldesk;die;
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
            'user_id'=>'',
            'COM_Id' => $compid,
            'TD_Username' => '',
            'TD_Email' => '',
            'TD_Id' => '',
            'TD_Type' => '1',
            
                //'txtadescdeal'     => '',
        );
        return apply_filters('erp_company_get_traveldesk_fields', $defaults, $this->id, $this->user);
        // var_dump($defaults);
    }
    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ($this->id) {
            return admin_url('admin.php?page=erp-company-traveldesk&id=' . $this->id);
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
