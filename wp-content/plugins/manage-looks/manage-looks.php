<?php
/**
 * @package manage_looks
 * @version 1
 */
/*
Plugin Name: Gestion des looks
Plugin URI: 
Description: Voir ses looks crées et ceux des autres vendeurs
Author: Gearworks
Version: 1
Author URI:
*/

add_action( 'admin_menu', 'looks_info_menu' );  
function looks_info_menu() {   
    $page_title = 'Gestion Looks';   
    $menu_title = 'Gestion Looks';  
    $capability = 'manage_woocommerce';  
    $menu_slug  = 'manage_looks';  
    $function   = 'manage_looks_page';  
    $icon_url   = 'dashicons-visibility';  
    $position   = 7;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function manage_looks_page() {
    $home_path = __DIR__.'/home.php';
    if (isset($_GET['category'])) {
        $path = __DIR__.'/'.$_GET['category'].'.php';
        if (is_file($path)) require_once($path);
        else require_once($home_path);
    } else require_once($home_path);    
}

function manage_looks_add_scripts($hook) {
    wp_enqueue_script( 'looks_modal_script', get_template_directory_uri() . '/assets/js/parts/modals.js' );
    wp_enqueue_script('looks_script', plugins_url('js/looks.js', __FILE__));
    wp_enqueue_script('looks_html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js');

    wp_register_style('looks_modal_style', get_template_directory_uri().'/assets/css/modals.css');
    wp_register_style('looks_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('looks_style');
    wp_enqueue_style('looks_modal_style');
    wp_enqueue_style('looks_look_editor_style');
}
add_action('admin_enqueue_scripts', 'manage_looks_add_scripts');