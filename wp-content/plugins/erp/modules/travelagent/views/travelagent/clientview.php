	<div class="wrap erp erp-clientview erp-clientview-single">
	<div class="erp-single-container erp-clientview-wrap" id="erp-single-container-wrap">
	<div class="erp-area-left full-width erp-clientview-wrap-inner">
	<div id="erp-area-left-inner">
		<script type="text/javascript">
		window.wpErpCurrentClientview = <?php echo json_encode( $clientview->to_array() ); ?>
		</script>

	<div class="erp-user-info">
	<div class="erp-profile-top">
	<div class="postbox leads-actions">
		<h2 class="erp-hide-print"><?php _e( 'COMPANIES -Company Details View', 'erp' );?> </h2>
		<h3 class="hndle"><span><?php _e( 'Travel Agent :Client detailed view', 'erp' ); ?></span></h3>
		<div class="erp-profile-top">
		<div class="erp-avatar">
		<?php if($clientview->COM_Logo!=""){ ?>
		<img src="<?php echo $clientview->COM_Logo; ?>" width="150px" height="150px" />
		<?php }else{ ?>
		<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=150&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=300&amp;d=mm&amp;r=g 2x" class="avatar avatar-150 photo" width="150" height="150">
		<?php } ?>
		</div>
		</div>
				<div class="inside">
				<ul class="erp-list two-col separated">

				<li><?php erp_print_key_value( __( 'First Name', 'erp' ), $clientview->COM_Name); ?></li>
				<li><?php erp_print_key_value( __( 'Employee Username Prefix', 'erp' ), $clientview->COM_Prefix); ?></li>
				<li><?php erp_print_key_value( __( 'Mobile', 'erp' ), $clientview->COM_Mobile); ?></li>
				<li><?php erp_print_key_value( __( 'Email', 'erp' ), erp_get_clickable( 'email', $clientview->COM_Email) ); ?></li>
				<li><?php erp_print_key_value( __( 'Landline', 'erp' ), $clientview->COM_Landline); ?></li>
				<li><?php erp_print_key_value( __( 'Address', 'erp' ), $clientview->COM_Address); ?></li>
				<li><?php erp_print_key_value( __( 'Location Details', 'erp' ), $clientview->COM_Location . ",". $clientview->COM_City .", ". $clientview->COM_State); ?></li>
				<li><?php erp_print_key_value( __( 'Contact Person 1', 'erp' ), $clientview->COM_Cp1username .", ".$clientview->COM_Cp1email .", ".$clientview->COM_Cp1mobile); ?></li>
				<li><?php erp_print_key_value( __( 'Contact Person 2', 'erp' ),$clientview->COM_Cp2username .", ".$clientview->COM_Cp2email .", ".$clientview->COM_Cp2mobile ); ?></li>
				<?php 
				global $wpdb;
				$selsql = $wpdb->get_results("SELECT * FROM travel_desk_bank_account WHERE $clientview->TDBA_Id");
				if(!empty($selsql)){
				?>
				<li><?php erp_print_key_value( __( 'Bank Account', 'erp' ),$clientview['TDBA_BankName'].'-'.$clientview['TDBA_BranchName'].'-'.$clientview['TDBA_BranchName'].'-'.$clientview['TDBA_AccountNumber']); ?></li>
				<?php } else{ ?>
				<li><?php erp_print_key_value( __( 'Bank Account', 'erp' ),'---'); ?></li>
				<?php } ?>	
				<?php do_action( 'erp-hr-employee-single-basic', $clientview ); ?>
				</ul>
				</div>
	</div><!-- .postbox -->
	</div><!-- .erp-profile-top -->


	<div class="postbox leads-actions">
		<h2 class="erp-hide-print"><?php _e( 'Marketing/Sales Persons Comment', 'erp' );?> </h2>
		<div class="handlediv" title="<?php _e( 'Click to toggle', 'erp' ); ?>"><br></div>
		<h3 class="hndle"><span><?php _e( 'Detail Description ABOUT THE DEAL', 'erp' ); ?></span></h3>
		<div class="inside">
		<ul class="erp-list">
		<li><?php erp_print_key_value( __( 'Marketing/Sales persons name', 'erp' ), $clientview->COM_Spname); ?></li>
		<li><?php erp_print_key_value( __( 'Email-Id', 'erp' ), $clientview->COM_Spemail); ?></li>  
		<li><?php erp_print_key_value( __( 'Contact Number', 'erp' ), $clientview->COM_Spcontactno); ?></li> 
		<li><?php erp_print_key_value( __( 'Description about this deal', 'erp' ), $clientview->COM_Descdeal); ?></li>
		</ul>
		</div>
	</div><!-- .postbox -->
	</div><!-- .erp-user-info -->

	</div><!-- #erp-area-left-inner -->
	</div><!-- .leads-left -->
	</div><!-- .erp-leads-wrap -->
	</div>
