<?Php echo "djf";die; ?>
<?php do_action('erp-company-employee-single-top', $employee); ?>
//<?php
//global $wpdb;
//$selEmployee=$_GET['selectEmployee'];
//
//$resultd_details = $wpdb->get_results("SELECT * FROM  personal_information pi, state st, city ci Where EMP_Id='$selEmployee' AND PI_Status=1 AND pi.STA_Id=st.STA_Id AND pi.city_id=ci.city_id") 
//    ?>
    <?php if (current_user_can('companyadmin') || get_current_user_id() == $employeeview->EMP_Id) : ?>
        <div class="postbox leads-actions">
            <div class="handlediv" title="<?php _e('Click to toggle', 'erp'); ?>"><br></div>
            <h3 class="hndle"><span><?php _e('Personal Details', 'erp'); ?></span></h3>
            <div class="inside">
                <ul class="erp-list two-col separated">
                    <li><?php erp_print_key_value(__('Address 1', 'erp'), $employee->get_street_1()); ?></li>
                    <li><?php erp_print_key_value(__('Address 2', 'erp'), $employee->get_street_2()); ?></li>
                    <li><?php erp_print_key_value(__('City', 'erp'), $employee->get_city()); ?></li>
                    <li><?php erp_print_key_value(__('Country', 'erp'), $employee->get_country()); ?></li>
                    <li><?php erp_print_key_value(__('State', 'erp'), $employee->get_state()); ?></li>
                    <li><?php erp_print_key_value(__('Postal Code', 'erp'), $employee->get_postal_code()); ?></li>

                    <li><?php erp_print_key_value(__('Mobile', 'erp'), erp_get_clickable('phone', $employee->get_phone('mobile'))); ?></li>
                    <li><?php erp_print_key_value(__('Other Email', 'erp'), erp_get_clickable('email', $employee->other_email)); ?></li>
                    <li><?php erp_print_key_value(__('Date of Birth', 'erp'), $employee->get_birthday()); ?></li>
                    <li><?php erp_print_key_value(__('Gender', 'erp'), $employee->get_gender()); ?></li>
                    <li><?php erp_print_key_value(__('Nationality', 'erp'), $employee->get_nationality()); ?></li>
                    <li><?php erp_print_key_value(__('Marital Status', 'erp'), $employee->get_marital_status()); ?></li>
                    <li><?php erp_print_key_value(__('Driving License', 'erp'), $employee->driving_license); ?></li>
                    <li><?php erp_print_key_value(__('Hobbies', 'erp'), $employee->hobbies); ?></li>

                    <?php do_action('erp-hr-employee-single-personal', $employee); ?>
                </ul>
            </div>
        </div><!-- .postbox -->

        <?php do_action('erp-hr-employee-single-after-personal', $employee); ?>

        <?php if ($employee->get_status() == 'Terminated'): ?>

            <div class="postbox leads-actions">
                <div class="handlediv" title="<?php _e('Click to toggle', 'erp'); ?>"><br></div>
                <h3 class="hndle"><span><?php _e('Termination', 'erp'); ?></span></h3>
                <div class="inside">

                    <?php $termination_data = get_user_meta($employee->id, '_erp_hr_termination', true); ?>

                    <p><?php _e('Termination Date', 'erp'); ?> : <?php echo isset($termination_data['terminate_date']) ? erp_format_date($termination_data['terminate_date']) : ''; ?></p>
                    <p><?php _e('Termination Type', 'erp'); ?> : <?php echo isset($termination_data['termination_type']) ? erp_hr_get_terminate_type($termination_data['termination_type']) : ''; ?></p>
                    <p><?php _e('Termination Reason', 'erp'); ?> : <?php echo isset($termination_data['termination_reason']) ? erp_hr_get_terminate_reason($termination_data['termination_reason']) : ''; ?></p>
                    <p><?php _e('Eligible for Hire', 'erp'); ?> : <?php echo isset($termination_data['eligible_for_rehire']) ? erp_hr_get_terminate_rehire_options($termination_data['eligible_for_rehire']) : ''; ?></p>

                    <?php if (current_user_can('erp_edit_employee', $employee->id)) : ?>
                        <a class="button button-secondary erp-hide-print" id="erp-employee-terminate" href="#" data-id="<?php echo $employee->id; ?>" data-template="erp-employment-terminate" data-data='<?php echo json_encode($termination_data); ?>' data-title="<?php esc_attr_e('Update Termination', 'erp'); ?>" data-button="<?php esc_attr_e('Change Termination', 'erp'); ?>"><?php _e('Change Termination', 'erp'); ?></a>
                    <?php endif; ?>
                </div>
            </div><!-- .postbox -->

        <?php endif; ?>

    <?php endif; ?>

    <?php do_action('erp-hr-employee-single-bottom', $employee); ?>
