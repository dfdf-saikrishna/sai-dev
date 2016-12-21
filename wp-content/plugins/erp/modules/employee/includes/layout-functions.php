<?php
        /**
	 * Show Extra Profile Fields
	 */
        function my_show_extra_profile_fields( $user ) {                     
            global $wpdb;
            $compid = $_SESSION['compid'];
            $empid = $_SESSION['empuserid'];
            $rowcomp = $wpdb->get_row("SELECT * FROM employees emp, admin adm, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.EMP_Id='$empid' AND emp.ADM_Id=adm.ADM_Id AND emp.EG_Id=eg.EG_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id");

            ?>
                <h3>Personal Contact information</h3>

                <table class="form-table">

                    <tr>
                        <th><label for="paypal_account">Phone</label></th>

                        <td>
                            <input type="text" name="phone" id="phone" value="<?php echo $rowcomp->EMP_Phonenumber; ?>" class="regular-text" /><br />
                            <span class="description">Please enter your Phone Number.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="paypal_account">Landline</label></th>

                        <td>
                            <input type="text" name="phone2" id="phone2" value="<?php echo $rowcomp->EMP_Phonenumber2; ?>" class="regular-text" /><br />
                            <span class="description">Please enter your Landline Number.</span>
                        </td>
                    </tr>

                </table>



        <?php }
        
        /**
        * Add new fields above 'Update' button.
        *
        * @param WP_User $user User object.
        */
       function additional_profile_fields( $user ) {
           if( current_user_can( 'employee' ) || current_user_can( 'finance' )){
           global $wpdb;
           $compid = $_SESSION['compid'];
           $empid = $_SESSION['empuserid'];
           $rowcomp = $wpdb->get_row("SELECT * FROM employees emp, admin adm, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.EMP_Id='$empid' AND emp.ADM_Id=adm.ADM_Id AND emp.EG_Id=eg.EG_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id");
           ?>
           <h3>Extra profile information</h3>

           <table class="form-table">
                <tr>
                        <th><label for="birth-date-day">Employee Code</label></th>
                        <td>
                            <?php echo $rowcomp->EMP_Code; ?>
                        </td>
                </tr>
                <tr>
                        <th><label for="birth-date-day">Grade</label></th>
                        <td>
                            <?php echo $rowcomp->EG_Name; ?>
                        </td>
                </tr>
                <tr>
                        <th><label for="birth-date-day">Department</label></th>
                        <td>
                            <?php echo $rowcomp->DEP_Name; ?>
                        </td>
                </tr>
                <tr>
                        <th><label for="birth-date-day">Designation</label></th>
                        <td>
                            <?php echo $rowcomp->DES_Name; ?>
                        </td>
                </tr>
                <tr>
                        <th><label for="birth-date-day">Reporting Manager Code</label></th>
                        <td>
                            <?php echo $rowcomp->EMP_Reprtnmngrcode; ?>
                        </td>
                </tr>
                <tr>
                        <th><label for="birth-date-day">Reporting Manager Name</label></th>
                        <td>
                        <?php 
                        $code = $rowcomp->EMP_Reprtnmngrcode;
                        if ($rowsql = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code'")) {
                        ?>
                         <?php echo $rowcomp->EMP_Name; ?>
                        <?php } ?>
                        </td>
                        </tr>
                        <tr>
                        <th><label for="birth-date-day">Reporting Functional Manager Code</label></th>
                        <td>
                            <?php echo $rowcomp->EMP_Funcrepmngrcode; ?>
                        </td>
                        </tr>
                        <tr>
                        <th><label for="birth-date-day">Reporting Functional Manager Name</label></th>
                        <td>
                        <?php 
                        $code = $rowcomp->EMP_Funcrepmngrcode;
                        if ($rowsql = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code'")) {
                        ?>
                         <?php echo $rowcomp->EMP_Name; ?>
                        <?php } ?>
                        </td>
                        </tr>
                        </table>
                        <?php
                        }
                    }
                    /**
                    * Save Custom Profile Fields
                    */
                    function my_save_extra_profile_fields( $user_id ) {
                        global $wpdb;
                        $compid = $_SESSION['compid'];
                        $empid = $_SESSION['empuserid'];
                        $rowcomp = $wpdb->get_row("SELECT * FROM employees emp, admin adm, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.EMP_Id='$empid' AND emp.ADM_Id=adm.ADM_Id AND emp.EG_Id=eg.EG_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id");
                        if( current_user_can( 'employee' ) || current_user_can( 'finance' )){
                    

                        /* Copy and paste this line for additional fields. Make sure to change 'paypal_account' to the field ID. */
                        $wpdb->update( 'employees', array( 'EMP_Phonenumber' => $_POST['phone'], 'EMP_Phonenumber2' => $_POST['phone2']), array( 'EMP_Id' => $rowcomp->EMP_Id ));
                        //update_user_meta( $user_id, 'phone', $_POST['phone'] );
                        }
                    }
?>