<?php

// Actions *****************************************************************/
//add_action('wp_login', 'custom_login');
add_action( 'admin_menu', 'custom_menu_page_removing' );
add_action('login_head', 'my_loginlogo');
add_action('admin_head','favicon');
add_action( 'login_head', 'hide_login_nav' );
add_action('admin_head', 'hid_wordpress_thankyou');

// Filters *****************************************************************/
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
add_filter('login_headertitle', 'my_loginURLtext');

