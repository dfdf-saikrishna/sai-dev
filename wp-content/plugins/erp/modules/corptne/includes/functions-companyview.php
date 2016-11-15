<?php
/*
 * [erp_hr_url_single_companyview description]
 *
 * @param  int  company id
 *
 * @return string  url of the companyview details page
 */
function erp_company_url_single_companyview($com_id) {

    $url = admin_url( 'admin.php?page=mastercompaniesview&action=view&id=' . $com_id);

    return apply_filters( 'erp_company_url_single_companyview', $url, $com_id );
}

/**
 * Create a new employee
 *
 * @param  array  arguments
 *
 * @return int  employee id
 */
function companyview_create( $args = array() ) {
    global $wpdb;
    $defaults = array(
        //'user_email'      => '',
        'company'        => array(
            'photo_id'        => 0,
            'user_id'         => 0,
            'txtCompname'     => '',
            'txtCompmob'      => '',
            'txtCompemail'     => '',
            'txtComplandline'       => '',
            'txtaCompaddr'     => '',
            'txtCompoloc'           => '',
            'txtCompcity'      => '',
            'txtCompstate'          => '',
            'txtCompcntp1name'         => '',
            'txtCompcntp1email'          => '',
            'txtCompcntp1mob'  => '',
            'txtCompcntp2name'     => '',
            'txtCompcntp2email' => '',
            'txtCompcntp2mob'         => '',
            'selCT'        => '',
            'cbFlight'     => '',
            'cbBus'        => '',
            'cbHotel'        => '',
            'txtSalespersname'            => '',
            'txtSalesperemail'         => '',
            'txtSalespercontno'           => '',
            'txtadescdeal'     => '',
        )
    );

    $posted = array_map( 'strip_tags_deep', $args );
    $posted = array_map( 'trim_deep', $posted );
    $data   = erp_parse_args_recursive( $posted, $defaults );

    // some basic validation
//    if ( empty( $data['personal']['first_name'] ) ) {
//        return new WP_Error( 'empty-first-name', __( 'Please provide the first name.', 'erp' ) );
//    }
//
//    if ( empty( $data['personal']['last_name'] ) ) {
//        return new WP_Error( 'empty-last-name', __( 'Please provide the last name.', 'erp' ) );
//    }
//
//    if ( ! is_email( $data['user_email'] ) ) {
//        return new WP_Error( 'invalid-email', __( 'Please provide a valid email address.', 'erp' ) );
//    }

    // attempt to create the user
    $userdata = array(
        'user_login'   => $data['company']['txtCompemail'],
        'user_email'   => $data['company']['txtCompemail'],
        'first_name'   => $data['company']['txtCompname'],
        'last_name'    => $data['company']['txtCompname'],
        'user_url'     => $data['company']['user_url'],
        'display_name' => $data['company']['txtCompname'],
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
function companyview_get( $args = array() ) {
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

    $comapnyview = new \WeDevs\ERP\Corptne\Models\Companyview();
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


/**
 * Get all employees from a company
 *
 * @param  int   $company_id  company id
 * @param bool $no_object     if set true, Employee object will be
 *                            returned as array. $wpdb rows otherwise
 *
 * @return array  the employees
 */
function count_companiesview() {

    $where = array();

    $employee = new \WeDevs\ERP\HRM\Models\Employee();

    if ( isset( $args['designation'] ) && ! empty( $args['designation'] ) ) {
        $designation = array( 'designation' => $args['designation'] );
        $where = array_merge( $designation, $where );
    }

    if ( isset( $args['department'] ) && ! empty( $args['department'] ) ) {
        $department = array( 'department' => $args['department'] );
        $where = array_merge( $where, $department );
    }

    if ( isset( $args['location'] ) && ! empty( $args['location'] ) ) {
        $location = array( 'location' => $args['location'] );
        $where = array_merge( $where, $location );
    }

    if ( isset( $args['status'] ) && ! empty( $args['status'] ) ) {
        $status = array( 'status' => $args['status'] );
        $where = array_merge( $where, $status );
    }

    $counts = $employee->where( $where )->count();

    return $counts;
}


/**
 * Get Employee status count
 *
 * @since 0.1
 *
 * @return array
 */
function erp_hr_companyview_get_status_count() {
    global $wpdb;

    $statuses = array( 'all' => __( 'All', 'erp' ) ) + erp_hr_get_employee_statuses();
    $counts   = array();

    foreach ( $statuses as $status => $label ) {
        $counts[ $status ] = array( 'count' => 0, 'label' => $label );
    }

    $cache_key = 'erp-hr-employee-status-counts';
    $results = wp_cache_get( $cache_key, 'erp' );

    if ( false === $results ) {

        $employee = new \WeDevs\ERP\HRM\Models\Employee();
        $db = new \WeDevs\ORM\Eloquent\Database();

        $results = $employee->select( array( 'status', $db->raw('COUNT(id) as num') ) )
                            ->where( 'status', '!=', '0' )
                            ->groupBy('status')
                            ->get()->toArray();

        wp_cache_set( $cache_key, $results, 'erp' );
    }

    foreach ( $results as $row ) {
        if ( array_key_exists( $row['status'], $counts ) ) {
            $counts[ $row['status'] ]['count'] = (int) $row['num'];
        }

        $counts['all']['count'] += (int) $row['num'];
    }

    return $counts;
}

/**
 * Count trash employee
 *
 * @since 0.1
 *
 * @return int [no of trash employee]
 */
function erp_companyview_count_trashed_employees() {
    $employee = new \WeDevs\ERP\HRM\Models\Employee();

    return $employee->onlyTrashed()->count();
}

/**
 * Employee Restore from trash
 *
 * @since 0.1
 *
 * @param  array|int $employee_ids
 *
 * @return void
 */
function erp_companyview_restore( $employee_ids ) {
    if ( empty( $employee_ids ) ) {
        return;
    }

    if ( is_array( $employee_ids ) ) {
        foreach ( $employee_ids as $key => $user_id ) {
            \WeDevs\ERP\HRM\Models\Employee::withTrashed()->where( 'user_id', $user_id )->restore();
        }
    }

    if ( is_int( $employee_ids ) ) {
        \WeDevs\ERP\HRM\Models\Employee::withTrashed()->where( 'user_id', $employee_ids )->restore();
    }
}

/**
 * Employee Delete
 *
 * @param  array|int $employee_ids
 *
 * @return void
 */
function companyview_delete( $employee_ids, $hard = false ) {

    if ( empty( $employee_ids ) ) {
        return;
    }

    $employees = [];

    if ( is_array( $employee_ids ) ) {
        foreach ( $employee_ids as $key => $user_id ) {
            $employees[] = $user_id;
        }
    } else if ( is_int( $employee_ids ) ) {
        $employees[] = $employee_ids;
    }

    // still do we have any ids to delete?
    if ( ! $employees ) {
        return;
    }

    // seems like we got some
    foreach ($employees as $employee_id) {

        do_action( 'erp_hr_delete_employee', $employee_id, $hard );

        if ( $hard ) {
            \WeDevs\ERP\HRM\Models\Employee::where( 'user_id', $employee_id )->withTrashed()->forceDelete();
            wp_delete_user( $employee_id );

            // find leave entitlements and leave requests and delete them as well
            \WeDevs\ERP\HRM\Models\Leave_request::where( 'user_id', '=', $employee_id )->delete();
            \WeDevs\ERP\HRM\Models\Leave_Entitlement::where( 'user_id', '=', $employee_id )->delete();

        } else {
            \WeDevs\ERP\HRM\Models\Employee::where( 'user_id', $employee_id )->delete();
        }

        do_action( 'erp_hr_after_delete_employee', $employee_id, $hard );
    }

}

/**
 * Get Todays Birthday
 *
 * @since 0.1
 *
 * @return object [collection of user_id]
 */
function erp_companyview_get_todays_birthday() {

    $db = new \WeDevs\ORM\Eloquent\Database();

    return erp_array_to_object( \WeDevs\ERP\HRM\Models\Employee::select('user_id')
            ->where( $db->raw("DATE_FORMAT( `date_of_birth`, '%m %d' )" ), \Carbon\Carbon::today()->format('m d') )
            ->get()
            ->toArray() );
}

/**
 * Get next seven days birthday
 *
 * @since 0.1
 *
 * @return object [user_id, date_of_birth]
 */
function erp_companyview_get_next_seven_days_birthday() {

    $db = new \WeDevs\ORM\Eloquent\Database();

    return erp_array_to_object( \WeDevs\ERP\HRM\Models\Employee::select( array( 'user_id', 'date_of_birth' ) )
            ->where( $db->raw("DATE_FORMAT( `date_of_birth`, '%m %d' )" ), '>', \Carbon\Carbon::today()->format('m d') )
            ->where( $db->raw("DATE_FORMAT( `date_of_birth`, '%m %d' )" ), '<=', \Carbon\Carbon::tomorrow()->addWeek()->format('m d') )
            ->get()
            ->toArray() );
}

/**
 * Get the raw employees dropdown
 *
 * @param  int  company id
 *
 * @return array  the key-value paired employees
 */
function erp_companyview_get_employees_dropdown_raw( $exclude = null ) {
    $employees = erp_hr_get_employees( [ 'number' => -1 , 'no_object' => true ] );
    $dropdown  = array( 0 => __( '- Select Employee -', 'erp' ) );

    if ( $employees ) {
        foreach ($employees as $key => $employee) {
            if ( $exclude && $employee->user_id == $exclude ) {
                continue;
            }

            $dropdown[$employee->user_id] = $employee->display_name;
        }
    }

    return $dropdown;
}

/**
 * Get company employees dropdown
 *
 * @param  int  company id
 * @param  string  selected department
 *
 * @return string  the dropdown
 */
function erp_companyview_get_employees_dropdown( $selected = '' ) {
    $employees = erp_hr_get_employees_dropdown_raw();
    $dropdown  = '';

    if ( $employees ) {
        foreach ($employees as $key => $title) {
            $dropdown .= sprintf( "<option value='%s'%s>%s</option>\n", $key, selected( $selected, $key, false ), $title );
        }
    }

    return $dropdown;
}

/**
 * Get the registered employee statuses
 *
 * @return array the employee statuses
 */
function erp_companyview_get_employee_statuses() {
    $statuses = array(
        'active'     => __( 'Active', 'erp' ),
        'terminated' => __( 'Terminated', 'erp' ),
        'deceased'   => __( 'Deceased', 'erp' ),
        'resigned'   => __( 'Resigned', 'erp' )
    );

    return apply_filters( 'erp_hr_employee_statuses', $statuses );
}

/**
 * Get the registered employee statuses
 *
 * @return array the employee statuses
 */
function erp_companyview_get_employee_statuses_icons( $selected = NULL ) {
    $statuses = apply_filters( 'erp_hr_employee_statuses_icons', array(
        'active'     => sprintf( '<span class="erp-tips dashicons dashicons-yes" title="%s"></span>', __( 'Active', 'erp' ) ),
        'terminated' => sprintf( '<span class="erp-tips dashicons dashicons-dismiss" title="%s"></span>', __( 'Terminated', 'erp' ) ),
        'deceased'   => sprintf( '<span class="erp-tips dashicons dashicons-marker" title="%s"></span>', __( 'Deceased', 'erp' ) ),
        'resigned'   => sprintf( '<span class="erp-tips dashicons dashicons-warning" title="%s"></span>', __( 'Resigned', 'erp' ) )
    ) );

    if ( $selected && array_key_exists( $selected, $statuses ) ) {
        return $statuses[$selected];
    }

    return false;
}


/**
 * Get the registered employee statuses
 *
 * @return array the employee statuses
 */
function erp_companyview_get_employee_types() {
    $types = array(
        'permanent' => __( 'Full Time', 'erp' ),
        'parttime'  => __( 'Part Time', 'erp' ),
        'contract'  => __( 'On Contract', 'erp' ),
        'temporary' => __( 'Temporary', 'erp' ),
        'trainee'   => __( 'Trainee', 'erp' )
    );

    return apply_filters( 'erp_hr_employee_types', $types );
}

/**
 * Get the registered employee hire sources
 *
 * @return array the employee hire sources
 */
function erp_companyview_get_employee_sources() {
    $sources = array(
        'direct'        => __( 'Direct', 'erp' ),
        'referral'      => __( 'Referral', 'erp' ),
        'web'           => __( 'Web', 'erp' ),
        'newspaper'     => __( 'Newspaper', 'erp' ),
        'advertisement' => __( 'Advertisement', 'erp' ),
        'social'        => __( 'Social Network', 'erp' ),
        'other'         => __( 'Other', 'erp' ),
    );

    return apply_filters( 'erp_hr_employee_sources', $sources );
}

/**
 * Get marital statuses
 *
 * @return array all the statuses
 */
function erp_companyview_get_marital_statuses( $select_text = null ) {

    if ( $select_text ) {
        $statuses = array(
            '-1'      => $select_text,
            'single'  => __( 'Single', 'erp' ),
            'married' => __( 'Married', 'erp' ),
            'widowed' => __( 'Widowed', 'erp' )
        );
    } else {
        $statuses = array(
            'single'  => __( 'Single', 'erp' ),
            'married' => __( 'Married', 'erp' ),
            'widowed' => __( 'Widowed', 'erp' )
        );
    }

    return apply_filters( 'erp_hr_marital_statuses',  $statuses );
}

/**
 * Get Terminate Type
 *
 * @return array all the type
 */
function erp_companyview_get_terminate_type( $selected = NULL ) {
    $type = apply_filters( 'erp_hr_terminate_type', [
        'voluntary'   => __( 'Voluntary', 'erp' ),
        'involuntary' => __( 'Involuntary', 'erp' )
    ] );

    if ( $selected ) {
        return ( isset( $type[$selected] ) ) ? $type[$selected] : '';
    }

    return $type;
}

/**
 * Get Terminate Reason
 *
 * @return array all the reason
 */
function erp_companyview_get_terminate_reason( $selected = NULL ) {
    $reason = apply_filters( 'erp_hr_terminate_reason', [
        'attendance'            => __( 'Attendance', 'erp' ),
        'better_employment'     => __( 'Better Employment Conditions', 'erp' ),
        'career_prospect'       => __( 'Career Prospect', 'erp' ),
        'death'                 => __( 'Death', 'erp' ),
        'desertion'             => __( 'Desertion', 'erp' ),
        'dismissed'             => __( 'Dismissed', 'erp' ),
        'dissatisfaction'       => __( 'Dissatisfaction with the job', 'erp' ),
        'higher_pay'            => __( 'Higher Pay', 'erp' ),
        'other_employement'     => __( 'Other Employment', 'erp' ),
        'personality_conflicts' => __( 'Personality Conflicts', 'erp' ),
        'relocation'            => __( 'Relocation', 'erp' ),
        'retirement'            => __( 'Retirement', 'erp' ),
    ] );

    if ( $selected ) {
        return ( isset( $reason[$selected] ) ) ? $reason[$selected] : '';
    }

    return $reason;
}

/**
 * Get Terminate Reason
 *
 * @return array all the reason
 */
function erp_companyview_get_terminate_rehire_options( $selected = NULL ) {
    $reason = apply_filters( 'erp_hr_terminate_rehire_option', array(
        'yes'         => __( 'Yes', 'erp' ),
        'no'          => __( 'No', 'erp' ),
        'upon_review' => __( 'Upon Review', 'erp' )
    ) );

    if ( $selected ) {
        return ( isset( $reason[$selected] ) ) ? $reason[$selected] : '';
    }

    return $reason;
}

/**
 * Employee terminated action
 *
 * @since 1.0
 *
 * @param  array $data
 *
 * @return void | WP_Error
 */
function erp_companyview_employee_terminate( $data ) {

    if ( ! $data['terminate_date'] ) {
        return new WP_Error( 'no-date', 'Termination date is required' );
    }

    if ( ! $data['termination_type'] ) {
        return new WP_Error( 'no-type', 'Termination type is required' );
    }

    if ( ! $data['termination_reason'] ) {
        return new WP_Error( 'no-reason', 'Termination reason is required' );
    }

    if ( ! $data['eligible_for_rehire'] ) {
        return new WP_Error( 'no-eligible-for-rehire', 'Eligible for rehire field is required' );
    }

    $result = \WeDevs\ERP\HRM\Models\Employee::where( 'user_id', $data['employee_id'] )->update( [ 'status'=>'terminated', 'termination_date' => $data['terminate_date'] ] );

    $comments = sprintf( '%s: %s; %s: %s; %s: %s',
                        __( 'Termination Type', 'erp' ),
                        erp_hr_get_terminate_type( $data['termination_type'] ),
                        __( 'Termination Reason', 'erp' ),
                        erp_hr_get_terminate_reason( $data['termination_reason'] ),
                        __( 'Eligible for Hire', 'erp' ),
                        erp_hr_get_terminate_rehire_options( $data['eligible_for_rehire'] ) );

    erp_hr_employee_add_history( [
        'user_id'  => $data['employee_id'],
        'module'   => 'employment',
        'category' => '',
        'type'     => 'terminated',
        'comment'  => $comments,
        'data'     => '',
        'date'     => $data['terminate_date']
    ] );

    update_user_meta( $data['employee_id'], '_erp_hr_termination', $data );

    return $result;
}

/**
 * Get marital statuses
 *
 * @return array all the statuses
 */
function erp_companyview_get_genders( $select_text = null ) {

    if ( $select_text ) {
        $genders = array(
            '-1'     => $select_text,
            'male'   => __( 'Male', 'erp' ),
            'female' => __( 'Female', 'erp' ),
            'other'  => __( 'Other', 'erp' )
        );
    } else {
        $genders = array(
            'male'   => __( 'Male', 'erp' ),
            'female' => __( 'Female', 'erp' ),
            'other'  => __( 'Other', 'erp' )
        );
    }

    return apply_filters( 'erp_hr_genders', $genders );
}

/**
 * Get marital statuses
 *
 * @return array all the statuses
 */
function erp_companyview_get_pay_type() {
    $types = array(
        'hourly'   => __( 'Hourly', 'erp' ),
        'daily'    => __( 'Daily', 'erp' ),
        'weekly'   => __( 'Weekly', 'erp' ),
        'monthly'  => __( 'Monthly', 'erp' ),
        'yearly'   => __( 'Yearly', 'erp' ),
        'contract' => __( 'Contract', 'erp' ),
    );

    return apply_filters( 'erp_hr_pay_type', $types );
}

/**
 * Get marital statuses
 *
 * @return array all the statuses
 */
function erp_companyview_get_pay_change_reasons() {
    $reasons = array(
        'promotion'   => __( 'Promotion', 'erp' ),
        'performance' => __( 'Performance', 'erp' ),
        'increment'   => __( 'Increment', 'erp' )
    );

    return apply_filters( 'erp_hr_pay_change_reasons', $reasons );
}

/**
 * Add a new item in employee history table
 *
 * @param  array   $args
 *
 * @return void
 */
function erp_companyview_employee_add_history( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'user_id'  => 0,
        'module'   => '',
        'category' => '',
        'type'     => '',
        'comment'  => '',
        'data'     => '',
        'date'     => current_time( 'mysql' )
    );

    $data = wp_parse_args( $args, $defaults );
    $format = array(
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'
    );

    $wpdb->insert( $wpdb->prefix . 'erp_hr_employee_history', $data, $format );
}

/**
 * Remove an item from the history
 *
 * @param  int  $history_id
 *
 * @return bool
 */
function erp_companyview_employee_remove_history( $history_id ) {
    global $wpdb;

    return $wpdb->delete( $wpdb->prefix . 'erp_hr_employee_history', array( 'id' => $history_id ) );
}

/**
 * Get Employee Announcement List
 *
 * @since 0.1
 *
 * @param  integer $user_id
 *
 * @return array
 */
function erp_companyview_employee_dashboard_announcement( $user_id ) {
    global $wpdb;

    return erp_array_to_object( \WeDevs\ERP\HRM\Models\Announcement::join( $wpdb->posts, 'post_id', '=', $wpdb->posts . '.ID' )
            ->where( 'user_id', '=', $user_id )
            ->orderby( $wpdb->posts . '.post_date', 'desc' )
            ->take(8)
            ->get()
            ->toArray() );
}

/**
 * [erp_hr_employee_single_tab_general description]
 *
 * @return void
 */
function erp_companyview_employee_single_tab_general( $employee ) {
    include WPERP_HRM_VIEWS . '/employee/tab-general.php';
}

/**
 * [erp_hr_employee_single_tab_job description]
 *
 * @return void
 */
function erp_companyview_employee_single_tab_job( $employee ) {
    include WPERP_HRM_VIEWS . '/employee/tab-job.php';
}

/**
 * [erp_hr_employee_single_tab_leave description]
 *
 * @return void
 */
function erp_companyview_employee_single_tab_leave( $employee ) {
    include WPERP_HRM_VIEWS . '/employee/tab-leave.php';
}

/**
 * [erp_hr_employee_single_tab_notes description]
 *
 * @return void
 */
function erp_companyview_employee_single_tab_notes( $employee ) {
    include WPERP_HRM_VIEWS . '/employee/tab-notes.php';
}

/**
 * [erp_hr_employee_single_tab_performance description]
 *
 * @return void
 */
function erp_companyview_employee_single_tab_performance( $employee ) {
    include WPERP_HRM_VIEWS . '/employee/tab-performance.php';
}

/**
 * [erp_hr_employee_single_tab_permission description]
 *
 * @return void
 */
function erp_companyview_employee_single_tab_permission( $employee ) {
    include WPERP_HRM_VIEWS . '/employee/tab-permission.php';
}

