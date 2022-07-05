<?php
/**
 * Header file for Maudern theme.
 *
 * @package maudern
 * @since Maudern 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" >

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Slab&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">

	<?php wp_head(); ?>

</head>


<body data-site-url="<?php echo get_site_url(); ?>" data-template-dir="<?php echo get_template_directory_uri(); ?>" <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="page" class="site">

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'maudern' ); ?></a>

		<?php get_template_part( 'template-parts/header/site-header' ); ?>

		<div id="content" class="site-content">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<div class="overlay"></div>
