<?php
/**
 * @version    1.0
 * @package    Cosmeli
 * @author     GonThemes
 * @copyright  Copyright (C) 2015 GonThemes Team. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.info/cosmeli/
 */

add_action('wp_enqueue_scripts', 'gon_child_enqueue_styles', 10000);
function gon_child_enqueue_styles() {
    wp_enqueue_style('gon-child-style', get_stylesheet_directory_uri() . '/style.css' );
}