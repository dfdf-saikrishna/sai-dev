<?php  
global $wpdb;
$compid = $_SESSION['compid'];
$rowpol = $wpdb->get_results("SELECT * FROM policy");
$workflow = $wpdb->get_row("SELECT COM_Pretrv_POL_Id, COM_Posttrv_POL_Id, COM_Othertrv_POL_Id, COM_Mileage_POL_Id, COM_Utility_POL_Id FROM company WHERE COM_Id='$compid'");


?>
<div class="postbox">
    <div class="inside">
        <h3><?php _e( 'Company Expense Request Workflow', 'crp' ); ?></h3>

        <form method="post" action="#" enctype="multipart/form-data" id="workflow_update" name="workflow_update">

            <table class="form-table">
                <tbody id="fields_container">
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Pre Travel Request', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <select name="selPreTrvPol">
                                <option value="volvo">-Select-</option>
                                <?php
                                foreach($rowpol as $value)
				{?>
                                <option value="<?php echo $value->POL_Id?>" <?php echo ($workflow->COM_Pretrv_POL_Id==$value->POL_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->POL_Type;?></option>
                                 
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Post Travel Request', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <select name="selPostTrvPol">
                                <option value="volvo">-Select-</option>
                                <?php
                                foreach($rowpol as $value)
				{?>
                                <option value="<?php echo $value->POL_Id?>" <?php echo ($workflow->COM_Posttrv_POL_Id==$value->POL_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->POL_Type;?></option>
                                 
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'General Expense Request', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <select name="selGenExpReq">
                                <option value="volvo">-Select-</option>
                                <?php
                                foreach($rowpol as $value)
				{?>
                                <option value="<?php echo $value->POL_Id?>" <?php echo ($workflow->COM_Othertrv_POL_Id==$value->POL_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->POL_Type;?></option>
                                 
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Mileage Requests', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <select name="selMileageReq">
                                <option value="volvo">-Select-</option>
                                <?php
                                foreach($rowpol as $value)
				{?>
                                <option value="<?php echo $value->POL_Id?>" <?php echo ($workflow->COM_Mileage_POL_Id==$value->POL_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->POL_Type;?></option>
                                 
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Utility Requests', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <select name="selUtilityReq">
                                <option value="volvo">-Select-</option>
                                <?php
                                foreach($rowpol as $value)
				{?>
                                <option value="<?php echo $value->POL_Id?>" <?php echo ($workflow->COM_Utility_POL_Id==$value->POL_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->POL_Type;?></option>
                                 
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button( __( 'Update', 'crp' ), 'primary', 'workflow-update' ); ?>
        </form>
    </div><!-- .inside -->
</div><!-- .postbox -->

