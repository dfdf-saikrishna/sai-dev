<div class="wrap erp erp-hr-travelagent erp-travelagent-single">

    <h2 class="erp-hide-print"><?php _e( 'Travel Agents View', 'erp' );?> </h2>
    <div class="erp-single-container erp-hr-travelagent-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-travelagent-wrap-inner">
            <div id="erp-area-left-inner">
                <script type="text/javascript">
                    window.wpErpCurrentTravelAgentview = <?php echo json_encode( $travelagentview->to_array() ); ?>
                </script>
                <div class="erp-profile-top">
                 
                    <div class="erp-user-info">
                        <label for="name">Username</label>
                        <h3><span class="title"><?php echo $travelagentview->SUP_Username; ?></span></h3>
                        <ul class="lead-info">
                <!--<h1>dbjdsb</h1>-->
                            <li>
                                <a href="mailto:<?php echo $travelagentview->SUP_Email; ?>"><?php echo $travelagentview->SUP_Email; ?></a>
                            </li>
                            <li>
                                <?php echo $travelagentview->SUP_AgencyName; ?>
                            </li>
                            <li>
                                <?php echo $travelagentview->SUP_Address; ?>
                            </li>
                            <li>
                                <?php echo $travelagentview->SUP_Name; ?>
                            </li>
                            <li>
                                <?php echo $travelagentview->SUP_Contact; ?>
                            </li>
                        </ul>
                    </div><!-- .erp-user-info -->

                    <div class="erp-area-right erp-hide-print">
                        <div class="postbox leads-actions">
                            <h3 class="hndle"><span><?php _e( 'Actions', 'erp' ); ?></span></h3>
                            <div class="inside">
                                <?php
                                if ( current_user_can( 'superadmin', $travelagentview->id )) {
                                    ?>
                                    <span class="edit">
                                        <a class="button button-primary" href="?page=travelagents" data-single="true"  data-id="<?php echo $travelagentview->id ?>"><?php _e('Edit', 'travelagent_table_list'); ?></a></span>
                                        <?php
                                    }
                                ?>
                                   <a class="button" id="erp-employee-print" href="#"><?php _e( 'Print', 'erp' ); ?></a>
                            </div>
                        </div><!-- .postbox -->
                    </div><!-- .leads-right -->

                    <?php //do_action( 'erp_hr_employee_single_after_info', $travelagentview ); ?>

                </div><!-- .erp-profile-top -->

               

                <?php //do_action( 'erp_hr_employee_single_bottom', $travelagentview ); ?>

            </div><!-- #erp-area-left-inner -->
        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
