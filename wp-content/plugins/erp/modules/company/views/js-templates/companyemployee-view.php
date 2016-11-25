<div class="wrap erp erp-hr-employees erp-hr-company">
    <h2 class="erp-hide-print"><?php _e( 'Employee Profile', 'erp' );?> </h2>
    <div class="erp-single-container erp-hr-employees-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-employees-wrap-inner">
            <div id="erp-area-left-inner">
		<ul class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected="<?php echo $employeeview->EMP_Id; ?>">
            <?php $getEmployees = get_employee_list(); 
                  $count = count($getEmployees);
                  ?>
           <select id="selectEmployee" required name="employee_id" value="<?php echo $employeeview->EMP_Id; ?>" class="" tabindex="-1" aria-hidden="true">
           <option value="">-SELECT Employee-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getEmployees[$i]->EMP_Id; ?>"><?php echo $getEmployees[$i]->EMP_Code ." (".$getEmployees[$i]->EMP_Name .")" ; ?></option>
               <?php } ?>
           </select>
		    <button type="submit" name="employeesubmit" id="employeesubmit" class="button button-primary">Submit</button>
         </li>  
		</ul>
		 <script type="text/javascript">
                 window.wpErpCurrentEmployeeview = <?php echo json_encode( $employeeview->to_array() ); ?>
         </script>
                <div class="erp-profile-top" id="employeeview" style="display:none">
                    <div class="erp-avatar" id="EMP_Photo">
                       <img src="<?php echo $employeeview->EMP_Photo; ?>" width="100px" />
				   </div>

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

                    <?php //do_action( 'erp_hr_employee_single_after_info', $companyview ); ?>

                </div><!-- .erp-profile-top -->
        
        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
</div>