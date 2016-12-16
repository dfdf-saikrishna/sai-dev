<?php
global $wpdb;
$compid = $_SESSION['compid'];
$selpol = $wpdb->get_results("SELECT * FROM department WHERE COM_Id='$compid' AND DEP_Status=1 ORDER BY DEP_Name ASC");
//print_r($selpol);
?>
<div class="wrap erp-hr-reports" id="wp-erp">
    <h2><?php _e('Estimated Cost Vs Actual Spend Department Wise', 'company'); ?></h2>
    <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
    <input type="hidden" value="{{data.DEP_Id}}" name="company[depId]" id="depId">
    <table class="form-table">
        <tbody id="fields_container" class="reports-graphs">
            <tr>
                <td>
                    <select name="departments" id="departments">
                        <option value="volvo">All Departments</option>
                        <?php
                        foreach ($selpol as $value) {
                            ?>
                            <option value="<?php echo $value->DEP_Id ?>" <?php ($value->DEP_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->DEP_Name; ?></option>
                        <?php } ?>
                    </select>
                    <select name="birthdayYear" >
                        <?php
                        $currY = date('Y');
                        ?>
                        <option value="2013"<?php echo $currY == '2013' ? 'selected="selected"' : ''; ?>>Year:</option>
                        <?php
                        for ($i = date('Y'); $i > 2010; $i--) {
                            $selected = '';
                            if ($currY == $i)
                                $selected = ' selected="selected"';
                            print('<option value="' . $i . '"' . $selected . '>' . $i . '</option>' . "\n");
                        }
                        ?>

                    </select>
                    <select name="signup_birth_month" id="signup_birth_month">
                        <option value="">Select Month</option>
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $month_name = date('F', mktime(0, 0, 0, $i, 1, 2011));
                            echo "<option value=\"" . $month_name . "\">" . $month_name . "</option>";
                        }
                        ?>
                    </select>
                    <a href="#" id="selUtilityReq-update" class="primary button button-primary">Show</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
