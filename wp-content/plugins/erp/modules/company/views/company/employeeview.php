<?php
$selectEmployee = $_REQUEST['selectEmployee'];

$profilemanage = $_REQUEST['profilemanage'];
echo $profilemanage;

$compid = $_SESSION['compid'];

$imdir = 'upload/' . $compid . '/photographs/';
?>
<div class="wrap erp erp-company-employees erp-hr-company">
    <h2 class="erp-hide-print"><?php _e('Employee Profile View', 'erp'); ?> </h2>
    <div class="erp-single-container erp-company-employees-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-company-employees-wrap-inner">
            <div id="erp-area-left-inner">
                <div class="postbox">
                    <div class="inside">
                        <ul class="form-fields two-col">
                            <li class="erp-hr-js-department" style="text-align:center;" data-selected="<?php echo $employeeview->EMP_Id; ?>">
                                <?php
                                $getEmployees = get_employee_list();
                                $count = count($getEmployees);
                                ?>
                                <h3>Employee's Profile Details </h3><select id="selectEmployee" required name="employee_id" value="<?php echo $employeeview->EMP_Id; ?>" class="" tabindex="-1" aria-hidden="true">
                                    <option value="0">Search</option>
                                    <?php for ($i = 0; $i < $count; $i++) { ?>
                                        <option value="<?php echo $getEmployees[$i]->EMP_Id; ?>"><?php echo $getEmployees[$i]->EMP_Code . " (" . $getEmployees[$i]->EMP_Name . ")"; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="profilemanage" id="profilemanage">
                                    <option value="-1">All</option>
                                    <option value="1" <?php if ($profilemanage == 1) echo 'selected="selected"'; ?> >Profile Details</option>
                                    <option value="2" <?php if ($profilemanage == 2) echo 'selected="selected"'; ?>>Family Members</option>
                                    <option value="3" <?php if ($profilemanage == 3) echo 'selected="selected"'; ?> >Driving License</option>
                                    <option value="4" <?php if ($profilemanage == 4) echo 'selected="selected"'; ?>>Bank Account Details</option>
                                    <option value="5" <?php if ($profilemanage == 5) echo 'selected="selected"'; ?>>Passport Details</option>
                                    <option value="6" <?php if ($profilemanage == 6) echo 'selected="selected"'; ?> >Visa Details</option>
                                    <option value="7" <?php if ($profilemanage == 7) echo 'selected="selected"'; ?>>Frequent Flying Details</option>
                                    <option value="8" <?php if ($profilemanage == 8) echo 'selected="selected"'; ?>>Medical Information</option>
                                </select>
                                <button type="submit" name="employeesubmit" id="employeesubmit" class="button button-primary">Submit</button>
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
                                        <li><b>Emp Code :</b>&nbsp&nbsp<span class="title" id="EMP_Code"></span></li>
                                        <li><b>Email Id:</b>&nbsp&nbsp<span class="title" id="EMP_Email"></span></li>
                                    </ul>
                                </div><!-- .erp-user-info -->
                        </ul>
                    </div>
                </div>
                <div>
                    <?php
                    /* -------------------------
                      PERSONAL INFORMATION
                      /------------------------- */

                    if (($selectEmployee && ($profilemanage == 1)) || ($selectEmployee && ($profilemanage == -1))) {

                        if ($resultd_details = $wpdb->get_results("SELECT * FROM  personal_information pi, state st, city ci Where EMP_Id='$selectEmployee' AND PI_Status=1 AND pi.STA_Id=st.STA_Id AND pi.city_id=ci.city_id")) {
                            ?>
                            <br>
                            <h3>PERSONAL INFORMATION</h3>
                            <br>
                            <div id="postbox leads-actions">
                                <div class="col-sm-4 h4"> Gender </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['PI_Gender'] ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> Date of Birth </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo date('d/m/Y', strtotime($resultd_details['PI_DateofBirth'])); ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> My Personal Email-Id </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['PI_Email'] ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> Meal Prefered </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['PI_MealPreference'] ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> Present Address </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo stripslashes(nl2br($resultd_details['PI_CurrentAddress'])) ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> State</div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['STA_Name'] ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> City</div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['city_name'] ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> Meal Prefered </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['PI_MealPreference'] ?> </div>
                                <br />
                                <br />
                                <div class="clearfix"></div>
                                <div class="col-sm-4 h4"> Pincode </div>
                                <div class="col-sm-1"> : </div>
                                <div class="col-sm-5 h4"> <?php echo $resultd_details['PI_Pincode'] ?> </div>
                            </div>
                            <?php
                        } else {
                            echo '<div class="center"><div class="alert alert-warning">No Records Found</div></div>';
                        }
                    }
                    ?>
                </div>
            </div><!-- .erp-profile-top -->

        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>