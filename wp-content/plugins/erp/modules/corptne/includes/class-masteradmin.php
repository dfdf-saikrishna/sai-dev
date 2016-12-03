<?php
namespace WeDevs\ERP\Corptne;

use WeDevs\ERP\HRM\Models\Dependents;
use WeDevs\ERP\HRM\Models\Education;
use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Employee Class
 */
class Masteradmin {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
     private $erp_rows = array(
			'SUP_Username',
            'SUP_Name',
            'SUP_Email',
            'SUP_Contact',
			'SUP_Type',
			'SUP_Access',
    );


    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct( $employee = null ) {

        $this->id   = 0;
        $this->user = new \stdClass();
        $this->erp  = new \stdClass();

        if ( is_int( $employee ) ) {

            $user = get_user_by( 'id', $employee );

            if ( $user ) {
                $this->id   = $employee;
                $this->user = $user;
            }

        } elseif ( is_a( $employee, 'WP_User' ) ) {

            $this->id   = $employee->ID;
            $this->user = $employee;

        } elseif ( is_email( $employee ) ) {

            $user = get_user_by( 'email', $employee );

            if ( $user ) {
                $this->id   = $employee;
                $this->user = $user;
            }

        }
    }

    /**
     * Magic method to get item data values
     *
     * @param  string
     *
     * @return string
     */
    public function __get( $key ) {

        // lazy loading
        // if we are requesting any data from ERP table,
        // only then query to get those row
        if ( in_array( $key, $this->erp_rows ) ) {
            $this->erp = $this->get_erp_row();
        }

        if ( isset( $this->erp->$key ) ) {
            return stripslashes( $this->erp->$key );
        }

        if ( isset( $this->user->$key ) ) {
            return stripslashes( $this->user->$key );
        }
    }
    
    public function masteradmin_array() {
		global $wpdb;			
	$defaults = array(
            'SUP_Username'   => '',
            'SUP_Name'     => '',
            'SUP_Email'      => '',
            'SUP_Contact'     => '',
			'SUP_Type'     => '',
			'SUP_Access'     => '',
    );

        return apply_filters( 'erp_hr_get_employee_fields', $defaults, $this->id, $this->user );
        //return $defaults;
    }

   
    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ( $this->id ) {
            return admin_url( 'admin.php?page=masteradminview&action=view&id=' . $this->id );
        }
    }

    /**
     * Get the employees full name
     *
     * @return string
     */
    public function get_full_name() {
        $name = array();

        if ( ! empty( $this->user->first_name ) ) {
            $name[] = $this->user->first_name;
        }

        if ( ! empty( $this->user->middle_name ) ) {
            $name[] = $this->user->middle_name;
        }

        if ( ! empty( $this->user->last_name ) ) {
            $name[] = $this->user->last_name;
        }

        return implode( ' ', $name );
    }

    /**
     * Get an HTML link to single employee view
     *
     * @return string url to details
     */
    public function get_link() {
        return sprintf( '<a href="%s">%s</a>', $this->get_details_url(), $this->get_full_name() );
    }



    /**
     * Get the employee gender
     *
     * @return string
     */
    public function get_gender() {
        if ( ! empty( $this->user->gender ) ) {
            $genders = erp_hr_get_genders();

            if ( array_key_exists( $this->user->gender, $genders ) ) {
                return $genders[ $this->user->gender ];
            }
        }
    }


}
