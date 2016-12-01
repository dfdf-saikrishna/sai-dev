<?php
namespace WeDevs\ERP\Travelagent;

/**
 * Employee Class
 */
class Travelagentuser {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        
    );

  
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
            'COM_Logo'        => '',
            'COM_PhotoId'   =>'0',
            'user_id'         => 0,
            'COM_Address'     => '',
            'COM_Bus'      => '0',
            'COM_City'     => '',
            'COM_ComidOld'       => '0',
            'COM_Cp1email'     => '',
            'COM_Cp1mobile'           => '',
            'COM_Cp1username'      => '',
            'COM_Cp2email'          => '',
            'COM_Cp2mobile'         => '',
            'COM_Cp2username'          => '',
            'COM_Descdeal'  => '',
            'COM_Email'     => '',
            'COM_Flight' => '',
            'COM_Hotel'         => '',
            'COM_Id'        => '',
            'COM_Landline'     => '',
            'COM_Location'        => '',
            'COM_Name'        => '',
            'txtSalespersname'            => '',
            'txtSalesperemail'         => '',
            'txtSalespercontno'           => '',
            'txtadescdeal'     => '',
    );
        return apply_filters( 'erp_hr_get_employee_fields', $defaults, $this->id, $this->user );
        //return $defaults;
    }
   
    /**
     * Get data from ERP employee table
     *
     * @param boolean $force if force from cache
     *
     * @return object the wpdb row object
     */
    private function get_erp_row( $force = false ) {
        global $wpdb;

        if ( $this->id ) {
            $cache_key = 'erp-empl-' . $this->id;
            $row       = wp_cache_get( $cache_key, 'erp', $force );

            if ( false === $row ) {
                $query = "SELECT e.*, d.title as designation_title, dpt.title as department_title, loc.name as location_name
                    FROM {$wpdb->prefix}erp_hr_employees AS e
                    LEFT JOIN {$wpdb->prefix}erp_hr_designations AS d ON d.id = e.designation
                    LEFT JOIN {$wpdb->prefix}erp_hr_depts AS dpt ON dpt.id = e.department
                    LEFT JOIN {$wpdb->prefix}erp_company_locations AS loc ON loc.id = e.location
                    WHERE user_id = %d";
                $row   = $wpdb->get_row( $wpdb->prepare( $query, $this->id ) );
                wp_cache_set( $cache_key, $row, 'erp' );
            }

            return $row;
        }

        return false;
    }

  


    /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ( $this->id ) {
            return admin_url( 'admin.php?page=erp-hr-employee&action=view&id=' . $this->id );
        }
    }

    

    /**
     * Get an HTML link to single employee view
     *
     * @return string url to details
     */
    public function get_link() {
        return sprintf( '<a href="%s">%s</a>', $this->get_details_url(), $this->get_full_name() );
    }

}
