<div style="margin-top:60px;">
            <table class="wp-list-table widefat striped admins">
                <?PHP 

                    $q=NULL;

                    if(!$showProCode){
                          $pc=" AND PC_Status IN (1)";
                          $cc=" AND CC_Status IN (1)";
                    }else{
                        $pc = "";
                        $cc = "";
                    }

                    $selexpcatpc=$wpdb->get_results("SELECT * FROM project_code WHERE COM_Id='$compid' AND PC_Active=1 $pc");

                    if(count($selexpcatpc)){

                          if($showProCode){
                            ?>
                <td width="20%" style="color:#C66300;">Project Code</td>
                <td width="5%">:</td>
                <td width="25%"><?php 
                    
                    if($row->PC_Id){

                            if($rowpcname=$wpdb->get_row("SELECT PC_Code, PC_Name FROM project_code WHERE COM_Id='$compid' AND PC_Id=$row->PC_Id AND PC_Active=1")){

                                   echo $rowpcname->PC_Code.' -- '.$rowpcname->PC_Name;


                            } 

                    }  else {

                          echo 'None';

                    }
                    ?></td>
                <?php

                          } else {

                          ?>
                <td width="20%" style="color:#C66300;">Project Code</td>
                <td width="5%">:</td>
                <td width="25%"><select name="selProjectCode" id="selProjectCode" class="">
                    <option value="">None</option>
                    <?php 

                                            foreach($selexpcatpc as $rowexpcat)
                                            {
                                            ?>
                    <option value="<?php echo $rowexpcat->PC_Id?>" <?php if($row){if($row->PC_Id==$rowexpcat->PC_Id) echo 'selected="selected"';}else{echo "";} ?>><?php echo $rowexpcat->PC_Code." -- ".$rowexpcat->PC_Name; ?></option>
                    <?php } ?>
                  </select>
                </td>
                <?php	

                          }


                    ?>
                <?php }  else { ?>
                <td colspan="3">&nbsp;</td>
                <?php } ?>
                <td colspan="3">&nbsp;</td>
                <?PHP 
                
                    $selexpcatpc=$wpdb->get_results("SELECT * FROM cost_center WHERE COM_Id='$compid' AND CC_Active=1 $cc");

                    if(count($selexpcatpc)){

                          if($showProCode){

                                                  ?>
                <td width="20%" style="color:#C66300;">Cost Center</td>
                <td width="5%">:</td>
                <td width="25%"><?php 
                    if($row->CC_Id){

                            if($rowpcname=$wpdb->get_row("SELECT CC_Code, CC_Name FROM cost_center WHERE COM_Id='$compid' AND CC_Id=$row->CC_Id AND CC_Active=1")){

                                   echo $rowpcname->CC_Code.' -- '.$rowpcname->CC_Name;


                            } 
                    }  else {

                          echo 'None';

                    }
                    ?></td>
                <?php

                          } else {
                          
                          ?>
                <td width="20%" style="color:#C66300;">Cost Center</td>
                <td width="5%">:</td>
                <td width="25%"><select name="selCostCenter" id="selCostCenter" class="">
                    <option value="">None</option>
                    <?php 

                                            foreach($selexpcatpc as $rowexpcat)
                                            {
                                            ?>
                    <option value="<?php echo $rowexpcat->CC_Id?>" <?php if($row){if($row->CC_Id==$rowexpcat->CC_Id) echo 'selected="selected"';}else{echo "";} ?>><?php echo $rowexpcat->CC_Code." -- ".$rowexpcat->CC_Name; ?></option>
                    <?php } ?>
                  </select>
                </td>
                <?php	

                          }


                    ?>
                <?php }  else { ?>
                <td colspan="3">&nbsp;</td>
                <?php } ?>
            </tr>
            </table>
            </div>