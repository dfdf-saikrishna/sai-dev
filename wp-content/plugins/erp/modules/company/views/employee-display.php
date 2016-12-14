<?php
global $wpdb;
$empid = $_GET['empid'];
$compid = $_SESSION['compid'];

$rowcomp = $wpdb->get_results("SELECT * FROM employees emp, admin adm, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.EMP_Id='$empid' AND emp.ADM_Id=adm.ADM_Id AND emp.EG_Id=eg.EG_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id");
?>
<style type="text/css">
    #my_centered_buttons { text-align: center; width:100%;}
</style>
<div class="postbox">
    <div class="inside">
        <h2><?php _e('Employees Profile Display', 'employee'); ?></h2>
        <code>View EMPLOYEE DETAILS </code>
        <div class="wrap pre-travel-request" id="wp-erp">
            <div style="margin-top:30px;">
               
                <div class="inside" style="margin:0 0 0 80%;">
                    <span class="field">
                        Added by: <?php echo $rowcomp[0]->ADM_Name; ?>
                    </span>
                </div>
                 <div class="inside" style="margin:0 0 0 80%;">
                    <span class="field">
                       Added on:<?php echo date('d-M-Y', strtotime($rowcomp[0]->EMP_Regdate)); ?>
                    </span>
                </div>
                <form class="form-horizontal" method="post" id="Employeenew" name="Employeenew" action="admin-employees-edit.php?empid=<?php echo $empid; ?>" data-collabel="3" data-alignlabel="left" parsley-validate enctype="multipart/form-data">
                    <div class="postbox">
                        <?php
                        if ($rowcomp[0]->EMP_Photo)
                            $src = 'upload/' . $compid . '/photographs/' . $rowcomp[0]->EMP_Photo;
                        else
                            $src = "E:\xampp\htdocs\wordpress\wp-content\plugins\erp\assets\images\no_image.jpg";
                        //echo $src;
                        ?>
                        <div class="inside">
                            <?php erp_html_form_label(__('Employee photo upload', 'erp'), 'photo-title', true); ?>
                            <div><img src="<?php echo $src; ?>" width="200"/></div>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Employee Name', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EMP_Name; ?>"  required  style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Employee Code', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EMP_Code; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Grade', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EG_Name; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Department', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->DEP_Name; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Designation', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->DES_Name; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Email', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EMP_Email; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Mobile No.', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EMP_Phonenumber; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Mobile No.', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EMP_Phonenumber2; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Mobile No.', 'erp'), 'emp-title', true); ?>
                            <span class="field">
                                <input value="<?php echo $rowcomp[0]->EMP_Reprtnmngrcode; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                            </span>
                        </div>
                        <div class="inside">
                            <?php erp_html_form_label(__('Reporting Manager Name', 'erp'), 'emp-title', true); ?>
                            <span class="field">

                                <?php
                                $code = $rowcomp[0]->EMP_Reprtnmngrcode;
                                if ($rowsql = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code'")) {
                                    ?>
                                    <input value="<?php echo $rowcomp[0]->EMP_Name; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                                    <? } ?>  
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Reporting Functional Manager Code', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->EMP_Funcrepmngrcode; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Reporting Functional Manager Name', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <?php
                                    $code = $rowcomp[0]->EMP_Reprtnmngrcode;
                                    if ($rowsql = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code'")) {
                                        ?>
                                        <input value="<?php echo $rowcomp[0]->EMP_Name; ?>"  required style="margin:0 0 0 12%;width:25%;" >
                                    <?PHP } ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group offset">
                            <!--                            <div>
                                                            <button type="submit" name="addnewEmployee" id="addnewEmployee" class="button-primary">Edit</button>
                                                            <button type="reset" class="btn" onClick="javascript:window.history.back();">Back</button>
                                                        </div>-->
                        </div>
                </div>
            </div>
            </form>


            <!-- //content-->
        </div>
    <?php } ?>
