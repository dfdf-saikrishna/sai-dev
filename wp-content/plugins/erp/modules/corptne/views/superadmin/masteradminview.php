<div class="wrap erp erp-hr-masteradmin erp-hr-masteradmin">

    <h2 class="erp-hide-print"><?php _e( 'Master Admin Details View', 'erp' );?> </h2>
    <div class="erp-single-container erp-hr-masteradmin-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-masteradmin-wrap-inner">
            <div id="erp-area-left-inner">

                <script type="text/javascript">
                    window.wpErpCurrentMasteradminview = <?php echo json_encode( $masteradminview->to_array() ); ?>
                </script>
				
				 <div class="erp-profile-top">
				
				
                    <div class="erp-user-info">
                        <h3><span class="title"><?php echo $masteradminview->SUP_Username; ?></span></h3>

                        <ul class="lead-info">
                            <li>
                                <?php echo $masteradminview->SUP_Email; ?>
                            </li>
							<li>
                               <?php echo $masteradminview->SUP_Contact; ?>
                            </li>
							<li>
							<?php if($masteradminview->SUP_Access="1"){ 
									echo "Yes"; 
							}else{
								echo "No"; 
							}?>
                            </li>
                        </ul>
                    </div><!-- .erp-user-info -->

                    <div class="erp-area-right erp-hide-print">
                        <div class="postbox leads-actions">
                            <h3 class="hndle"><span><?php _e( 'Actions', 'erp' ); ?></span></h3>
                            <div class="inside">
                                <?php
                                if ( current_user_can( 'superadmin', $masteradminview->id )) {
                                    ?>
                                    <span class="edit">
									<a class="button button-primary" href="?page=masteradminview" data-single="true"  data-id="<?php echo $masteradminview->id ?>"><?php _e( 'Edit', 'masteradmin_table_list' ); ?></a></span>
									<?php	
                                }
                                ?>
                                   <a class="button" id="erp-masteradmin-print" href="#"><?php _e( 'Print', 'erp' ); ?></a>
                            </div>
                        </div><!-- .postbox -->
                    </div><!-- .leads-right -->

                    <?php //do_action( 'erp_hr_masteradmin_single_after_info', $masteradminview ); ?>

                </div><!-- .erp-profile-top -->


                <?php //do_action( 'erp_hr_employee_single_bottom', $companyview ); ?>

            </div><!-- #erp-area-left-inner -->
        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
