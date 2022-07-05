<?php
/**
 * @package personal_shopper_assistant
 * @version 1
 */
/*
Plugin Name: Assistant Personal Shopper
Plugin URI: 
Description: Proposition de looks à partir des pièces de la boutique
Author: Gearworks
Version: 1
Author URI:
*/


require_once 'functions.php';


add_action( 'admin_menu', 'assistant_info_menu' );  
function assistant_info_menu() {   
    $page_title = 'Assistant Personal Shopper';   
    $menu_title = 'Assistant PS';  
    $capability = 'manage_woocommerce';  
    $menu_slug  = 'assistant';  
    $function   = 'assistant_page';  
    $icon_url   = 'dashicons-index-card';  
    $position   = 8;    
    global $page_hook_suffix;
    $page_hook_suffix = add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position); 
} 

function assistant_page() {
    $list_path = __DIR__.'/assistant.php';
    return require_once($list_path);
    
}

function assistant_add_scripts($hook) {
    wp_enqueue_script('assistant_modals', plugins_url('js/modals.js', __FILE__));
    wp_enqueue_script('assistant_rules', plugins_url('js/rules.js', __FILE__));
    wp_enqueue_script('assistant_look_editor', plugins_url('js/look-editor.js', __FILE__));
    wp_enqueue_script('assistant_script', plugins_url('js/assistant.js', __FILE__));
    wp_enqueue_script('assistant_font-awesome', 'https://kit.fontawesome.com/25e156ccb2.js', array(), true, '5.0' );

    wp_register_style('assistant_modal_style', plugins_url('css/modals.css', __FILE__));
    wp_register_style('assistant_look_editor_style', plugins_url('css/look-editor.css', __FILE__));
    wp_register_style('assistant_style', plugins_url('css/style.css', __FILE__));
    
    wp_enqueue_style('assistant_style');
    wp_enqueue_style('assistant_modal_style');
    wp_enqueue_style('assistant_look_editor_style');
}
add_action('admin_enqueue_scripts', 'assistant_add_scripts');