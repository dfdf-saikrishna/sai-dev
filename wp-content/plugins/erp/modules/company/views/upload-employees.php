<div class="postbox">
    <div class="inside">
        <h3><?php _e( 'Import Excel', 'crp' ); ?></h3>

        <form method="post" action="admin.php?page=Upload-Employees" enctype="multipart/form-data" id="import_form">

            <table class="form-table">
                <tbody>
                    
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Excel File', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <input type="file" name="csv_file" id="csv_file" />
                            <p class="description"><?php _e( 'Upload a Excel file.', 'crp' ); ?></p>
                            <p id="download_sample_wrap">
                                <input type="hidden" value="" />
                                <a href="https://expirebox.com/files/8087511b301a051a8372d124d7d5c1e2.xls">Download Sample Excel</a>
                            </p>
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

