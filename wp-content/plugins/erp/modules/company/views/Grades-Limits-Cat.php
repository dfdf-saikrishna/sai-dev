<?php
global $wpdb;
$compid = $_SESSION['compid'];
//$gradeid = $_GET['egid'];
$allcat = ( isset($_GET['allcat']) ) ? $_GET['allcat'] : '';
$grades = ( isset($_GET['grades']) ) ? $_GET['grades'] : '';

?>
<div class="postbox">
    <h2 class="inside" style="margin: 31px 10px 10px 30px"><?php _e('Employee Grade Limits', 'erp'); ?> </h2>
    <?php
    $selcom = $wpdb->get_results("SELECT * From employee_grades Where COM_Id='$compid' AND EG_Status=1 ORDER BY EG_Id DESC");
    if ($selcom) {
        ?>
        <div class="inside" >
            <form method="post" action ="#" name="formlimits" id="formlimits">
            <div style="text-align:center">
                <select  class="" data-size="5" data-live-search="true" name="grades" id="grades">
                    <option value=""> Grades </option>
                    <?php
                    foreach ($selcom as $value) {
                        ?>
                        <option value="<?php echo $value->EG_Id ?>" <?php echo ($grades == $value->EG_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->EG_Name ?></option>
                    <?php } ?>
                </select>
                <select  class="" data-size="5" data-live-search="true" name="allcat" id="allcat">
                    <option value=""> Expense Categories </option>
                    <?php
                    $selmodes = $wpdb->get_results("SELECT * FROM expense_category");
                    foreach ($selmodes as $value) {
                        ?>
                        <option value="<?php echo $value->EC_Id ?>" <?php echo ($allcat == $value->EC_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->EC_Name ?></option>
                    <?php } ?>
                </select>
               <input type="submit" class="button button-primary" value="Search" id="gradessearch"/>
            </div>
                </form>
            <div class="list-table-wrap erp-company-gradecat-wrap">
                <div class="list-table-inner erp-company-gradecat-wrap-inner">
                    <table  class="wp-list-table widefat striped admins" style="margin-bottom: 15px;" >
                        <h3 class="inside" style="margin: 1px 0px 5px 5px"><?php _e('Travel Category Limits', 'erp'); ?> </h3>
                        <thead>
                            <tr>
                                <th width="5%">Sl.No.</th>
                                <th width="5%">Grade</th>
                                <?php
                                $selmodes = $wpdb->get_results("SELECT * FROM mode Where EC_Id=1 AND COM_Id='$compid' AND MOD_Status=1");
                                foreach ($selmodes as $value) {
                                    ?>
                                    <th width="500px"><?php echo $value->MOD_Name; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <?php
                            $i = 1;
                            foreach ($selcom as $rowcom) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td> <?php echo $rowcom->EG_Name; ?> <a href="#" id="gradelimitadd" data-id="<?php echo $rowcom->EG_Id ?>" title="Edit Grade Limits">Edit</a></td>
                                    <?php
                                    $egid = $rowcom->EG_Id;
                                    //echo $egid;
                                    if ($rowsum = $wpdb->get_row("SELECT * FROM  grade_limits where EG_Id='$egid' AND GL_Status=1")) {
                                        ?>
                                        <td ><?php echo $rowsum->GL_Flight ? IND_money_format($rowsum->GL_Flight) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_Bus ? IND_money_format($rowsum->GL_Bus) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_Car ? IND_money_format($rowsum->GL_Car) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_Others_Travels ? IND_money_format($rowsum->GL_Others_Travels) : 0; ?></td> 
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <table  class="wp-list-table widefat striped admins" style="margin-bottom: 15px;" >
                        <h3 class="inside" style="margin: 1px 0px 5px 5px"><?php _e('Accommodation Category Limits', 'erp'); ?> </h3>
                        <thead>
                            <tr>
                                <th width="5%">Sl.No.</th>
                                <th width="5%">Grade</th>
                                <?php
                                $selmodes = $wpdb->get_results("SELECT * FROM mode Where EC_Id=2 AND COM_Id='$compid' AND MOD_Status=1");
                                foreach ($selmodes as $value) {
                                    ?>
                                    <th width="500px"><?php echo $value->MOD_Name; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <?php
                            $i = 1;
                            foreach ($selcom as $rowcom) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td> <?php echo $rowcom->EG_Name; ?> <a href="#" id="gradelimitstay" data-id="<?php echo $rowcom->EG_Id ?>" title="Edit Grade Limits">Edit</a></td>
                                    <?php
                                    $egid = $rowcom->EG_Id;
                                    //echo $egid;
                                    if ($rowsum = $wpdb->get_row("SELECT * FROM  grade_limits where EG_Id='$egid' AND GL_Status=1")) {
                                        ?>
                                        <td ><?php echo $rowsum->GL_Hotel ? IND_money_format($rowsum->GL_Hotel) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_Self ? IND_money_format($rowsum->GL_Self) : 0; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                     <table  class="wp-list-table widefat striped admins" style="margin-bottom: 15px;" >
                        <h3 class="inside" style="margin: 1px 0px 5px 5px"><?php _e('General Category Limits', 'erp'); ?> </h3>
                        <thead>
                            <tr>
                                <th width="5%">Sl.No.</th>
                                <th width="5%">Grade</th>
                                <?php
                                $selmodes = $wpdb->get_results("SELECT * FROM mode Where EC_Id=3 AND COM_Id IN (0, '$compid') AND MOD_Status=1");
                                //print_r($selmodes);
                                foreach ($selmodes as $value) {
                                    ?>
                                    <th width="500px"><?php echo $value->MOD_Name; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <?php
                            $i = 1;
                            foreach ($selcom as $rowcom) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td> <?php echo $rowcom->EG_Name; ?> <a href="#" id="gradelimitgeneral" data-id="<?php echo $rowcom->EG_Id ?>" title="Edit Grade Limits">Edit</a></td>
                                    <?php
                                    $egid = $rowcom->EG_Id;
                                    //echo $egid;
                                    if ($rowsum = $wpdb->get_row("SELECT * FROM  grade_limits where EG_Id='$egid' AND GL_Status=1")) {
                                        ?>
                                        <td ><?php echo $rowsum->GL_Local_Conveyance ? IND_money_format($rowsum->GL_Local_Conveyance) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_ClientMeeting ? IND_money_format($rowsum->GL_ClientMeeting) : 0; ?></td>
                                         <td ><?php echo $rowsum->GL_Others_Other_te ? IND_money_format($rowsum->GL_Others_Other_te) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_Marketing ? IND_money_format($rowsum->GL_Marketing) : 0; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                     <table  class="wp-list-table widefat striped admins" style="margin-bottom: 15px;" >
                        <h3 class="inside" style="margin: 1px 0px 5px 5px"><?php _e('Other Category Limits', 'erp'); ?> </h3>
                        <thead>
                            <tr>
                                <th width="5%">Sl.No.</th>
                                <th width="5%">Grade</th>
                                <?php
                                $selmodes = $wpdb->get_results("SELECT * FROM mode Where EC_Id=4 AND COM_Id IN (0, '$compid') AND MOD_Status=1");
                                 //print_r($selmodes);
                                foreach ($selmodes as $value) {
                                    ?>
                                    <th width="500px"><?php echo $value->MOD_Name; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <?php
                            $i = 1;
                            foreach ($selcom as $rowcom) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td> <?php echo $rowcom->EG_Name; ?> <a href="#" id="gradelimitother" data-id="<?php echo $rowcom->EG_Id ?>" title="Edit Grade Limits">Edit</a></td>
                                    <?php
                                    $egid = $rowcom->EG_Id;
                                    //echo $egid;
                                    if ($rowsum = $wpdb->get_row("SELECT * FROM  grade_limits where EG_Id='$egid' AND GL_Status=1")) {
                                        ?>
                                        <td width="5%"><?php echo $rowsum->GL_Halt ? IND_money_format($rowsum->GL_Halt) : 0; ?></td>
                                        <td><?php echo $rowsum->GL_Boarding ? IND_money_format($rowsum->GL_Boarding) : 0; ?></td>
                                         <td ><?php echo $rowsum->GL_Other_Te_Others ? IND_money_format($rowsum->GL_Other_Te_Others) : 0; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div></div>
        </div>
    <?php } ?>
</div>