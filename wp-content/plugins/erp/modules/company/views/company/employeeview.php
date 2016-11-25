<div class="wrap erp erp-hr-employees erp-hr-company">
    <h2 class="erp-hide-print"><?php _e( 'Employee Profile', 'erp' );?> </h2>
    <div class="erp-single-container erp-hr-employees-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-employees-wrap-inner">
            <div id="erp-area-left-inner">
			<div class="postbox">
			<div class="inside">
		<ul class="form-fields two-col">
         <li class="erp-hr-js-department" style="text-align:center;" data-selected="<?php echo $employeeview->EMP_Id; ?>">
            <?php $getEmployees = get_employee_list(); 
                  $count = count($getEmployees);
                  ?>
          <h3>Company Employees </h3><select id="selectEmployee" required name="employee_id" value="<?php echo $employeeview->EMP_Id; ?>" class="" tabindex="-1" aria-hidden="true">
           <option value="">-SELECT Employee-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getEmployees[$i]->EMP_Id; ?>"><?php echo $getEmployees[$i]->EMP_Code ." (".$getEmployees[$i]->EMP_Name .")" ; ?></option>
               <?php } ?>
           </select>
		    <!--<button type="submit" name="employeesubmit" id="employeesubmit" class="button button-primary">Submit</button>-->
         </li>  
		</ul>
		</div></div>
		 <div class="postbox leads-actions" id="employeeview" style="display:none" >
		 <div class="inside">
		 <ul class="erp-list">
                <div class="erp-profile-top" >
                    <div class="erp-avatar" id="EMP_Photo"></div>
                    <div class="erp-user-info" >
                        <h3><span class="title" id="EMP_Name"></span></h3>
                        <ul class="lead-info">
                           <li><span class="title" id="EMP_Code"></span></li>
							<li><span class="title" id="EG_Name"></span></li>
							<li><span class="title" id="DEP_Name"></span></li>
							<li><span class="title" id="DES_Name"></span></li>
							<li><span class="title" id="EMP_Email"></span></li>
							<li><span class="title" id="EMP_Phonenumber"></span></li>
							<li><span class="title" id="EMP_Phonenumber2"></span></li>
							<li><span class="title" id="EMP_Reprtnmngrcode"></span></li>
							<li><span class="title" id="EMP_Funcrepmngrcode"></span></li>
			
                        </ul>
				<div style="width:100%"><?php //do_action( 'erp_hr_employee_single_after_info', $employeeview ); ?>
					 <?php
                $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';
				?>
				
				<?php 
                $tabs       = apply_filters( 'erp_hr_employee_single_tabs', array(
                    'general' => array(
                        'title'    => __( 'General & Family Info', 'erp' ),
                        'callback' => 'erp_hr_comapnyemployee_single_tab_general'
                    ),
                    'bankaccount' => array(
                        'title'    => __( 'Bank Account Details', 'erp' ),
                        'callback' => 'erp_hr_employee_single_tab_notes'
                    ),
					'passport' => array(
                        'title'    => __( 'Passport & Visa & Frequent Flying Details', 'erp' ),
                        'callback' => 'erp_hr_employee_single_tab_performance'
                    ),
					'medicalinfo' => array(
                        'title'    => __( 'Medical Information', 'erp' ),
                        'callback' => 'erp_hr_employee_single_tab_permission'
                    ),
                   
					), 'employee');

                if ( ! current_user_can( 'companyadmin' ) && isset( $tabs['permission'] ) && isset( $tabs['performance'] ) && isset( $tabs['notes'] ) ) {
                    unset( $tabs['permission'] );
                    unset( $tabs['performance'] );
                    unset( $tabs['notes'] );
                }

                if ( ! current_user_can( 'companyadmin', $employeeview->EMP_Id ) ) {
                    unset( $tabs['leave'] );
                    unset( $tabs['job'] );
                }
                ?>

                <h2 class="nav-tab-wrapper erp-hide-print" style="width:800px;">
                    <?php foreach ($tabs as $key => $tab) {
                        $active_class = ( $key == $active_tab ) ? ' nav-tab-active' : '';
						
                        ?>
						<input type="hidden" value="<?php echo $key ?>" id="key">
                        <a id="tabs" class="nav-tab<?php echo $active_class; ?>"><?php echo $tab['title'] ?></a>
                    <?php } ?>
                </h2>

                <?php
                // call the tab callback function
              //  if ( array_key_exists( $active_tab, $tabs ) && is_callable( $tabs[$active_tab]['callback'] ) ) {
               //     call_user_func_array( $tabs[$active_tab]['callback'], array( $employeeview ) );
              //  }
                ?>

                <?php //do_action( 'erp_hr_employee_single_bottom', $employeeview ); ?>
				   </div>
                    </div><!-- .erp-user-info -->

                    <div class="erp-area-right erp-hide-print">
                        <div class="postbox leads-actions">
                            <h3 class="hndle"><span><?php _e( 'Actions', 'erp' ); ?></span></h3>
                            <div class="inside">
                                <?php
                                if ( current_user_can( 'companyadmin', $employeeview->id )) {
                                    ?>
                                    <span class="edit">
									<a class="button button-primary" href="?page=menu" data-id="<?php echo $employeeview->id; ?>"><?php _e( 'Edit', 'employees_table_list' ); ?></a></span>
									<?php	
                                }
                                ?>
                                   <a class="button" id="erp-employee-print" href="#"><?php _e( 'Print', 'employees_table_list' ); ?></a>
                            </div>
                        </div><!-- .postbox -->
                    </div><!-- .leads-right -->
			</ul>
		</div>
		</div>
         

                </div><!-- .erp-profile-top -->
        
        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
</div>