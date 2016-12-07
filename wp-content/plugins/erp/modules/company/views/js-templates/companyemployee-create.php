<div class="erp-employee-form">
    <fieldset class="no-border">
	<ol class="form-fields">
            <li>
                <label for="full-name">Upload EMP Photo</label>
                <div class="photo-container">
                    <input name="companyemployee[photo_id]" id="emp-photo-id" value="{{data.Emp_photoId}}" type="hidden">
                    <input type="hidden" name="companyemployee[user_id]" value="{{data.user_id}}">
                        <# if ( data.EMP_Photo ) { #>
                        <img src="{{ data.EMP_Photo }}" alt="" />
                        <a href="#" class="erp-remove-photo">&times;</a>
                        <# } else { #>
                            <a href="#" id="company-emp-photo" class="button button-small">Select File</a>
                        <# } #>
                    
                </div>
            </li>
        </ol>
        <ol class="form-fields two-col">
                            <li>
                    <label for="txtCompname">Employee Name </label><input required  value="{{data.EMP_Name}}"  name="companyemployee[txtEmpname]" id="txtEmpname" type="text"></li>
                        <li>
                <label for="txtEmpcode">Employee Code </label><input required  value="{{data.EMP_Code}}" name="companyemployee[txtEmpcode]" id="txtEmpcode"  type="text"></li>

        </ol>
		 <ol class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.EG_Id}}>
            <?php $getgrades = get_grade_list(); 
                  //print_r($getgrades);
                  $count = count($getgrades);
                  ?>
           <label for="grade">Select Grade</label>
           <select required id="selGrade" name="companyemployee[selGrade]"  tabindex="-1" aria-hidden="true">
           <option value="">-SELECT Grade-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getgrades[$i]->EG_Id; ?>"><?php echo $getgrades[$i]->EG_Name; ?></option>

               <?php } ?>
           </select>
          </li>
		   <li class="erp-hr-js-department" data-selected={{data.DEP_Id}}>
            <?php $getdepartments = get_department_list(); 
                  //print_r($getdepartments);
                  $count = count($getdepartments);
                  ?>
           <label for="selDep">Select Department</label>
           <select required id="selDep" name="companyemployee[selDep]"  class="" tabindex="-1" aria-hidden="true">
           <option value="">-SELECT Department-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getdepartments[$i]->DEP_Id; ?>"><?php echo $getdepartments[$i]->DEP_Name; ?></option>

               <?php } ?>
           </select>
          </li>
	</ol>
	 <ol class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.DES_Id}}>
            <?php $getdesignations = get_designation_list(); 
                  //print_r($getdesignations);
                  $count = count($getdesignations);
                  ?>
           <label for="selDes">Select Designation</label>
           <select  required id="selDes" name="companyemployee[selDes]"  tabindex="-1" aria-hidden="true">
           <option value="">-SELECT Designation-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getdesignations[$i]->DES_Id; ?>"><?php echo $getdesignations[$i]->DES_Name; ?></option>

               <?php } ?>
           </select>
          </li>
	</ol>
        <ol class="form-fields two-col">
            <li><label for="txtempemail">Email </label><input required value="{{data.EMP_Email}}" name="companyemployee[txtempemail]" id="txtempemail"  type="email"></li>         
            <li><label for="txtempmob">Mobile No.</label><input  required name="companyemployee[txtempmob]" value="{{data.EMP_Phonenumber}}" id="txtempmob"  type="number"></li>
			<li><label for="txtemplandline">Landline No.</label><input required name="companyemployee[txtemplandline]" value="{{data.EMP_Phonenumber2}}" id="txtemplandline" type="number"></li>
        </ol>
	<ol class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.EMP_Reprtnmngrcode}}>
            <?php $getrepm = get_repm_list(); 
                  $count = count($getrepm);
                  ?>
           <label for="grade">Reporting Manager Code</label>
           <select id="txtRepmngrcode" name="companyemployee[txtRepmngrcode]" tabindex="-1" aria-hidden="true">
           <option value="">-Select Reporting Manager -</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getrepm[$i]->EMP_Code; ?>"><?php echo $getrepm[$i]->EMP_Code ."---". $getrepm[$i]->EMP_Name; ?></option>

               <?php } ?>
           </select>
          </li>
		  <li class="erp-hr-js-department" data-selected={{data.EMP_Funcrepmngrcode}}>
            <?php $getfrepm = get_frepm_list(); 
                  $count = count($getfrepm);
                  ?>
           <label for="RFM">Reporting Functional Manager Code</label>
           <select id="txtRepfuncmngrcode" name="companyemployee[txtRepfuncmngrcode]" tabindex="-1" aria-hidden="true">
           <option value="">-Select Functional Reporting Manager -</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getfrepm[$i]->EMP_Code; ?>"><?php echo $getfrepm[$i]->EMP_Code ."---". $getfrepm[$i]->EMP_Name; ?></option>

               <?php } ?>
           </select>
          </li>
	</ol>
        </fieldset>
   
       
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="companyemployee_create" value="companyemployee_create">
</div>