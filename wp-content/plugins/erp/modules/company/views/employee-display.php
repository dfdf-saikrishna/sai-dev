<?php 
$msg=$_GET['msg'];
$empid=$_GET['empid'];
$compid = $_SESSION['compid'];

$rowcomp=$wpdb->get_results("SELECT * FROM employees emp, admin adm, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.EMP_Id='$empid' AND emp.ADM_Id=adm.ADM_Id AND emp.EG_Id=eg.EG_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id")

?>

<div id="main">
  <ol class="breadcrumb">
    <li><a href="admin-dashboard.php">Dashboard</a></li>
    <li class="active">Employee Profile Display</li>
  </ol>
  <!-- //breadcrumb-->
  <div id="content">
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <div class="panel-body">
            <header class="panel-heading sm" data-color="theme-inverse">
              <h2>Employees Profile Display</h2>
              <label class="color">View<strong> EMPLOYEE DETAILS </strong></label>
              <span class="pull-right">Added on: <?php echo date('d-M-Y',strtotime($rowcomp->EMP_Regdate));?><br />
              Added by: <?php echo $rowcomp->ADM_Name; ?></span> </header>
            <form class="form-horizontal" method="post" id="Employeenew" name="Employeenew" action="admin-employees-edit.php?empid=<?php echo $empid; ?>" data-collabel="3" data-alignlabel="left" parsley-validate enctype="multipart/form-data">
              <div class="panel-body">
                <div align="center">
                  <?php if($msg) echo $msg.'<br>';?>
                </div>
                <div class="panel-body">
                  <?php if($msg) echo '<div align="center" id="msgidbox">'.$msg.'</div>' ?>
                  <?php 
						if($rowcomp->EMP_Photo)
						$src='upload/'.$compid.'/photographs/'.$rowcomp->EMP_Photo;
						else
						$src='../assets/img/no_image.jpg';
						?>
                  <div class="form-group">
                    <label class="control-label">Employee photo upload</label>
                    <div><img src="<?php echo $src; ?>" width="200"/></div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Employee Name</label>
                    <div>
                      <div class="form-control"><?php echo $rowcomp->EMP_Name; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Employee Code</label>
                    <div>
                      <div class="form-control"><?php echo $rowcomp->EMP_Code; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Grade</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->EG_Name; ?> </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Department</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->DEP_Name; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Designation</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->DES_Name; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->EMP_Email; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Mobile No.</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->EMP_Phonenumber; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Landline No.</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->EMP_Phonenumber2; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Reporting Manager Code</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->EMP_Reprtnmngrcode; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Reporting Manager Name</label>
                    <div>
                      <?php 
				
				if($rowsql=$wpdb->get_results("SELECT EMP_Name employees WHERE EMP_Code='$rowcomp->EMP_Reprtnmngrcode'"))
				{
				?>
                      <div class="form-control"> <?php echo $rowsql->EMP_Name; ?></div>
                      <? } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Reporting Functional Manager Code</label>
                    <div>
                      <div class="form-control"> <?php echo $rowcomp->EMP_Funcrepmngrcode; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Reporting Functional Manager Name</label>
                    <div>
                      <?php 
				 
				if($rowsql=$wpdb->get_results("SELECT EMP_Name employees WHERE EMP_Code='$rowcomp->EMP_Funcrepmngrcode'"))
				{
				?>
                      <div class="form-control"> <?php echo $rowsql->EMP_Name; ?></div>
                      <?PHP } ?>
                    </div>
                  </div>
                  <div class="form-group offset">
                    <div>
                      <button type="submit" name="addnewEmployee" id="addnewEmployee" class="btn btn-theme">Edit</button>
                      <button type="reset" class="btn" onClick="javascript:window.history.back();">Back</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- //content-->
</div>
<?php } ?>
