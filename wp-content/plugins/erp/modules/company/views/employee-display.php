<?php
global $wpdb;
$empid = $_GET['empid'];
$compid = $_SESSION['compid'];

$rowcomp = $wpdb->get_results("SELECT * FROM employees emp, admin adm, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.EMP_Id='$empid' AND emp.ADM_Id=adm.ADM_Id AND emp.EG_Id=eg.EG_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id");
?>
<div class="postbox">
    <div class="inside">
        <h2><?php _e('Employees Profile Display', 'employee'); ?></h2>
        <code>VIEW EMPLOYEE DETAILS </code>
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
                <form class="form-horizontal" method="post" id="Employeenew" name="Employeenew" action="#?empid=<?php echo $empid; ?>" data-collabel="3" data-alignlabel="left" parsley-validate enctype="multipart/form-data">
                    <div class="postbox" >
                        <?php
                        if ($rowcomp[0]->EMP_Photo)
                            $src = '' . $rowcomp[0]->EMP_Photo . ' " class="avatar avatar-150 photo" height="150" width="150"';
                        else
                            $src =  'alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-150 photo"height="150" width="150"';
                        //echo $src;
                        ?>
                        <div class="inside">
                            <?php erp_html_form_label(__('Employee photo upload', 'erp'), 'photo-title', true); ?>
                            <div><span style="margin:0 0 0 421px;"><img src="<?php echo $src; ?></span>
                                      </div>
                        </div>
                        <ul class="erp-form-fields erp-list">
                            <li class="erp-form-field row-first-name">
                                <div class="inside">
                                    <lable>Employee Name </lable>
                                    <span class="field">
                                        <input value="<?php echo $rowcomp[0]->EMP_Name; ?>" class="regular-text" required  readonly style="margin:0 0 0 259px;width:25%;">
                                    </span>
                                </div>
                            </li>
                            <div class="inside">
                                <li class="erp-form-field row-emp-title">
                                <lable>Employee Code</lable>
                                    <span class="field">
                                    <input  class="regular-text" value="<?php echo $rowcomp[0]->EMP_Code; ?>"  required readonly style="margin:0 0 0 263px;width:25%;"></span>
                            </div>
                            </li>
                            <div class="inside">
                                <lable> Grade</lable>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->EG_Name; ?>" class="regular-text" required readonly style="margin:0 0 0 320px;width:25%;">
                                </span>
                            </div>
                            <div class="inside">
                                  <lable> Department</lable>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->DEP_Name; ?>"  required readonly class="regular-text" style="margin:0 0 0 286px;width:25%;">
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Designation', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->DES_Name; ?>"  required readonly class="regular-text" style="margin:0 0 0 277px;width:25%;">
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Email', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->EMP_Email; ?>"  required readonly class="regular-text" style="margin:0 0 0 316px;width:25%;">
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Mobile No.', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->EMP_Phonenumber; ?>"  required readonly class="regular-text" style="margin:0 0 0 283px;width:25%;" >
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Landline No.', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->EMP_Phonenumber2; ?>"  required readonly style="margin:0 0 0 275px;width:25%;"  >
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Reporting Manager Code', 'erp'), 'emp-title', true); ?>
                                <span class="field">
                                    <input value="<?php echo $rowcomp[0]->EMP_Reprtnmngrcode; ?>"  required readonly class="regular-text" style="margin:0 0 0 201px;width:25%;">
                                </span>
                            </div>
                            <div class="inside">
                                <?php erp_html_form_label(__('Reporting Manager Name', 'erp'), 'emp-title', true); ?>
                                <span class="field">

                                    <?php
                                    $code = $rowcomp[0]->EMP_Reprtnmngrcode;
                                    if ($rowsql = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code'")) {
                                        ?>
                                        <input value="<?php echo $rowcomp[0]->EMP_Name; ?>"  required readonly class="regular-text" style="margin:0 0 0 196px;width:25%;">
                                        <? } ?>  
                                    </span>
                                </div>
                                <div class="inside">
                                    <?php erp_html_form_label(__('Reporting Functional Manager Code', 'erp'), 'emp-title', true); ?>
                                    <span class="field">
                                        <input value="<?php echo $rowcomp[0]->EMP_Funcrepmngrcode; ?>"  required readonly class="regular-text" style="margin:0 0 0 138px;width:25%;">
                                    </span>
                                </div>
                                <div class="inside">
                                    <?php erp_html_form_label(__('Reporting Functional Manager Name', 'erp'), 'emp-title', true); ?>
                                    <span class="field">
                                        <?php
                                        $code = $rowcomp[0]->EMP_Funcrepmngrcode;
                                        if ($rowsql = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code'")) {
                                            ?>
                                            <input value="<?php echo $rowcomp[0]->EMP_Name; ?>"  required readonly class="regular-text" style="margin:0 0 0 133px;width:25%;">
                                        <?PHP } ?>
                                    </span>
                            </ul>
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
