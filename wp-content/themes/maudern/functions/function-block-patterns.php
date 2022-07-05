<?php
/**
 * Starter Content and Block Patterns.
 *
 * @package maudern
 */

/**
 * Register Block Patterns.
 */
function maudern_register_block_patterns() {

	$block_patterns = array(
		'frontpage'      => array(
			'title'       => 'Frontpage',
			'description' => '',
			'content'     => '<!-- wp:heading {"textAlign":"center"} -->
			<h2 class="has-text-align-center">Maudern ― a fast, reliable and well-maintained theme for your next WooCommerce Project</h2>
			<!-- /wp:heading -->

			<!-- wp:spacer {"height":10} -->
			<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:woocommerce/product-new {"columns":5,"rows":2,"align":"full"} /-->

			<!-- wp:heading {"textAlign":"center"} -->
			<h2 class="has-text-align-center">Authentic shoreditch next level, banh mi craft beer air plant chillwave banjo chia synth coloring book slow-carb tousled hella pour-over disrupt vinyl.</h2>
			<!-- /wp:heading -->

			<!-- wp:spacer {"height":10} -->
			<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:columns {"verticalAlignment":"center","align":"full"} -->
			<div class="wp-block-columns alignfull are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","width":172,"height":44,"sizeSlug":"large","linkDestination":"custom"} -->
			<div class="wp-block-image"><figure class="aligncenter size-large is-resized"><a href="#"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/homepage/vogue.jpg" alt="' . esc_attr_x( 'Homepage Image', 'Theme starter content', 'maudern' ) . '" width="172" height="44"/></a></figure></div>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","width":280,"height":55,"sizeSlug":"large","linkDestination":"custom"} -->
			<div class="wp-block-image"><figure class="aligncenter size-large is-resized"><a href="#"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/homepage/marie.jpg" alt="' . esc_attr_x( 'Homepage Image', 'Theme starter content', 'maudern' ) . '" width="280" height="55"/></a></figure></div>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","width":183,"height":44,"sizeSlug":"large","linkDestination":"custom"} -->
			<div class="wp-block-image"><figure class="aligncenter size-large is-resized"><a href="#"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/homepage/bazar.jpg" alt="' . esc_attr_x( 'Homepage Image', 'Theme starter content', 'maudern' ) . '" width="183" height="44"/></a></figure></div>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","width":280,"height":43,"sizeSlug":"large","linkDestination":"custom"} -->
			<div class="wp-block-image"><figure class="aligncenter size-large is-resized"><a href="#"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/homepage/popsugar.jpg" alt="' . esc_attr_x( 'Homepage Image', 'Theme starter content', 'maudern' ) . '" width="280" height="43"/></a></figure></div>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","width":226,"height":68,"sizeSlug":"large","linkDestination":"custom"} -->
			<div class="wp-block-image"><figure class="aligncenter size-large is-resized"><a href="#"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/homepage/instyle.jpg" alt="' . esc_attr_x( 'Homepage Image', 'Theme starter content', 'maudern' ) . '" width="226" height="68"/></a></figure></div>
			<!-- /wp:image --></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->

			<!-- wp:latest-posts {"postsToShow":4,"excerptLength":16,"displayPostDate":true,"postLayout":"grid","columns":4,"displayFeaturedImage":true,"featuredImageSizeSlug":"large","addLinkToFeaturedImage":true,"align":"full"} /-->',
		),
		'collection'     => array(
			'title'       => 'Collection',
			'description' => '',
			'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5vw","right":"5vw","bottom":"5vw","left":"5vw"}}}} -->
			<div class="wp-block-group alignfull" style="padding-top:5vw;padding-right:5vw;padding-bottom:5vw;padding-left:5vw"><!-- wp:columns -->
			<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:woocommerce/product-new {"rows":2} /--></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection1.jpg" alt="' . esc_attr_x( 'Collection Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->

			<!-- wp:columns -->
			<div class="wp-block-columns"><!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection2.jpg" alt="' . esc_attr_x( 'Collection Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:woocommerce/product-new {"rows":2} /--></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->

			<!-- wp:columns -->
			<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:woocommerce/product-new {"rows":2,"categories":[],"contentVisibility":{"title":true,"price":true,"rating":true,"button":true}} /--></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection3.jpg" alt="' . esc_attr_x( 'Collection Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->

			<!-- wp:columns -->
			<div class="wp-block-columns"><!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection4.jpg" alt="' . esc_attr_x( 'Collection Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:woocommerce/product-new {"columns":2,"rows":1} /--></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->

			<!-- wp:columns -->
			<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center"><!-- wp:woocommerce/product-new {"rows":2} /--></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection5.jpg" alt="' . esc_attr_x( 'Collection Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns --></div>
			<!-- /wp:group -->',
		),
		'about'          => array(
			'title'       => 'About',
			'description' => '',
			'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4vw","right":"4vw","bottom":"4vw","left":"4vw"}}}} -->
			<div class="wp-block-group alignfull" style="padding-top:4vw;padding-right:4vw;padding-bottom:4vw;padding-left:4vw"><!-- wp:columns -->
			<div class="wp-block-columns"><!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection1.jpg" alt="' . esc_attr_x( 'About Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/pages/collection/collection2.jpg" alt="' . esc_attr_x( 'About Image', 'Theme starter content', 'maudern' ) . '"/></figure>
			<!-- /wp:image --></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:heading -->
			<h2>Chicharrones street art beard iceland, venmo selfies cray pour-over. Cardigan single-origin coffee etsy neutra. </h2>
			<!-- /wp:heading -->

			<!-- wp:separator {"className":"is-style-wide"} -->
			<hr class="wp-block-separator is-style-wide"/>
			<!-- /wp:separator -->

			<!-- wp:paragraph -->
			<p>2718 Wilkinson Court Avenue,<br>Fort Myers, FL 33901</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p>Phone: +00 001 234 567<br>Email: hello@emailexample.com</p>
			<!-- /wp:paragraph -->

			<!-- wp:social-links {"iconColor":"black","iconColorValue":"#000000","className":"is-style-logos-only"} -->
			<ul class="wp-block-social-links has-icon-color is-style-logos-only"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

			<!-- wp:social-link {"url":"#","service":"twitter"} /-->

			<!-- wp:social-link {"url":"#","service":"instagram"} /--></ul>
			<!-- /wp:social-links --></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns --></div>
			<!-- /wp:group -->

			<!-- wp:paragraph -->
			<p></p>
			<!-- /wp:paragraph -->',
		),
		'order-tracking' => array(
			'title'       => 'Order Tracking',
			'description' => '',
			'content'     => '<!-- wp:columns {"align":"full"} -->
			<div class="wp-block-columns alignfull"><!-- wp:column -->
			<div class="wp-block-column"><!-- wp:shortcode -->
			[woocommerce_order_tracking]
			<!-- /wp:shortcode --></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->

			<!-- wp:paragraph -->
			<p></p>
			<!-- /wp:paragraph -->',
		),
	);

	if ( function_exists( 'register_block_pattern' ) && function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'maudern',
			array( 'label' => _x( 'Maudern', 'Block Patterns Category', 'maudern' ) )
		);

		foreach ( $block_patterns as $key => $pattern ) {

			if ( class_exists( 'WP_Block_Patterns_Registry' ) && ! WP_Block_Patterns_Registry::get_instance()->is_registered( 'maudern/' . $key ) ) {
				register_block_pattern(
					'maudern/' . $key,
					array(
						'categories'  => array( 'maudern' ),
						'title'       => $pattern['title'],
						'description' => $pattern['description'],
						'content'     => $pattern['content'],
					)
				);
			}
		}
	}
}
add_action( 'init', 'maudern_register_block_patterns' );


