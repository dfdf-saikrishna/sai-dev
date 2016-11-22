<div class="postbox">
    <div class="inside">
        <h3><?php _e( 'Company Expense Request Workflow', 'crp' ); ?></h3>

        <form method="post" action="admin.php?page=Upload-Employees" enctype="multipart/form-data" id="import_form">

            <table class="form-table">
                <tbody>
                    
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Excel File', 'crp' ); ?></label>
                        </th>
                        <td>
                            <input type="file" name="csv_file" id="csv_file" />
                            
                        </td>
                    </tr>
                </tbody>
                

                <tbody id="fields_container" style="display: none;">

                </tbody>
            </table>

            <?php submit_button( __( 'Import', 'crp' ), 'primary', 'crp_import_excel' ); ?>
        </form>
    </div><!-- .inside -->
</div><!-- .postbox -->

