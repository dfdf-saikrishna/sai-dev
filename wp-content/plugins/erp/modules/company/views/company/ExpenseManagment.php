<?php
global $wpdb;
$compid = $_SESSION['compid'];
$flag = 0;
if ($selpol = $wpdb->get_results("SELECT * FROM travel_expense_policy_doc WHERE COM_Id='$compid' AND TEPD_Status=1")) {

    $flag = 1;
} else {
    $flag = 0;
}

?>
<div  class="postbox">
    <div class="inside emp-import">
        <?php if (isset($_GET['error'])) { ?>
        <div id="failure" class="notice notice-error is-dismissible">
                    <p id="p-failure">Please Upload PDF File</p>
                </div>
        <?php }?>
        
            <?php if (isset($_GET['status']) && $_GET['status'] == 'failure') { ?>
                <div id="failure" class="notice notice-error is-dismissible">
                    <p id="p-failure">File uploading error. Please choose a appropriate file (.pdf)</p>
                </div>
                <?php }  else if(isset($_GET['status']) && $_GET['status'] == 'success') { ?>
                <div id="success" class="notice notice-success is-dismissible">
                    <p id="p-success"> Uploaded successfully.</p>
                </div>
               <?php } ?>
            <h2><?php _e('Company Expense Policy', 'crp'); ?></h2>
            <?php if ($flag) { ?>
                <?php erp_html_form_label(__('Update Company Expense Policy ', 'erp'), 'expense-title', true); ?>
            <?php } else { ?>
                <?php erp_html_form_label(__('Upload Company Expense Policy ', 'erp'), 'expense-title', true); ?>
            <?php } ?>
            <form method="post" action="admin.php?page=expensemenu" enctype="multipart/form-data" id="import_pdf">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>
                                <label for="type"><?php _e('Upload Company Expense Policy Document', 'crp'); ?> <span class="required">*</span></label>
                            </th>
                            <td>
                                <div>
                                    <div id="fileDiv">
                                        <?php
                                      if(!empty($selpol)){
                                        if (!empty($selpol[0]->TEPD_Filename)) {
                                            if ($selpol[0]->TEPD_Filename) {
                                                ?>   
                                                <a href='javascript:upload()'><img src="<?php echo WPERP_COMPANY_ASSETS ?>/img/pdf-doc.png" title="click to upload new document" /> </a>
                                                <?php
                                            }    ?>
                                            <input type="hidden" name="csv_file" id="csv_file" />
                                    <?php  }}else {
                                            ?>
                                        
                                            <a  href="javascript:upload();">Upload Now</a>
                                            
                                        <?php } ?>
                                    </div>
                                   <?php    if(!empty($selpol)){ ?>
                                    <input type="hidden" name="oldfile" id="oldfile" value="<?php echo $selpol[0]->TEPD_Filename; ?>" />
                                   <?php } ?>
                                </div>
                                <?php if ($flag) { ?>
                                    <div class="form-group">
                                        <?php erp_html_form_label(__('Download Company Expense Policy Document', 'erp'), 'expense-title', true); ?>
                                        <!--<label class="control-label"</label>-->
                                        <?php $imdir = COMPANY_UPLOADS . '/'.$compid ; ?>
                                        <div> <a href="<?php $imdir . $selpol[0]->TEPD_Filename; ?>" download="file-name" >download file</a> </div>
                                    </div>
                                <?php } ?>
                        </td>
                    </tr>
                </tbody>
                <tbody id="fields_container" style="display: none;">
                </tbody>
            </table>
            <div class="submit">
                <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
                <input type="submit" name="crp_import_pdf" id="crp_import_pdf" class="button button-primary" value="Submit">
                  <!--<input type="submit" name="crp_import_pdf" id="crp_import_pdf" class="button button-primary" value="Cancel">-->
            </div>
        </form>
    </div>
</div>
<script>
    var bkp;
    function upload()
    {
        bkp = document.getElementById('fileDiv').innerHTML;

        document.getElementById('fileDiv').innerHTML = "<input type='file' name='csv_file' id='csv_file' onchange='Validate(this.id);'  />&nbsp;<a href='javascript:cancelImg()'>Cancel</a>";
    }
    function cancelImg()
    {
        document.getElementById('fileDiv').innerHTML = bkp;
    }

    var type = 1;
</script>