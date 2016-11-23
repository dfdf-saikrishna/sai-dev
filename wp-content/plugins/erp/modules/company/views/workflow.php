<?php  
global $wpdb;
$compid = $_SESSION['compid'];
$rowpol = $wpdb->get_results("SELECT * FROM policy");
$workflow = $wpdb->get_row("SELECT COM_Pretrv_POL_Id, COM_Posttrv_POL_Id, COM_Othertrv_POL_Id, COM_Mileage_POL_Id, COM_Utility_POL_Id FROM company WHERE COM_Id='$compid'");


?>
<div class="postbox">
    <div class="inside">
        <h2><?php _e( 'Company Expense Request Workflow', 'crp' ); ?></h2>

        <form method="post" action="#" enctype="multipart/form-data" id="workflow_update" name="workflow_update">

            <table class="form-table">
                <tbody id="fields_container">
                    <tr>
                        <th>
                            <label for="type"><?php _e( 'Pre Travel Request', 'crp' ); ?> <span class="required">*</span></label>
                        </th>
                        <td>
                            <select name="selPreTrvPol" id="selPreTrvPol">
                                <option value="volvo">-Select-</option>
                                <?php
                                foreach($rowpol as $value)
				                {?>
                                <option value="<?php echo $value->POL_Id?>" <?php echo ($workflow->COM_Pretrv_POL_Id==$value->POL_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->POL_Type;?></option>
                                 
                                <?php } ?>
                            </select>
                            <a href="#" id="selPreTrvPol-update" class="primary button button-primary">Update</a>
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
                            <a href="#" id="selPostTrvPol-update" class="primary button button-primary">Update</a>
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
                            <a href="#" id="selGenExpReq-update" class="primary button button-primary">Update</a>
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
                            <a href="#" id="selMileageReq-update" class="primary button button-primary">Update</a>
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
                            <a href="#" id="selUtilityReq-update" class="primary button button-primary">Update</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div><!-- .inside -->
</div><!-- .postbox -->

