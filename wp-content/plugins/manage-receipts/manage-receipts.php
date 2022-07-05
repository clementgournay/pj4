<?php
/**
 * @package manage_receipts
 * @version 1
 */
/*
Plugin Name: Gestion des tickets de caisse
Plugin URI: 
Description: Associer un ticket de caisse à un client
Author: Gearworks
Version: 1
Author URI:
*/

add_action( 'admin_menu', 'manage_receipts_info_menu' );  
function manage_receipts_info_menu() {   
    $page_title = 'Gestion des tickets';   
    $menu_title = 'Gestion des tickets';  
    $capability = 'manage_woocommerce';  
    $menu_slug  = 'manage_receipts';  
    $function   = 'manage_receipts_page';  
    $icon_url   = 'dashicons-format-aside';  
    $position   = 6;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function manage_receipts_page() {
    $list_path = __DIR__.'/receipt-list.php';
    if (isset($_GET['feature'])) {
        $path = __DIR__.'/feature-'.$_GET['feature'].'.php';
        if (is_file($path)) require_once($path);
        else require_once($list_path);
    } else require_once($list_path);
    
}

function manage_receipts_add_scripts($hook) {
    wp_enqueue_script('clients_modal_script', get_template_directory_uri() . '/assets/js/parts/modals.js' );
    wp_enqueue_script('receipts_script', plugins_url('js/receipts.js', __FILE__));

    wp_register_style('clients_modal_style', get_template_directory_uri().'/assets/css/modals.css');
    wp_register_style('receipts_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('receipts_style');
    wp_enqueue_style('receipts_modal_style');
    wp_enqueue_style('receipts_look_editor_style');
}
add_action('admin_enqueue_scripts', 'manage_receipts_add_scripts');