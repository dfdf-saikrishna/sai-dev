<?php

// Actions *****************************************************************/
add_action( 'admin_init', 'post_travel_request' );

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
add_action( 'show_user_profile', 'additional_profile_fields' );
add_action( 'edit_user_profile', 'additional_profile_fields' );


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
// Filters *****************************************************************/

