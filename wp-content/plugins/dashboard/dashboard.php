<?php
/**
 * @package dashboard
 * @version 1
 */
/*
Plugin Name: Tableau de bord
Plugin URI: 
Description: Tableau de bord avancé
Author: Gearworks
Version: 1
Author URI:
*/

add_action( 'admin_menu', 'dashboard_info_menu' );  
function dashboard_info_menu() {   
    $page_title = 'Tableau de bord';   
    $menu_title = 'Tableau de bord';  
    $capability = 'manage_woocommerce';  
    $menu_slug  = 'dashboard';  
    $function   = 'dashboard_page';  
    $icon_url   = 'dashicons-dashboard';  
    $position   = 6;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function dashboard_page() {
    require_once('dashboard-page.php');
}

function dashboard_add_scripts($hook) {
    wp_enqueue_script('dashboard_script', plugins_url('js/dashboard.js', __FILE__));
    wp_enqueue_script('dashboard_font-awesome', 'https://kit.fontawesome.com/25e156ccb2.js', array(), true, Maudern::get_theme_version() );

    wp_register_style('dashboard_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('dashboard_style');
}
add_action('admin_enqueue_scripts', 'dashboard_add_scripts');