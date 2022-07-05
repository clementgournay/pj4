<?php
/**
 * Footer file for Maudern theme.
 *
 * @package maudern
 * @since Maudern 1.0
 */

?>


<!--<script>(function(){var js,fs,d=document,id="tars-widget-script",b="https://tars-file-upload.s3.amazonaws.com/bulb/";if(!d.getElementById(id)){js=d.createElement("script");js.id=id;js.type="text/javascript";js.src=b+"js/widget.js";fs=d.getElementsByTagName("script")[0];fs.parentNode.insertBefore(js,fs)}})();window.tarsSettings = {"convid":"cV-2RX"};</script>-->


			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php if ( Elementor_Extension::location_not_set( 'footer' ) ) { ?>

		<footer id="site-footer" role="contentinfo" class="site-footer padding-r padding-l padding-t-sm padding-b-sm">

			<?php get_template_part( 'template-parts/footer/widgets-area' ); ?>

			<div class="sub-footer flex-xlg-up">

				<?php get_template_part( 'template-parts/footer/menu-footer' ); ?>
				<?php get_template_part( 'template-parts/footer/image' ); ?>
				<?php get_template_part( 'template-parts/footer/text-note' ); ?>
			</div>

		</footer><!-- #site-footer -->

	<?php } ?>

	</div><!-- #page -->

	<?php /* get_template_part( 'template-parts/common/chatbox' );*/ ?>

	<?php wp_footer(); ?>

	</body>
</html>
