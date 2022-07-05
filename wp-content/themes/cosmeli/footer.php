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
?>
		<?php 
		$gon_options  = gon_get_global_variables(); 
		$gon_options['newsletter_show'] = isset($gon_options['newsletter_show']) ? $gon_options['newsletter_show'] : false;
		$gon_options['copyright_show'] = isset($gon_options['copyright_show']) ? $gon_options['copyright_show'] : false;
		?>
		<!--Footer Menu -->
		<div class="footer-wrapper">
			<?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
			<div class="footer-bottom">
				<div class="container">
					<div class="row footer-menu">
						<?php if (is_active_sidebar('footer-1')) : ?>
						<div class="col-lg-4 col-md-4 col-sm-6 footer-1">
							<?php 
								dynamic_sidebar('footer-1');
							?>
						</div>
						<?php endif; ?>
						<?php if (is_active_sidebar('footer-2')) : ?>
						<div class="col-lg-2 col-md-2 col-sm-6 footer-2">
							<?php 
								dynamic_sidebar('footer-2');
							?>
						</div>
						<?php endif; ?>
						<?php if (is_active_sidebar('footer-3')) : ?>
						<div class="col-lg-2 col-md-2 col-sm-6 footer-3">
							<?php 
								dynamic_sidebar('footer-3');
							?>
						</div>
						<?php endif; ?>
						<?php if (is_active_sidebar('footer-4')) : ?>
						<div class="col-lg-3 col-md-3 col-sm-6 footer-4">
							<?php 
								dynamic_sidebar('footer-4');
							?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<!-- Footer -->
			<div class="footer">
				<div class="container">
					<?php if(($gon_options['copyright_show']) ) { ?>
					<div class="copyright-block">
						<div class="copyright">
							<?php echo gon_copyright(); ?>
						</div>
					</div>
					<?php } else { ?>
					<div class="copyright">
						<?php esc_html_e('Copyright 2018 Designed By GonThemes - All Rights Reserved.', 'cosmeli'); ?>
					</div>
					<?php } ?>
					<?php if(!empty($gon_options['footer_payment']['url'])){ ?>
					<div class="payment-block">
						<img class="payment" src="<?php echo esc_url($gon_options['footer_payment']['url']); ?>" alt="" />
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div><!-- .wrapper -->
	<div class="to-top"><i class="icon-arrow-up icons"></i></div>
	<?php if($gon_options['newsletter_show']) { ?>
	<?php
	if ( isset($gon_options['newsletter_form']) && $gon_options['newsletter_form']!="" ) {
		if(class_exists( 'WYSIJA_NL_Widget' )){ ?>
			<div class="popupshadow"></div>
			<div id="newsletterpopup" class="gon-modal newsletterpopup">
				<span class="close-popup"></span>
				<div class="nl-bg">
					<?php
					the_widget('WYSIJA_NL_Widget', array(
						'title' => esc_html($gon_options['newsletter_title']),
						'form' => (int)$gon_options['newsletter_form'],
						'id_form' => 'newsletter1_popup',
						'success' => '',
					));
					?>
				</div>
			</div>
		<?php }
	}
	?>
	<?php } ?>
	<?php wp_footer(); ?>
</body>
</html>