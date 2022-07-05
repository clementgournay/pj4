<?php
/**
 * @package manage_clients
 * @version 1
 */
/*
Plugin Name: Gestion des clients
Plugin URI: 
Description: Voir le dressing du client, proposer des looks etc...
Author: Gearworks
Version: 1
Author URI:
*/

add_action( 'admin_menu', 'clients_info_menu' );  
function clients_info_menu() {   
    $page_title = 'Gestion des clients';   
    $menu_title = 'Gestion des clients';  
    $capability = 'manage_woocommerce';  
    $menu_slug  = 'manage_clients';  
    $function   = 'manage_clients_page';  
    $icon_url   = 'dashicons-admin-users';  
    $position   = 6;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function manage_clients_page() {
    $list_path = __DIR__.'/client-list.php';
    if (isset($_GET['feature'])) {
        $path = __DIR__.'/feature-'.$_GET['feature'].'.php';
        if (is_file($path)) require_once($path);
        else require_once($list_path);
    } else require_once($list_path);
    
}

function manage_clients_add_scripts($hook) {
    wp_enqueue_script('clients_modal_script', get_template_directory_uri() . '/assets/js/parts/modals.js' );
    wp_enqueue_script('clients_script', plugins_url('js/clients.js', __FILE__));
    wp_enqueue_script('clients_slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js');
    wp_enqueue_script('clients_font-awesome', 'https://kit.fontawesome.com/25e156ccb2.js', array(), true, Maudern::get_theme_version() );


    wp_register_style('clients_modal_style', get_template_directory_uri().'/assets/css/modals.css');
    wp_register_style('clients_dashboard_style', get_template_directory_uri().'/assets/css/dashboard.css');
    wp_register_style('clients_slick_style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), Maudern::get_theme_version(), 'all' );
	wp_register_style('clients_slick_theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array(), Maudern::get_theme_version(), 'all' );
    wp_register_style('clients_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('clients_style');
    wp_enqueue_style('clients_modal_style');
    wp_enqueue_style('clients_look_editor_style');
    wp_enqueue_style('clients_dashboard_style');
    wp_enqueue_style('clients_slick_style');
    wp_enqueue_style('clients_slick_theme');
}
add_action('admin_enqueue_scripts', 'manage_clients_add_scripts');