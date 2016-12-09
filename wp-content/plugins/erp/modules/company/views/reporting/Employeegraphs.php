<?php
global $wpdb;
$compid = $_SESSION['compid'];
$selpol = $wpdb->get_results("SELECT EMP_Code, EMP_Id, EMP_Name FROM employees WHERE COM_Id='$compid' AND EMP_Status=1 ORDER BY EMP_Code ASC");
//print_r($selpol);
?>
<div class="company-headcount" id="wp-erp">
    <h2><?php _e('Estimated Cost Vs Actual Spend Employee Wise', 'company'); ?></h2>
    <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
    <input type="hidden" value="{{data.DEP_Id}}" name="company[depId]" id="depId">
    <form method="get">
        <table class="form-table">
            <tbody id="fields_container" class="reports-graphs">
                <tr>
                    <td>
                        <select name="departments" id="departments">
                            <option value="volvo">Select Employees</option>
                            <?php
                            foreach ($selpol as $value) {
                                ?>
                                <option value="<?php echo $value->EMP_Id ?>" <?php ($value->EMP_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->EMP_Name; ?>---<?php echo $value->EMP_Code; ?></option>
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
                        <a href="#" id="graphs-update" class="primary button button-primary">Show</a>
                    </td>
                </tr>
            </tbody>
        </table> </form>
</div>
<!--<div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">

         main content 
        <div id="post-body-content">

            <div class="meta-box-sortables ui-sortable">

                <div class="postbox">

                    <div class="handlediv" title="Click to toggle"><br></div>
                     Toggle 

-->                    <h2 class="hndle"><span><?php _e('Employee Wise', 'erp'); ?></span>
</h2>

<!--<div class="inside">-->

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
google.charts.load("current", {packages: ["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable
            ([['X', 'Y'],
                [1, 3],
                [2, 2.5],
                [3, 2],
                [4, 3],
                [5, 4.5],
                [6, 6.5],
                [7, 9],
                [8, 12]
            ]);

    var options = {
        legend: 'none',
        colors: ['#15A0C8'],
        pointSize: 30,
        pointShape: {type: 'triangle', rotation: 180}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
    </script>
</head>
<body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>

</div>
<!-- .inside -->

</div>
<!-- .postbox -->

</div>
<!-- .meta-box-sortables .ui-sortable -->

</div>
</div>
<!-- #postbox-container-1 .postbox-container -->

</div>
<!-- #post-body .metabox-holder .columns-2 -->

<br class="clear">
</div>
