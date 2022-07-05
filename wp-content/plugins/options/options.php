<?php
/**
 * @package options
 * @version 1
 */
/*
Plugin Name: Options du site 
Plugin URI: 
Description: Changer les différentes options du site.
Author: Gearworks
Version: 1
Author URI:
*/

add_action( 'admin_menu', 'options_menu' );  
function options_menu() {   
    $page_title = 'Options';   
    $menu_title = 'Options';  
    $capability = 'manage_options';  
    $menu_slug  = 'options';  
    $function   = 'options_page';  
    $icon_url   = 'dashicons-admin-generic';  
    $position   = 2;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function options_page() {
    require_once('option-page.php');
}

function options_add_scripts($hook) {
    wp_enqueue_script('options_script', plugins_url('js/options.js', __FILE__));

    wp_register_style('options_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('options_style');
}
add_action('admin_enqueue_scripts', 'options_add_scripts');