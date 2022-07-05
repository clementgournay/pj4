<?php
/**
 * The template for diplaying the footer menu
 *
 * @package maudern
 * @version Maudern 1.0
 */

wp_nav_menu(
	array(
		'theme_location'  => 'footer',
		'container'       => 'div',
		'container_id'    => 'footer-menu-wrapper',
		'container_class' => 'footer-element flex-1 text-left-xlg-up text-center-xlg-down',
		'depth'           => 1,
		'menu_class'      => 'footer-menu no-list-style no-margin no-padding',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'after'           => '',
		'fallback_cb'     => false,
	)
);
