<?php
/**
 * The Header 2 template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage GonThemes
 *
 * Websites: http://gonthemes.info
 */
?>

<?php 
	$gon_options  = gon_get_global_variables();
	$woocommerce 	= gon_get_global_variables('woocommerce');  
	$gon_options['title_mobile_menu'] = isset($gon_options['title_mobile_menu']) ? $gon_options['title_mobile_menu'] : '';
	$gon_options['mini_cart_title'] = isset($gon_options['mini_cart_title']) ? $gon_options['mini_cart_title'] : '';
?>
	<div class="top-wrapper header-style-3">
		<div class="header-container">
			<div class="menu-block">
				<div class="menu-inner">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 sp-logo">
						<?php if(!empty($gon_options['logo_main']['url'])){ ?>
							<div class="logo">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
									<img src="<?php echo esc_url($gon_options['logo_main']['url']); ?>" alt="" />
								</a>
							</div>
						<?php } elseif(!empty($gon_options['logo_text'])) {?>
							<h1 class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php echo esc_html($gon_options['logo_text']); ?></a></h1>
						<?php } else { ?>
							<div class="logo">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
									<img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo-white.png' ); ?>" alt="" />
								</a>
							</div>
						<?php } ?>
						</div>
						<!-- Menu -->
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 main-menu">
							<div class="sp-menu">
								<div class="menu-wrapper">
									<div id="header-menu" class="header-menu visible-large">
										<?php echo wp_nav_menu(array('theme_location' => 'primary')); ?>
									</div>
									<div class="visible-small">
										<div class="mbmenu-toggler"><span><?php echo esc_html($gon_options['title_mobile_menu']); ?></span><span class="mbmenu-icon"></span></div>
										<div class="nav-container">
											<?php wp_nav_menu(array('theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu')); ?>
										</div>
									</div>
								</div>
							</div>
							<?php if (class_exists('WC_Widget_Cart') || class_exists('WC_Widget_Product_Search') || class_exists('WC_Widget_Product_Categories')) { ?>
							<div class="top-list">
								<div class="top-list-services">
									<?php if(class_exists('WC_Widget_Product_Search')) { ?>
									<div class="top-search">
										<div class="mobile-search"><i class="icon-magnifier icons"></i></div>
										<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
									</div>
									<?php } ?>
									<?php if (class_exists('WC_Widget_Cart')) { ?>
									<div class="top-cart">
										<?php the_widget('Custom_WC_Widget_Cart', array('title' => $gon_options['mini_cart_title'])); ?>
									</div>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
