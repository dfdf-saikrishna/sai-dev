<?php
	/**
     * custom wp-admin logo
     */
	function my_loginlogo() {
	  echo '<style type="text/css">
		h1 a {
		  background-image: url(' . plugins_url() . '/erp/assets/images/logo_small.png) !important;
		  background-size: 200px !important;
		  width: 100% !important;
		}
	  </style>';
	}
	/**
	 * change wp-admin favicon
	 */
	function favicon(){
	echo '<link rel="shortcut icon" href="' . plugins_url() . '/erp/assets/images/favicon.ico" />',"\n";
	}
	/**
	 * remove Back to site link in wp-login
	 */
	function hide_login_nav()
	{
		?><style>#backtoblog{display:none}</style><?php
	}
	/**
	 * remove annoying footer thankyou from wordpress
	 */
	function hid_wordpress_thankyou() {
	  echo '<style type="text/css">#wpfooter {display:none;}</style>';
	}
	/**
	 * custom wp-admin logo hover text
	 */
	function my_loginURLtext() {
		return 'Corptne';
	}
	/**
	 * remove un-necessary menus
	 */
	function custom_menu_page_removing($user) {
		if ( current_user_can( 'employee' ) || current_user_can( 'travelagentclient' ) || current_user_can( 'traveldesk' ) || current_user_can( 'superadmin' ) || current_user_can( 'companyadmin' ) || current_user_can( 'travelagent' ) || current_user_can( 'masteradmin' ) || current_user_can( 'travelagentuser' )) {
				remove_menu_page( 'index.php' );
                                remove_menu_page( 'profile.php' );
                                remove_menu_page( 'import.php' );
                                remove_menu_page( 'upload.php' );
		}
	}
	/**
	 * Redirect to specific Dashboard page on login
	 */
	function my_login_redirect( $redirect_to, $request, $user ) {
		//is there a user to check?
		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			//check for admins
			if ( in_array( 'administrator', $user->roles ) ) {
				// redirect them to the default place
				return $redirect_to;
			}
					else if ( in_array( 'finance', $user->roles ) ) {
				return "/wp-admin/admin.php?page=finance-dashboard";
			}
					else if ( in_array( 'employee', $user->roles ) ) {
				return "/wp-admin/admin.php?page=employee";
			}
					else if ( in_array( 'travelagentclient', $user->roles ) ) {
				return "/wp-admin/admin.php?page=travelagent-dashboard";
			}
					else if ( in_array( 'traveldesk', $user->roles ) ) {
				return "/wp-admin/admin.php?page=traveldesk-dashboard";
			}
					else if ( in_array( 'superadmin', $user->roles ) ) {
				return "/wp-admin/admin.php?page=superadmin-dashboard";
			}
					else if ( in_array( 'companyadmin', $user->roles ) ) {
				return "/wp-admin/admin.php?page=company-dashboard";
			}
					else if ( in_array( 'travelagent', $user->roles ) ) {
				return "/wp-admin/admin.php?page=travelagent-dashboard";
			}
					else if ( in_array( 'masteradmin', $user->roles ) ) {
				return "/wp-admin/admin.php?page=master-dashboard";
			}
					else if ( in_array( 'travelagentuser', $user->roles ) ) {
				return "/wp-admin/admin.php?page=travelagent-user-dashboard";
			}
		} else {
			return $redirect_to;
		}
	}
        /**
	 * Store session values for Login user
	 */
        function custom_login() {
            global $wpdb;
                if ( is_user_logged_in() ) {
                    $user = wp_get_current_user();
                    if($result=$wpdb->get_row("SELECT * FROM admin WHERE user_id='$user->ID'")){
                        $_SESSION['adminid'] = $result->ADM_Id;
                        $_SESSION['compid'] = $result->COM_Id;
                        $_SESSION['username'] = $result->ADM_Username;
                        $_SESSION['adminname'] = $result->ADM_Name;
                        $_SESSION['sessionid'] = session_id();
                        //$sessionid=$_SESSION['sessionid'];
                        //$compid=$_SESSION['compid'];
                    }
                    else if($result=$wpdb->get_row("SELECT * FROM employees WHERE user_id='$user->ID'")){
                        //session of empuserid
                        $_SESSION['empuserid']=$result->EMP_Id;
                        $_SESSION['emp_code']=$result->EMP_Code;
                        //session of compid
                        $_SESSION['compid']=$result->COM_Id;
                        //session of employee name
                        $_SESSION['username']=$result->EMP_Name;
                        //session id
                        $_SESSION['sessionid']=session_id();  
                        $_SESSION['delegate']=NULL;
                    }
                  
                }
        }
        
        function custom_logout(){
            // Finally, destroy the session.
            session_destroy();
        }
?>