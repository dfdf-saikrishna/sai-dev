<?php
/*
 * [erp_hr_url_single_companyview description]
 *
 * @param  int  company id
 *
 * @return string  url of the companyview details page
 */

function erp_company_url_single_employeesProfile($empid) {

    $url = admin_url( 'admin.php?page=Profile=view&id=' . $empid);

    return apply_filters( 'erp_company_url_single_Profile', $url, $empid );
}
function employeeview_create( $args = array() ) {
    global $wpdb;
    $defaults = array(
        //'user_email'      => '',
        'companyemployee'        => array(
            'photo_id'        => 0,
            'user_id'         => 0,
            'txtEmpname'     => '',
            'txtEmpcode'      => '',
            'txtempemail'     => '',
            'txtempmob'       => '',
            'txtemplandline'     => '',
            'selGrade'           => '',
            'selDep'      => '',
            'selDes'          => '',
            'txtRepmngrcode'         => '',
            'txtRepfuncmngrcode'          => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );


    // attempt to create the user
    $userdata = array(
        'user_login'   => $data['companyemployee']['txtempemail'],
        'user_email'   => $data['companyemployee']['txtempemail'],
        'first_name'   => $data['companyemployee']['txtEmpname'],
        'last_name'    => $data['companyemployee']['txtEmpname'],
        'user_url'     => $data['companyemployee']['user_url'],
        'display_name' => $data['companyemployee']['txtEmpname'],
        //'display_name' => $data['company']['txtCompname'] . ' ' . $data['personal']['middle_name'] . ' ' . $data['personal']['last_name'],
    );

    // if user id exists, do an update
    $user_id = isset( $posted['user_id'] ) ? intval( $posted['user_id'] ) : 0;
    $update  = false;

    if ( $user_id ) {
        $update = true;
        $userdata['ID'] = $user_id;

    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password( 12 );
        $userdata['role'] = 'companyadmin';
    }

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    $user_id  = wp_insert_user( $userdata );
    $avatar_url = wp_get_attachment_url( $data['company']['photo_id'] );
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
    $company_data = array(
        'user_id'   => $user_id,
        'COM_Name'   => $data['company']['txtCompname'],
        'COM_Email'   => $data['company']['txtCompemail'],
        'COM_Mobile'    => $data['company']['txtCompname'],
        'COM_Landline'     => $data['company']['txtCompname'],
        'COM_Address' => $data['company']['txtCompname'],
        'COM_Location' => $data['company']['txtCompname'],
        'COM_City' => $data['company']['txtCompname'],
        'COM_Logo' => $avatar_url, 
    );
    $tablename = "company";
    $wpdb->insert( $tablename, $company_data);
    return $user_id;
}

/**
 * Get all employees from a company
 *
 * @param  int   $company_id  company id
 * @param bool $no_object     if set true, Employee object will be
 *                            returned as array. $wpdb rows otherwise
 *
 * @return array  the employees
 */
function employeeview_get( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'hiring_date',
        'order'      => 'DESC',
        'no_object'  => false,
        'count'      => false
    );

    $args  = wp_parse_args( $args, $defaults );
    $where = array();

    $comapnyview = new \WeDevs\ERP\Company\Models\Employeeview();
    $employee_result = $employee->leftjoin( $wpdb->users, 'user_id', '=', $wpdb->users . '.ID' )->select( array( 'user_id', 'display_name' ) );


    if ( isset( $args['type'] ) && $args['type'] != '-1' ) {
        $employee_result = $employee_result->where( 'type', $args['type'] );
    }

    if ( isset( $args['status'] ) && ! empty( $args['status'] ) ) {
        if ( $args['status'] == 'trash' ) {
            $employee_result = $employee_result->onlyTrashed();
        } else {
            if ( $args['status'] != 'all' ) {
                $employee_result = $employee_result->where( 'status', $args['status'] );
            }
        }
    } else {
        $employee_result = $employee_result->where( 'status', 'active' );
    }

    if ( isset( $args['s'] ) && ! empty( $args['s'] ) ) {
        $arg_s = $args['s'];
        $employee_result = $employee_result->where( 'display_name', 'LIKE', "%$arg_s%" );
    }

    $cache_key = 'erp-get-employees-' . md5( serialize( $args ) );
    $results   = wp_cache_get( $cache_key, 'erp' );
    $users     = array();

    // Check if want all data without any pagination
    if ( $args['number'] != '-1' && ! $args['count'] ) {
        $employee_result = $employee_result->skip( $args['offset'] )->take( $args['number'] );
    }

    // Check if args count true, then return total count customer according to above filter
    if ( $args['count'] ) {
        return $employee_result->count();
    }

    if ( false === $results ) {

        $results = $employee_result
                    ->orderBy( $args['orderby'], $args['order'] )
                    ->get()
                    ->toArray();

        $results = erp_array_to_object( $results );
        wp_cache_set( $cache_key, $results, 'erp', HOUR_IN_SECONDS );
    }

    if ( $results ) {
        foreach ($results as $key => $row) {

            if ( true === $args['no_object'] ) {
                $users[] = $row;
            } else {
                $users[] = new \WeDevs\ERP\HRM\Employee( intval( $row->user_id ) );
            }
        }
    }

    return $users;
}


