<?php
namespace WeDevs\ERP\Corptne;

use WeDevs\ERP\HRM\Models\Dependents;
use WeDevs\ERP\HRM\Models\Education;
use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Employee Class
 */
class TravelAgent {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        
        'designation_title',
        'department_title',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct( $travelagent = null ) {

        $this->id   = 0;
        $this->user = new \stdClass();
        $this->erp  = new \stdClass();

        if ( is_int( $travelagent ) ) {

            $user = get_user_by( 'id', $travelagent );

            if ( $user ) {
                $this->id   = $travelagent;
                $this->user = $user;
            }

        } elseif ( is_a( $travelagent, 'WP_User' ) ) {

            $this->id   = $travelagent->ID;
            $this->user = $travelagent;

        } elseif ( is_email( $travelagent ) ) {

            $user = get_user_by( 'email', $travelagent );

            if ( $user ) {
                $this->id   = $travelagent;
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

    /**
     * Get the user info as an array
     *
     * @return array
     */
    public function to_array() {
	$defaults = array(
            'SUP_Username'  => '',
            'SUP_AgencyName'     => '',
            'SUP_Address' => '',
            'SUP_Name'         => '',
            'SUP_Email'        => '',
            'SUP_Contact'     => '',
            'SUP_Type'=>   '3',
    );
        return apply_filters( 'erp_hr_get_travelagent_fields', $defaults, $this->id, $this->user );
        //return $defaults;
    }
 
    
    public function get_details_url() {
        if ( $this->id ) {
            return admin_url( 'admin.php?page=travelagents&action=view&id=' . $this->id );
        }
    }


    /**
     * Get all notes
     *
     * @return integer
     */
    public function count_notes() {

        return \WeDevs\ERP\HRM\Models\Hr_User::find( $this->id )
                ->notes()
                ->count();
    }

}
