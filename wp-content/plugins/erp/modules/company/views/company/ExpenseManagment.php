
<div  class="postbox">
    <div class="inside emp-import">
        <?php if (isset($_GET['error'])) { ?>
            <div id="failure" class="notice notice-error is-dismissible">
                <p id="p-failure">Please Upload PDF File</p>
            </div>
        <?php } ?>
        <h2><?php _e('Company Expense Policy', 'crp'); ?></h2>
        <form method="post" action="admin.php?page=expensemenu" enctype="multipart/form-data" id="import_pdf">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>
                            <label for="type"><?php _e('Upload Company Expense Policy Document', 'crp'); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <input type="file" name="csv_file" id="csv_file" />
                            <p class="description"><?php _e('Upload a Policy file.', 'crp'); ?></p>
<!--                            <p id="download_sample_wrap">
                                <input type="hidden" value="" />
                                <a href="#">Download Sample Excel</a>
                            </p>-->
                        </td>
                    </tr>
                </tbody>
                <tbody id="fields_container" style="display: none;">
                </tbody>
            </table>
            <p class="submit">
                <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
                <input type="submit" name="crp_import_pdf" id="crp_import_pdf" class="button button-primary" value="Submit">
            </p>
        </form>
    </div>
</div>