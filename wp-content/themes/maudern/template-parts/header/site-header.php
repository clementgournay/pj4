<?php
/**
 * Displays the site header.
 *
 * @package maudern
 * @version Maudern 1.0
 */

if ( Elementor_Extension::location_not_set( 'header' ) ) { ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-header-wrapper">

			<?php
			/**
			 * Hook: maudern_demo_store.
			 *
			 * @hooked woocommerce_demo_store - 10
			 */
			do_action( 'maudern_demo_store' );
			?>

			<div id="site-header" class="items-center full-width padding-r padding-l padding-t padding-b">

				<div class="row flex">
					<?php get_template_part( 'template-parts/header/menu-primary' ); ?>
					<?php get_template_part( 'template-parts/header/site-identity' ); ?>
					<?php get_template_part( 'template-parts/header/menu-secondary' ); ?>
				</div>
				<div class="row">
					
				</div>
				<div class="row">
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container'       => 'div',
							'container_id'    => 'primary-menu-wrapper',
							'container_class' => 'hidden-lg-down',
							'menu_class'      => 'primary-menu no-list-style no-margin no-padding',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'after'           => '',
							'fallback_cb'     => false,
						)
					);
					?>
				</div>
				

			</div><!-- #site-header -->

			<?php
			// Minicart Offcanvas.
			maudern_minicart();

			// Mobile Menu Offcanvas.
			maudern_mobile_menu();
			?>
		</div>
	</header><!-- #masthead -->

<?php } ?>
