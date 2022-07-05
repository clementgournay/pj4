<?php
/**
 * @package manage_showcase
 * @version 1
 */
/*
Plugin Name: Gestion de la vitrine
Plugin URI: 
Description: Changer la vitrine à partir des looks proposés
Author: Gearworks
Version: 1
Author URI:
*/

add_action( 'admin_menu', 'showcase_info_menu' );  
function showcase_info_menu() {   
    $page_title = 'Gestion Vitrine';   
    $menu_title = 'Gestion Vitrine';  
    $capability = 'manage_woocommerce';  
    $menu_slug  = 'manage_showcase';  
    $function   = 'manage_showcase_page';  
    $icon_url   = 'dashicons-visibility';  
    $position   = 7;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function manage_showcase_page() {
    require_once(__DIR__.'/showcase.php');
}

function manage_showcase_add_scripts($hook) {
    wp_enqueue_script('showcase_script', plugins_url('js/showcase.js', __FILE__));

    wp_register_style('showcase_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('looks_style');
}
add_action('admin_enqueue_scripts', 'manage_showcase_add_scripts');