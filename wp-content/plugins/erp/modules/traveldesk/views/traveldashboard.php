<?php
        global $wpdb;
        $compid = $_SESSION['compid'];
        
	//$companylist = $wpdb->get_row( "SELECT EMP_Id, EMP_Code, EMP_Name FROM  employees WHERE COM_Id='$compid' AND EMP_Status=1 ORDER BY EMP_Name ASC");
	//return $companylist;
                  //print_r($companylist);
                  //$count = count($getcompany);
                //N$umRows = count($companylist);
                // $RandNum = rand(0, $NumRows);
                // print_r($companylist->EMP_Code);

                  ?>
<div class="wrap erp-emp-travel" id="wp-erp" >
        <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">
             <ol class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
            <?php $getcompany = get_traveldesk_list(); 
                  //print_r($getcompany);
                  $count = count($getcompany);
                  ?>
           <label for="comname">Select Company</label>
           <select id="selectCompany"  name="admin[compnyadminname]" value="{{data.EMP_Id}}" class="" tabindex="-1" aria-hidden="true">
           <option value="0">-SELECT COMPANY-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getcompany[$i]->EMP_Id; ?>"><?php echo $getcompany[$i]->EMP_Name; ?></option>
               <?php } ?>
           </select>
          </li>
	</ol>
        </div>
            <div class="table-responsive" style="display: none">
                
  <table class="table table-hover">
    <tr>
            
      <td width="20%">Employee Code</td>
      <td width="5%">:</td>
            <td width="25%"><?php
                 print_r($companylist->EMP_Code);
                  ?> </td>

      <td width="20%">Company Name</td>
      <td width="5%">:</td>
      <td width="25%"><?php
                 print_r(COM_Name);
                  ?> </td>
    </tr>
    <tr>
      <td width="20%">Employee Name</td>
      <td width="5%">:</td>
      <td width="25%"><?php
                 print_r($companylist->EMP_Name);
                  ?> </td>
      <td width="20%">Reporting Manager Code</td>
      <td width="5%">:</td>
      <td width="25%"><?php
                 print_r($companylist->EMP_Reprtnmngrcode);
                  ?> </td>
    </tr>
    <tr>
      <td>Employee Designation </td>
      <td>:</td>
      <td><?php
                 print_r($companylist->DES_Name);
                  ?> </td>
      <td>Reporting Manager Name</td>
      <td>:</td>
      
      <td><?php
                 print_r($companylist->EMP_Name);
                  ?></td>
    </tr>
    <tr>
      <td width="20%">Employee Department</td>
      <td width="5%">:</td>
      <td width="25%"><?php
                 print_r($companylist->DEP_Name);
                  ?></td>
      
    </tr>
  </table>
</div>

        </div>
</div>
