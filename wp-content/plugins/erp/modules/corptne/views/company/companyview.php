<div class="wrap erp erp-hr-employees erp-employee-single">

    <h2 class="erp-hide-print"><?php _e( 'COMPANIES -Company Details View', 'erp' );?> </h2>
    <div class="erp-single-container erp-hr-employees-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-employees-wrap-inner">
            <div id="erp-area-left-inner">
                <script type="text/javascript">
                    window.wpErpCurrentCompanyview = <?php echo json_encode( $companyview->to_array() ); ?>
                </script>
                <div class="erp-profile-top">
                    <div class="erp-avatar">
                       <img src="<?php echo $companyview->COM_Logo; ?>" width="100px" />
				   </div>

                    <div class="erp-user-info">
                        <h3><span class="title"><?php echo $companyview->COM_Name; ?></span></h3>

                        <ul class="lead-info">

                            <li>
                                <a href="mailto:<?php echo $companyview->COM_Email; ?>"><?php echo $companyview->COM_Email; ?></a>
                            </li>
							<li>
                               <?php echo $companyview->COM_Prefix; ?>
                            </li>
							<li>
                               <?php echo $companyview->COM_Mobile; ?>
                            </li>
							<li>
                               <?php echo $companyview->COM_Landline; ?>
                            </li>
							<li>
                               <?php echo $companyview->COM_Address; ?>
                            </li>
							<li>
                               <?php echo $companyview->COM_Location .", ". $companyview->COM_City .", ". $companyview->COM_State; ?>
                            </li>
							<li>
						    <?php echo $companyview->COM_Cp1username .", ".$companyview->COM_Cp1email .", ".$companyview->COM_Cp1mobile; ?>
							</li>
							<li>
						    <?php echo $companyview->COM_Cp2username .", ".$companyview->COM_Cp2email .", ".$companyview->COM_Cp2mobile; ?>
							</li>
							<li>
						    <?php echo $companyview->COM_Cp2username .", ".$companyview->COM_Cp2email .", ".$companyview->COM_Cp2mobile; ?>
							</li>
							<li>
							<?php $mods=NULL; if($companyview->COM_Flight) $mods='Flight, '; if($companyview->COM_Bus) $mods.='Bus, '; if($companyview->COM_Hotel) $mods.='Hotel, ';  echo rtrim($mods, ", ")."."; ?>
                            </li>
							<li>
							<?php echo $companyview->COM_Spname; ?>
							</li>
							<li>
							<?php echo $companyview->COM_Spemail; ?>
							</li>
							<li>
							<?php echo $companyview->COM_Spcontactno; ?>
							</li>
							<li>
							<?php echo $companyview->COM_Descdeal; ?>
							</li>
							
                        </ul>
                    </div><!-- .erp-user-info -->

                    <div class="erp-area-right erp-hide-print">
                        <div class="postbox leads-actions">
                            <h3 class="hndle"><span><?php _e( 'Actions', 'erp' ); ?></span></h3>
                            <div class="inside">
                                <?php
                                if ( current_user_can( 'superadmin', $companyview->id )) {
                                    ?>
                                    <span class="edit">
									<a class="button button-primary" href="?page=companiesmenu" data-single="true"  data-id="<?php echo $companyview->id ?>"><?php _e( 'Edit', 'companies_table_list' ); ?></a></span>
									<?php	
                                }
                                ?>
                                   <a class="button" id="erp-employee-print" href="#"><?php _e( 'Print', 'erp' ); ?></a>
                            </div>
                        </div><!-- .postbox -->
                    </div><!-- .leads-right -->

                    <?php //do_action( 'erp_hr_employee_single_after_info', $companyview ); ?>

                </div><!-- .erp-profile-top -->

               

                <?php //do_action( 'erp_hr_employee_single_bottom', $companyview ); ?>

            </div><!-- #erp-area-left-inner -->
        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
