<?php
/**
 * The Header 3 template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Ginthemes
 *
 * Websites: http://gonthemes.info
 */
?>

<?php 
	$gon_options  = gon_get_global_variables();
	$woocommerce 	= gon_get_global_variables('woocommerce'); 
	
	$gon_options['title_mobile_menu'] = isset($gon_options['title_mobile_menu']) ? $gon_options['title_mobile_menu'] : esc_html__('Menu', 'cosmeli');
	$gon_options['category_title'] = isset($gon_options['category_title']) ? $gon_options['category_title'] : '';
	$gon_options['mini_cart_title'] = isset($gon_options['mini_cart_title']) ? $gon_options['mini_cart_title'] : '';

	$top_class = '';
?>
	<div class="top-wrapper header-style-1">
		<div class="header-container">
			<div class="top-bar <?php if (is_admin_bar_showing()) { echo 'logedin'; } ?>">
				<div id="top">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 top-1">
								<?php if(!empty($gon_options['header_contact']) || ($gon_options['header_contact'] != '')) { ?>
								<span class="contact"><i class="fa fa-envelope color"></i> <?php echo esc_html($gon_options['header_contact']); ?></span>
								<?php } ?>
								<?php if(!empty($gon_options['header_hotline']) || ($gon_options['header_hotline'] != '')) { ?>
									<span class="hotline"><i class="fa fa-phone color"></i> <?php echo esc_html($gon_options['header_hotline']); ?></span>
								<?php } ?>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 top-2">
								<div class="topbar-menu">
									<?php if($gon_options['header_social_show'] == true) { ?>
									<?php
									if(isset($gon_options['hdsocial_icons'])) {
										echo '<ul class="link-follow">';
										foreach($gon_options['hdsocial_icons'] as $key=>$value ) {
											if($value!=''){
												if($key=='vimeo'){
													echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'"><i class="fa fa-vimeo-square"></i></a></li>';
												} else {
													echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
												}
											}
										}
										echo '</ul>';
									}
									?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 sp-logo">
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
									<img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo.png' ); ?>" alt="" />
								</a>
							</div>
						<?php } ?>
						</div>
						<?php if(class_exists('WC_Widget_Product_Search')) { ?>
						<div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 search-block">
							<div class="top-search">
								<div class="mobile-search"><i class="icon-magnifier icons"></i></div>
								<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
							</div>
						</div>
						<?php } ?>
						<?php if (class_exists('WC_Widget_Cart')) { ?>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-2 sp-cart">
							<?php if (class_exists('WC_Widget_Cart')) { ?>
							<div class="top-cart">
								<?php the_widget('Custom_WC_Widget_Cart', array('title' => $gon_options['mini_cart_title'])); ?>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="menu-block">
				<div class="container">
					<!-- Menu -->
					<div class="sp-menu <?php if(! class_exists('WC_Widget_Product_Categories')) { echo 'no-category'; } ?>">
						<?php if(class_exists('WC_Widget_Product_Categories')) { ?>
						<div class="top-category">
							<div class="mobile-category"><?php echo esc_html($gon_options['category_title']); ?> <i class="icon-arrow-down icons"></i></div>
							<?php the_widget('WC_Widget_Product_Categories', array('title' => $gon_options['category_title'])); ?>
						</div>
						<?php } ?>
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
				</div>
			</div>
		</div>
	</div>
	
