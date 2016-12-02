<?php
global $wpdb;
global $empID;
$adminid = $_SESSION['adminid'];
$compid = $_SESSION['compid'];

// Create new PHPExcel object

$objPHPExcel = new PHPExcel();

// Set properties

$objPHPExcel->getProperties()->setCreator("Corptne");
$objPHPExcel->getProperties()->setLastModifiedBy("Corptne");
$objPHPExcel->getProperties()->setTitle("Employees Error Document");
$objPHPExcel->getProperties()->setSubject("Employees Error Document");
$objPHPExcel->getProperties()->setDescription("Errors Doc");


// Add some data

$objPHPExcel->setActiveSheetIndex(0);
$testArray = array("Employee Code", "Name", "Email ID", "Department", "Reporting Manager (Emp code)", "Mobile Number", "Landline", "Designation", "Functional Reporting manager (Emp Code)", "Grade", "Error Message");
$objPHPExcel->getActiveSheet()->fromArray($testArray, NULL, 'A1');
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('Employee Error Sheet');
$a = array();
$count = $_GET['count'];
$fuid = $_GET['fuid'];
//$empnotadded=$_GET['error'];
//$error = explode(',', $empnotadded);

if($rowsql=$wpdb->get_row("SELECT * FROM file_upload WHERE FU_Id='$fuid'")){
    $fileDirectory = WPERP_COMPANY_PATH . "/upload/$compid/".$rowsql->FU_Filename;
    $stat=$rowsql->FU_Status;
}

$objPHPExcelRead = PHPExcel_IOFactory::load($fileDirectory);

?>

<div class="postbox">
    <div class="inside">
        <h3><?php _e( 'View Excel', 'crp' ); ?></h3>
        
        <?php if($count){ ?>
        <div id="wp-erp" class="wrap" style="float:right;"><a class="add-new-h2" href="error.xlsx">Download Error File</a> (To fix Errors)</div>
                <?php } ?>
                <?php $worksheet = $objPHPExcelRead->getActiveSheet();
                $i=0;
                ?>
                <?php foreach ($objPHPExcelRead->getWorksheetIterator() as $worksheet)
                    {
                        echo 'Sheet - ', $objPHPExcelRead->getIndex($worksheet), PHP_EOL;
                        //  Get worksheet dimensions
                        $sheet = $objPHPExcelRead->getSheet($i);     //Selecting sheet 0
                        $highestRow = $sheet->getHighestRow();     //Getting number of rows
                        //$highestColumn = $sheet->getHighestColumn();     //Getting number of columns
                        $highestColumn = 'J';
                        //  Loop through each row of the worksheet in turn
                        $x = 0;
                        if($i>0){
                        $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
                        $objPHPExcel->setActiveSheetIndex($i);
                        $objPHPExcel->getActiveSheet()->setTitle('Employee Error Sheet'.$i);
                        $objPHPExcel->getActiveSheet()->fromArray($testArray, NULL, 'A1');
                        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
                        }
                        ?>
              <div class="table-responsive">
                <table cellpadding="2" cellspacing="2" border="1" class="wp-list-table widefat">
                  
                   <?php
                            for ($row = 1; $row <= $highestRow; $row++) 
                            {
                                //  Read a row of data into an array
                                $error = false;
                                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                NULL, TRUE, FALSE);

                                // This line works as $sheet->rangeToArray('A1:E1') that is selecting all the cells in that row from cell A to highest column cell
                                     //echo "<tr data-toggle='tooltip'>";
                                //echoing every cell in the selected row for simplicity. You can save the data in database too.
                                $col = 0;
                                //if (preg_match('/\b' . $rowData[0][0] . '\b/',$empnotadded)){
                                //$error = true;
                                $email = $rowData[0][2];
                                if($rowData[0][0] == ""){
                                    $error = true;
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow("10", $row, 'Empid Missing');
                                    $empID = true;
                                    echo "<tr bgcolor='#ff8c8c' data-toggle='tooltip' title='Empid Missing'>";
                                }
                                else if($rowData[0][1] == "" || $rowData[0][3] == "" || $rowData[0][4] == "" || $rowData[0][7] == "" || $rowData[0][8] == "" || $rowData[0][9] == ""){
                                    $error = true;
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow("10", $row, 'Missing Required Data');
                                    echo "<tr bgcolor='#ff8c8c' data-toggle='tooltip' title='Missing Required Data'>";
                                }
                                else if($selemail=$wpdb->get_row("SELECT user_email FROM wp_users users,employees emp WHERE users.user_email='$email' AND users.ID = emp.user_id AND emp.EMP_Status=1")){
                                    $error = true;
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow("10", $row, 'Employee Email already Exists');
                                    echo "<tr bgcolor='#ff8c8c' data-toggle='tooltip' title='Employee Email already Exists'>";
                                }
                                //else{
                                    //echo "<tr data-toggle='tooltip'>";
                                //}
                            //}
                            //else{
                                //$error = false;
                            //}
                                
                                foreach($rowData[0] as $k=>$v){
                                if($x == 0){
                                    echo "<th>".$v."</th>";
                                }
                                else{
                                    if($v == ""){
                                        if($empID)
                                        echo "<td align='center' height='35'>-</td>";    
                                        else
                                        echo "<td align='center' height='35'>---</td>";
                                        if($error){
                                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "---");
                                        $col++;
                                        }

                                    }
                                    else{
                                        echo "<td align='center' height='35'>".$v."</td>";
                                        if($error){
                                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $v);
                                        $col++;
                                        }
                                    }
                                }
                            }$x++;
                            echo "</tr>";   
                            }$i++;
                   ?>
                </table>
              </div>
              <br>
              <?php } 
               // Save Excel 2007 file
//                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//                $filename = 'error/error.xlsx';
//                $objWriter->save($filename);
                
                $filename='error.xlsx'; 
                //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
                //header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                //header('Cache-Control: max-age=0'); //no cache

                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save($filename);

                ?>
              <a href="/wp-admin/admin.php?page=Upload-Employees">>>Back to Upload<<</a> 
    </div><!-- .inside -->
</div><!-- .postbox -->

