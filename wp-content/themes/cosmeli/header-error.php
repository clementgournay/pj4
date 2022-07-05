<?php
/**
 * @version    1.0
 * @package    GonThemes
 * @author     GonThemes <gonthemes@gmail.com>
 * @copyright  Copyright (C) 2017 GonThemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://gonthemes.info
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>

<?php $gon_options  = gon_get_global_variables(); ?>

<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper">
	<div class="page-wrapper">
		<div class="container">
			<?php if(isset($gon_options['logo_erorr']) && $gon_options['logo_erorr']['url']!=''){ ?>
				<div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo esc_url($gon_options['logo_erorr']['url']); ?>" alt="" /></a></div>
			<?php } elseif(!empty($gon_options['logo_text'])) {?>
				<h1 class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php echo esc_html($gon_options['logo_text']); ?></a></h1>
			<?php } else { ?>
				<div class="logo">
					<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo.png' ); ?>" alt="" />
					</a>
				</div>
			<?php } ?>