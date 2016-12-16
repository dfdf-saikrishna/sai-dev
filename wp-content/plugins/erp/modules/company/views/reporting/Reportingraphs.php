<?php
global $wpdb;
$compid = $_SESSION['compid'];
$selpol = $wpdb->get_results("SELECT * FROM department WHERE COM_Id='$compid' AND DEP_Status=1 ORDER BY DEP_Name ASC");
//print_r($selpol);
?>

<div class="company-headcount" id="wp-erp">
    <h2><?php _e('Estimated Cost Vs Actual Spend Department Wise', 'company'); ?></h2>
    <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
    <input type="hidden" value="{{data.DEP_Id}}" name="company[depId]" id="depId">
    <form method="get">
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
                        <a href="#" id="graphs-update" class="primary button button-primary">Show</a>
                    </td>
                </tr>
            </tbody>
        </table> </form>
</div>
<?php wp_nonce_field('epr-rep-headcount'); ?>
<!--<button type="submit" class="button-secondary" name="filter_headcount">//<?php _e('Filter', 'erp'); ?></button>-->
<div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">

        <!-- main content -->
        <div id="post-body-content">

            <div class="meta-box-sortables ui-sortable">

                <div class="postbox">

                    <div class="handlediv" title="Click to toggle"><br></div>
                    <!-- Toggle -->

                    <h2 class="hndle"><span><?php _e('Department Wise', 'erp'); ?></span>
                    </h2>

                    <div class="inside">

                     <html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
     var data;
     var chart;

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create our data table.
        data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Departments', 3],
          ['Employees', 1],
          ['Grades', 1],
          ['Designation', 1],
//          ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {'title':'',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        var value = data.getValue(selectedItem.row, 0);
        alert('The user selected ' + value);
      }

    </script>
  </head>
  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:400; height:300"></div>
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
<script>
    ;
    (function($){

      $(document).ready(function() {
        $.plot($("#emp-headcount"), <?php esc_attr_e( json_encode( $chart_data ) ); ?>, {
            xaxis: {
              mode: 'time',
              tickLength: 0,
              tickSize: [1, 'month'],
              min: <?php echo $js_year_before; ?>,
              max: <?php echo $js_this_month; ?>,
              axisLabel: "Headcount by Month",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 14,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
            },
            yaxis: {
              show: false
            },
            series: {
              bars: {
                show: true,
                fill: 1,
                color: '#8BA958',
                barWidth: 20*24*60*60*1000
              },
              valueLabels: {
                show: true,
                font: "9pt 'Trebuchet MS'",
                align: 'center'
              }
            },
            bars: {
                align: 'center',
                fillColor: '#32CD32',
                lineWidth: 0
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderWidth: 0
            }
          });
      });

    })(jQuery);

</script>
