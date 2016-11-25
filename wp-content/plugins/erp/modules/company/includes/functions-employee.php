<?php
//use WeDevs\ERP\Corptne\includes\Models\Employeelist;
/**
 * Delete an employee if removed from WordPress usre table
 *
 * @param  int  the user id
 *
 * @return void
 */
function erp_cr_employee_on_delete( $user_id, $hard = 0 ) {
    global $wpdb;

    $user = get_user_by( 'id', $user_id );

    if ( ! $user ) {
        return;
    }

    $role = reset( $user->roles );

    if ( 'employee' == $role ) {
        \WeDevs\ERP\HRM\Models\Employee::where( 'user_id', $user_id )->withTrashed()->forceDelete();
    }
}

function companyemployee_create( $args = array() ) {
    global $wpdb;

    $defaults = array(
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
        );

    // if user id exists, do an update
    $user_id = isset( $data['companyemployee']['user_id'] ) ? intval( $data['companyemployee']['user_id'] ) : 0;
    $update  = false;

    if ( $user_id ) {
        $update = true;
        $userdata['ID'] = $user_id;

    } else {
        // when creating a new user, assign role and passwords
        $userdata['user_pass'] = wp_generate_password( 12 );
        $userdata['role'] = 'employee';
    }

    //$userdata = apply_filters( 'erp_hr_employee_args', $userdata );
    
     $avatar_url = wp_get_attachment_url( $data['companyemployee']['photo_id'] );
	
    if ( is_wp_error( $user_id ) ) {
        return $user_id;
    }
	$compid = $_SESSION['compid'];
	$admid = $_SESSION['adminid'];
    //$admid = $_SESSION['']; 
	$companyemployee_data = array(
        'COM_Id' =>$compid,
        'ADM_ID' =>$admid,
        'user_id' => $user_id,
        'DEP_Id' => $data['companyemployee']['selDep'],
        'DES_Id' => $data['companyemployee']['selDes'],
        'EMP_Code'   => $data['companyemployee']['txtEmpcode'],
        'EG_Id'  => $data['companyemployee']['selGrade'],
        'EMP_Email'   => $data['companyemployee']['txtempemail'],
		'EMP_Phonenumber'=>$data['companyemployee']['txtempmob'],
		'EMP_Phonenumber2'=>$data['companyemployee']['txtemplandline'],
        'EMP_Name' => $data['companyemployee']['txtEmpname'],
        'EMP_Reprtnmngrcode'  => $data['companyemployee']['txtRepmngrcode'],
        'EMP_Funcrepmngrcode' => $data['companyemployee']['txtRepfuncmngrcode'],
        'Added_Mode' => '2',
        'EMP_PhotoId' => $data['companyemployee']['photo_id'],
		'EMP_Photo' => $avatar_url, 
    );
    if($update){
       $tablename = "employees";
       $companyemployee_data['user_id'] = $user_id;
       $wpdb->update( $tablename,$companyemployee_data,array( 'user_id' => $user_id ));    
    }
    else{ 
    $user_id  = wp_insert_user( $userdata );
    $tablename = "employees";
    $companyemployee_data['user_id'] = $user_id;
    $wpdb->insert( $tablename, $companyemployee_data);
    return $user_id;
    }
	
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
function erp_cr_get_employees( $args = array() ) {
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

    $employee = new \WeDevs\ERP\HRM\Models\Employee();
    $employee_result = $employee->leftjoin( $wpdb->users, 'user_id', '=', $wpdb->users . '.ID' )->select( array( 'user_id', 'display_name' ) );

    if ( isset( $args['designation'] ) && $args['designation'] != '-1' ) {
        $employee_result = $employee_result->where( 'designation', $args['designation'] );
    }

    if ( isset( $args['department'] ) && $args['department'] != '-1' ) {
        $employee_result = $employee_result->where( 'department', $args['department'] );
    }

    if ( isset( $args['location'] ) && $args['location'] != '-1' ) {
        $employee_result = $employee_result->where( 'location', $args['location'] );
    }

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
function erp_cr_count_employees() {

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
 * Employee Restore from trash
 *
 * @since 0.1
 *
 * @param  array|int $employee_ids
 *
 * @return void
 */
function crp_employee_restore( $employeelist_ids ) {
    if ( empty( $employeelist_ids ) ) {
        return;
    }

    if ( is_array( $employeelist_ids ) ) {
        foreach ( $employeelist_ids as $key => $user_id ) {
            \WeDevs\ERP\HRM\Models\Employee::withTrashed()->where( 'user_id', $user_id )->restore();
        }
    }

    if ( is_int( $employeelist_ids ) ) {
        \WeDevs\ERP\HRM\Models\Employee::withTrashed()->where( 'user_id', $employeelist_ids )->restore();
    }
}

/**
 * Employee Delete
 *
 * @param  array|int $employee_ids
 *
 * @return void
 */
function crp_employee_delete( $employeelist_ids, $hard = false ) {

    if ( empty( $employeelist_ids ) ) {
        return;
    }

    $employeeslist = [];

    if ( is_array( $employeelist_ids ) ) {
        foreach ( $employeelist_ids as $key => $user_id ) {
            $employeeslist[] = $user_id;
        }
    } else if ( is_int( $employeelist_ids ) ) {
        $employeeslist[] = $employeelist_ids;
    }

    // still do we have any ids to delete?
    if ( ! $employeeslist ) {
        return;
    }

    // seems like we got some
    foreach ($employeeslist as $employeelist_id) {

        do_action( 'erp_hr_delete_employee', $employeelist_id, $hard );

        if ( $hard ) {
            \WeDevs\ERP\HRM\Models\Employee::where( 'user_id', $employeelist_id )->withTrashed()->forceDelete();
            wp_delete_user( $employeelist_id );

            // find leave entitlements and leave requests and delete them as well
            \WeDevs\ERP\HRM\Models\Leave_request::where( 'user_id', '=', $employeelist_id )->delete();
            \WeDevs\ERP\HRM\Models\Leave_Entitlement::where( 'user_id', '=', $employeelist_id )->delete();

        } else {
            \WeDevs\ERP\HRM\Models\Employee::where( 'user_id', $employeelist_id )->delete();
        }

        do_action( 'erp_hr_after_delete_employee', $employeelist_id, $hard );
    }

}



/**
 * Get the raw employeeslist dropdown
 *
 * @param  int  company id
 *
 * @return array  the key-value paired employeeslist
 */
function erp_cr_get_employees_dropdown_raw( $exclude = null ) {
    $employeeslist = erp_hr_get_employees( [ 'number' => -1 , 'no_object' => true ] );
    $dropdown  = array( 0 => __( '- Select Employee -', 'erp' ) );

    if ( $employeeslist ) {
        foreach ($employeeslist as $key => $employeeslist) {
            if ( $exclude && $employeeslist->user_id == $exclude ) {
                continue;
            }

            $dropdown[$employeeslist->user_id] = $employeeslist->display_name;
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
function erp_cr_get_employees_dropdown( $selected = '' ) {
    $employeeslist = erp_hr_get_employees_dropdown_raw();
    $dropdown  = '';

    if ( $employeeslist ) {
        foreach ($employeeslist as $key => $title) {
            $dropdown .= sprintf( "<option value='%s'%s>%s</option>\n", $key, selected( $selected, $key, false ), $title );
        }
    }

    return $dropdown;
}

/**
 * Get marital statuses
 *
 * @return array all the statuses
 */
function erp_cr_get_genders( $select_text = null ) {

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

function erp_company_url_single_reqview($employeelist_id) {

    $url = admin_url( 'admin.php?page=&action=view&id=' . $employeelist_id);

    return apply_filters( 'erp_company_url_single_reqview', $url, $employeelist_id );
}

/**
 * [erp_hr_url_single_employee description]
 *
 * @param  int  employee id
 *
 * @return string  url of the employee details page
 */
function erp_cr_url_single_employee( $employee_id, $tab = null ) {
    if ( $tab ) {
        $tab = '&tab=' . $tab;
    }

    $url = admin_url( 'admin.php?page=erp-hr-employee&action=view&id=' . $employee_id . $tab );

    return apply_filters( 'erp_hr_url_single_employee', $url, $employee_id );
}



function get_grade_list(){
	global $wpdb;
	$compid		=	$_SESSION['compid'];
	//$compid		='56';
	$gradelist = $wpdb->get_results( "SELECT EG_Id, EG_Name FROM employee_grades WHERE COM_Id='$compid' AND EG_Status=1");
	return $gradelist;
}

function get_department_list(){
	global $wpdb;
	$compid		=	$_SESSION['compid'];
	//$compid		='56';
	$deparmentlist = $wpdb->get_results( "SELECT DEP_Id, DEP_Name FROM department WHERE COM_Id='".$compid."' AND DEP_Status=1 ORDER BY DEP_Name ASC");
	return $deparmentlist;
}

function get_designation_list(){
	global $wpdb;
	$compid		=	$_SESSION['compid'];
	//$compid		='56';
	$designationlist = $wpdb->get_results( "SELECT DES_Id, DES_Name FROM designation WHERE COM_Id='".$compid."' AND DES_Status=1 ORDER BY DES_Name ASC");
	return $designationlist;
}
function get_repm_list(){
	global $wpdb;
	//$compid		='56';
	$compid		=	$_SESSION['compid'];
	$repmlist = $wpdb->get_results( "SELECT EMP_Id, EMP_Code, EMP_Name FROM employees WHERE COM_Id='".$compid."' AND EMP_Status=1");
	return $repmlist;
}

function get_frepm_list(){
	global $wpdb;
	//$compid		='56';
	$compid		=	$_SESSION['compid'];
	$frepmlist = $wpdb->get_results( "SELECT EMP_Id, EMP_Code, EMP_Name FROM employees WHERE COM_Id='".$compid."' AND EMP_Status=1");
	return $frepmlist;
}
function get_employee_list(){
	global $wpdb;
	//$compid		='56';
	$compid		=	$_SESSION['compid'];
	$emplist = $wpdb->get_results( "SELECT EMP_Id, EMP_Code, EMP_Name FROM employees WHERE COM_Id='".$compid."' AND EMP_Status=1");
	return $emplist;
}
function erp_company_url_single_employeeview($employeelist_id,$tab = null) {
		 if ( $tab ) {
				$tab = '&tab=' . $tab;
			}
    //$url = admin_url( 'admin.php?page=Profile&action=view&id=' . $employeelist_id);
	$url = admin_url( 'admin.php?page=Profile&action=view&id=' . $employeelist_id . $tab);

    return apply_filters( 'erp_company_url_single_employeeview', $url, $employeelist_id );
}
/**
 * [erp_hr_employee_single_tab_general description]
 *
 * @return void
 */
function erp_hr_comapnyemployee_single_tab_general( $employee ) {
    include WPERP_COMPANY_VIEWS . '/company/tab-general.php';
}

										