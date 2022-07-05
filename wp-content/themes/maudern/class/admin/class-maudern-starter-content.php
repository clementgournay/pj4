<?php
/**
 * Maudern Starter Content Class
 *
 * @package  maudern
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Maudern_Starter_Content' ) ) :

	/**
	 * The Maudern Starter Content class
	 */
	class Maudern_Starter_Content {
		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			if ( is_customize_preview() && true === (bool) get_option( 'fresh_site' ) ) {
				add_action( 'after_setup_theme', array( $this, 'starter_content' ) );
				add_action( 'transition_post_status', array( $this, 'transition_post_status' ), 10, 3 );
				add_filter( 'the_title', array( $this, 'filter_auto_draft_title' ), 10, 2 );
				add_action( 'woocommerce_product_query', array( $this, 'wc_query' ) );
				add_action( 'pre_get_posts', array( $this, 'wp_query' ) );
				add_action( 'customize_preview_init', array( $this, 'add_product_tax' ), 10 );
				add_action( 'customize_preview_init', array( $this, 'set_product_data' ), 10 );
				add_action( 'customize_preview_init', array( $this, 'set_frontpage_meta' ), 10 );
			}

			if ( ! isset( $_GET['maudern_starter_content'] ) || 1 !== absint( $_GET['maudern_starter_content'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				add_filter( 'maudern_starter_content', '__return_empty_array' );
			}
		}

		/**
		 * Starter content.
		 *
		 * @since 1.0.0
		 */
		public function starter_content() {

			$starter_content = array(
				'attachments' => array(
					'maudern-logo'             => array(
						'post_title' => _x( 'Maudern Logo', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/maudern-logo.png',
					),
					'maudern-favicon'          => array(
						'post_title' => _x( 'Maudern Favicon', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/maudern-favicon.png',
					),
					'maudern-cards'            => array(
						'post_title' => _x( 'Maudern Cards', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/maudern-cards.png',
					),
					'homepage-cover'           => array(
						'post_title' => _x( 'Homepage Cover', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/homepage/cover.jpg',
					),
					'collection1'              => array(
						'post_title' => _x( 'Collection Image 1', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/collection/collection1.jpg',
					),
					'collection2'              => array(
						'post_title' => _x( 'Collection Image 2', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/collection/collection2.jpg',
					),
					'collection3'              => array(
						'post_title' => _x( 'Collection Image 3', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/collection/collection3.jpg',
					),
					'collection4'              => array(
						'post_title' => _x( 'Collection Image 4', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/collection/collection4.jpg',
					),
					'collection5'              => array(
						'post_title' => _x( 'Collection Image 5', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/collection/collection5.jpg',
					),
					'bazar'                    => array(
						'post_title' => _x( 'Bazar', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/homepage/bazar.jpg',
					),
					'instyle'                  => array(
						'post_title' => _x( 'InStyle', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/homepage/instyle.jpg',
					),
					'marie'                    => array(
						'post_title' => _x( 'Marie Claire', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/homepage/marie.jpg',
					),
					'popsugar'                 => array(
						'post_title' => _x( 'PopSugar', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/homepage/popsugar.jpg',
					),
					'vogue'                    => array(
						'post_title' => _x( 'Vogue', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/pages/homepage/vogue.jpg',
					),
					'hoodie-with-pocket-image' => array(
						'post_title' => 'Hoodie with Pocket',
						'file'       => 'assets/images/customizer/starter-content/products/hoodie-with-pocket.jpg',
					),
					'hoodie-with-zipper-image' => array(
						'post_title' => _x( 'Hoodie with Zipper', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/products/hoodie-with-zipper.jpg',
					),
					'long-sleeve-tee-image'    => array(
						'post_title' => _x( 'Long Sleeve Tee', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/products/long-sleeve-tee.jpg',
					),
					'polo-image'               => array(
						'post_title' => _x( 'Polo', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/products/polo.jpg',
					),
					'tshirt-image'             => array(
						'post_title' => _x( 'Tshirt', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/products/tshirt.jpg',
					),
					'vneck-tee-image'          => array(
						'post_title' => _x( 'Vneck Tshirt', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/products/vneck-tee.jpg',
					),
					'post-image-1'             => array(
						'post_title' => _x( 'Post Image 1', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/featured/post-one.jpg',
					),
					'post-image-2'             => array(
						'post_title' => _x( 'Post Image 2', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/featured/post-two.jpg',
					),
					'post-image-3'             => array(
						'post_title' => _x( 'Post Image 3', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/featured/post-three.jpg',
					),
					'post-image-4'             => array(
						'post_title' => _x( 'Post Image 4', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/featured/post-four.jpg',
					),
					'post-content-1'           => array(
						'post_title' => _x( 'Post Content 1', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/content/post-content-one.jpg',
					),
					'post-content-2'           => array(
						'post_title' => _x( 'Post Content 2', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/content/post-content-two.jpg',
					),
					'post-content-3'           => array(
						'post_title' => _x( 'Post Content 3', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/content/post-content-three.jpg',
					),
					'post-content-4'           => array(
						'post_title' => _x( 'Post Content 4', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/content/post-content-four.jpg',
					),
					'post-content-5'           => array(
						'post_title' => _x( 'Post Content 5', 'Theme starter content', 'maudern' ),
						'file'       => 'assets/images/customizer/starter-content/posts/content/post-content-five.jpg',
					),
				),
				// Specify the core-defined pages to create and add custom thumbnails to some of them.
				'posts'       => array(
					'frontpage'      => array(
						'post_type'    => 'page',
						'post_title'   => esc_html_x( 'Maudern Store', 'Theme starter content', 'maudern' ),
						'thumbnail'    => '{{homepage-cover}}',
						'post_content' => '<!-- wp:heading {"textAlign":"center"} -->
						<h2 class="has-text-align-center">Maudern ― a fast, reliable and well-maintained theme for your next WooCommerce Project</h2>
						<!-- /wp:heading -->

						<!-- wp:spacer {"height":10} -->
						<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
						<!-- /wp:spacer -->

						<!-- wp:woocommerce/product-new {"columns":5,"rows":1,"align":"full"} /-->

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
					'about'          => array(
						'post_type'    => 'page',
						'post_title'   => esc_html_x( 'About', 'Theme starter content', 'maudern' ),
						'post_content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4vw","right":"4vw","bottom":"4vw","left":"4vw"}}}} -->
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
					'collection'     => array(
						'post_type'    => 'page',
						'post_title'   => esc_html_x( 'Collection', 'Theme starter content', 'maudern' ),
						'post_content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5vw","right":"5vw","bottom":"5vw","left":"5vw"}}}} -->
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
					'order-tracking' => array(
						'post_type'    => 'page',
						'post_title'   => esc_html_x( 'Order Tracking', 'Theme starter content', 'maudern' ),
						'post_content' => '<!-- wp:columns {"align":"full"} -->
						<div class="wp-block-columns alignfull"><!-- wp:column -->
						<div class="wp-block-column"><!-- wp:shortcode -->
						[woocommerce_order_tracking]
						<!-- /wp:shortcode --></div>
						<!-- /wp:column -->

						<!-- wp:column -->
						<div class="wp-block-column"></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns -->',
					),
					'blog'           => array(
						'post_type'    => 'page',
						'post_title'   => esc_html_x( 'The Blog', 'Theme starter content', 'maudern' ),
						'post_content' => '',
					),
					'six-ways-to-style-out-summer-in-the-city' => array(
						'post_type'    => 'post',
						'post_title'   => esc_html_x( 'Six Ways To Style Out Summer In The City', 'Theme starter content', 'maudern' ),
						'thumbnail'    => '{{post-image-1}}',
						'post_content' => '<!-- wp:paragraph -->
						<p>I\'m baby farm-to-table heirloom synth pug photo booth, af migas dreamcatcher. Everyday carry plaid hella portland prism tumblr. Salvia farm-to-table pickled shaman copper mug franzen kickstarter intelligentsia aesthetic. Narwhal small batch messenger bag, echo park put a bird on it occupy deep v organic pitchfork skateboard keytar fam austin. Lumbersexual selfies drinking vinegar venmo. </p>
						<!-- /wp:paragraph -->

						<!-- wp:heading {"textAlign":"center","align":"wide"} -->
						<h2 class="alignwide has-text-align-center">Vexillologist art party scenester, portland affogato bushwick air plant shaman fanny pack swag live-edge tilde ramps. </h2>
						<!-- /wp:heading -->

						<!-- wp:gallery {"linkTo":"none","align":"wide"} -->
						<figure class="wp-block-gallery alignwide columns-3 is-cropped"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-one.jpg" alt="' . esc_attr_x( 'Post Content Image 1', 'Theme starter content', 'maudern' ) . '"/></figure></li><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-two.jpg" alt="' . esc_attr_x( 'Post Content Image 2', 'Theme starter content', 'maudern' ) . '"/></figure></li><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-three.jpg" alt="' . esc_attr_x( 'Post Content Image 3', 'Theme starter content', 'maudern' ) . '"/></figure></li></ul></figure>
						<!-- /wp:gallery -->

						<!-- wp:paragraph -->
						<p>Twee hexagon tbh fanny pack, knausgaard VHS beard pour-over polaroid aesthetic ramps blue bottle mlkshk deep v. Occupy you probably haven\'t heard of them shabby chic slow-carb butcher. Kinfolk squid tumeric migas live-edge man braid viral, godard meh roof party williamsburg pop-up. Mlkshk gluten-free succulents whatever squid. Lyft seitan beard everyday carry pop-up church-key cloud bread. Lumbersexual tofu photo booth try-hard chicharrones, four loko typewriter fashion axe. Synth venmo authentic.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>PBR&amp;B irony stumptown small batch leggings truffaut distillery tilde selvage kombucha. Farm-to-table pinterest cold-pressed, scenester biodiesel distillery venmo butcher listicle portland air plant iPhone. Banh mi tumeric af, taxidermy pug 8-bit blog lyft pickled selvage direct trade air plant cliche. Everyday carry waistcoat franzen, authentic tumblr +1 jean shorts. Humblebrag lo-fi succulents gentrify. Street art food truck health goth scenester, forage tote bag shaman. </p>
						<!-- /wp:paragraph -->

						<!-- wp:heading {"textAlign":"center","align":"wide"} -->
						<h2 class="alignwide has-text-align-center">Fam banh mi cold-pressed, food truck 3 wolf moon plaid snackwave fixie mumblecore everyday carry pop-up church-key cloud bread.</h2>
						<!-- /wp:heading -->

						<!-- wp:gallery {"linkTo":"none","align":"wide"} -->
						<figure class="wp-block-gallery alignwide columns-2 is-cropped"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-four.jpg" alt="' . esc_attr_x( 'Post Content Image 4', 'Theme starter content', 'maudern' ) . '"/></figure></li><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-five.jpg" alt="' . esc_attr_x( 'Post Content Image 5', 'Theme starter content', 'maudern' ) . '"/></figure></li></ul></figure>
						<!-- /wp:gallery -->

						<!-- wp:paragraph -->
						<p>I\'m baby farm-to-table heirloom synth pug photo booth, af migas dreamcatcher. Everyday carry plaid hella portland prism tumblr. Salvia farm-to-table pickled shaman copper mug franzen kickstarter intelligentsia aesthetic. Narwhal small batch messenger bag, echo park put a bird on it occupy deep v organic pitchfork skateboard keytar fam austin. Lumbersexual selfies drinking vinegar venmo. Vexillologist art party scenester, portland affogato bushwick air plant shaman fanny pack yr swag live-edge tilde +1 ramps.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Twee hexagon tbh fanny pack, knausgaard VHS beard pour-over polaroid aesthetic ramps blue bottle mlkshk deep v. Occupy you probably haven\'t heard of them shabby chic slow-carb butcher. Kinfolk squid tumeric migas live-edge man braid viral, godard meh roof party williamsburg pop-up. </p>
						<!-- /wp:paragraph -->

						<!-- wp:heading {"textAlign":"center","align":"wide"} -->
						<h2 class="alignwide has-text-align-center">Mlkshk gluten-free succulents whatever squid. Lyft seitan beard VHS, everyday carry pop-up church-key cloud bread. Lumbersexual tofu photo booth try-hard chicharrones, four loko typewriter fashion axe.</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>PBR&amp;B irony stumptown small batch leggings truffaut distillery tilde selvage kombucha. Farm-to-table pinterest cold-pressed, scenester biodiesel distillery venmo butcher listicle portland air plant iPhone. Banh mi tumeric af, taxidermy pug 8-bit blog lyft pickled selvage direct trade air plant cliche. Everyday carry waistcoat franzen, authentic tumblr +1 jean shorts. Humblebrag lo-fi succulents gentrify. .</p>
						<!-- /wp:paragraph -->',
					),
					'this-seasons-most-covetable-combat-boots' => array(
						'post_type'    => 'post',
						'post_title'   => esc_html_x( 'This Season’s Most Covetable Combat Boots', 'Theme starter content', 'maudern' ),
						'thumbnail'    => '{{post-image-2}}',
						'post_content' => '<!-- wp:paragraph -->
						<p>Vice narwhal shaman, af drinking vinegar sustainable food truck tousled aesthetic readymade glossier tilde vegan kale chips mlkshk. Hell of venmo distillery, cronut blog salvia polaroid portland. Organic trust fund venmo, beard lyft godard hot chicken leggings bespoke mixtape forage tbh selvage actually. Fashion axe migas bitters, flannel iPhone taiyaki messenger bag cold-pressed. Copper mug beard single-origin coffee pabst, yr williamsburg pork belly church-key slow-carb keffiyeh keytar tumeric truffaut selfies.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Kogi cardigan raclette keytar swag, williamsburg YOLO thundercats letterpress. Man bun flannel leggings, you probably haven\'t heard of them pickled marfa activated charcoal YOLO normcore chillwave asymmetrical cronut butcher austin. Fixie quinoa chia enamel pin taiyaki crucifix vice adaptogen post-ironic. Quinoa adaptogen VHS enamel pin, post-ironic mumblecore master cleanse asymmetrical art party shabby chic everyday carry irony literally organic poke. Everyday carry pork belly authentic waistcoat godard selvage cred sustainable, pitchfork ennui whatever retro.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Mustache tilde lo-fi, drinking vinegar vaporware four dollar toast church-key meh keffiyeh jean shorts raclette. Listicle man bun adaptogen single-origin coffee live-edge palo santo activated charcoal jianbing dreamcatcher echo park banh mi neutra man braid. Chillwave intelligentsia listicle iPhone waistcoat irony yr marfa kinfolk try-hard. Glossier fixie taxidermy mlkshk blue bottle, disrupt scenester kogi everyday carry you probably haven\'t heard of them gentrify. Vinyl pabst copper mug XOXO williamsburg truffaut live-edge gluten-free, af brooklyn squid. 8-bit roof party unicorn wolf pickled, butcher selvage thundercats literally green juice intelligentsia man braid PBR&amp;B coloring book direct trade. Health goth salvia meditation mustache, pitchfork chartreuse skateboard keytar letterpress synth.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Fixie aesthetic meditation messenger bag disrupt retro. Fam brunch pinterest vaporware yuccie prism art party vegan quinoa distillery adaptogen cliche taxidermy. Seitan tattooed yr asymmetrical blue bottle cred heirloom occupy migas DIY humblebrag tofu 90\'s slow-carb. Chambray iPhone irony hella palo santo, flexitarian vegan jianbing photo booth. Distillery readymade typewriter banjo meditation.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Paleo helvetica authentic, tacos lyft food truck selvage forage knausgaard bespoke chambray health goth sustainable pug. Flexitarian jean shorts air plant gluten-free, normcore prism intelligentsia. Portland poke tattooed man bun af. Freegan knausgaard ethical vexillologist fixie, glossier skateboard pour-over helvetica pop-up vaporware VHS coloring book seitan small batch. Pabst vape yr waistcoat woke offal subway tile jianbing schlitz single-origin coffee polaroid cliche fanny pack.</p>
						<!-- /wp:paragraph -->',
					),
					'our-latest-vanguard-line-up-the-three-eco-concious-brands-you-need-to-know' => array(
						'post_type'    => 'post',
						'post_title'   => esc_html_x( 'Our Latest Vanguard Line-Up: The Three Eco-Concious Brands You Need to Know', 'Theme starter content', 'maudern' ),
						'thumbnail'    => '{{post-image-3}}',
						'post_content' => '<!-- wp:paragraph -->
						<p>I\'m baby farm-to-table heirloom synth pug photo booth, af migas dreamcatcher. Everyday carry plaid hella portland prism tumblr. Salvia farm-to-table pickled shaman copper mug franzen kickstarter intelligentsia aesthetic. Narwhal small batch messenger bag, echo park put a bird on it occupy deep v organic pitchfork skateboard keytar fam austin. Lumbersexual selfies drinking vinegar venmo. </p>
						<!-- /wp:paragraph -->

						<!-- wp:heading {"textAlign":"center","align":"wide"} -->
						<h2 class="alignwide has-text-align-center">Vexillologist art party scenester, portland affogato bushwick air plant shaman fanny pack swag live-edge tilde ramps. </h2>
						<!-- /wp:heading -->

						<!-- wp:gallery {"linkTo":"none","align":"wide"} -->
						<figure class="wp-block-gallery alignwide columns-3 is-cropped"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-one.jpg" alt="' . esc_attr_x( 'Post Content Image 1', 'Theme starter content', 'maudern' ) . '"/></figure></li><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-two.jpg" alt="' . esc_attr_x( 'Post Content Image 2', 'Theme starter content', 'maudern' ) . '"/></figure></li><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-three.jpg" alt="' . esc_attr_x( 'Post Content Image 3', 'Theme starter content', 'maudern' ) . '"/></figure></li></ul></figure>
						<!-- /wp:gallery -->

						<!-- wp:paragraph -->
						<p>Twee hexagon tbh fanny pack, knausgaard VHS beard pour-over polaroid aesthetic ramps blue bottle mlkshk deep v. Occupy you probably haven\'t heard of them shabby chic slow-carb butcher. Kinfolk squid tumeric migas live-edge man braid viral, godard meh roof party williamsburg pop-up. Mlkshk gluten-free succulents whatever squid. Lyft seitan beard everyday carry pop-up church-key cloud bread. Lumbersexual tofu photo booth try-hard chicharrones, four loko typewriter fashion axe. Synth venmo authentic.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>PBR&amp;B irony stumptown small batch leggings truffaut distillery tilde selvage kombucha. Farm-to-table pinterest cold-pressed, scenester biodiesel distillery venmo butcher listicle portland air plant iPhone. Banh mi tumeric af, taxidermy pug 8-bit blog lyft pickled selvage direct trade air plant cliche. Everyday carry waistcoat franzen, authentic tumblr +1 jean shorts. Humblebrag lo-fi succulents gentrify. Street art food truck health goth scenester, forage tote bag shaman. </p>
						<!-- /wp:paragraph -->

						<!-- wp:heading {"textAlign":"center","align":"wide"} -->
						<h2 class="alignwide has-text-align-center">Fam banh mi cold-pressed, food truck 3 wolf moon plaid snackwave fixie mumblecore everyday carry pop-up church-key cloud bread.</h2>
						<!-- /wp:heading -->

						<!-- wp:gallery {"linkTo":"none","align":"wide"} -->
						<figure class="wp-block-gallery alignwide columns-2 is-cropped"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-four.jpg" alt="' . esc_attr_x( 'Post Content Image 4', 'Theme starter content', 'maudern' ) . '"/></figure></li><li class="blocks-gallery-item"><figure><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/customizer/starter-content/posts/content/post-content-five.jpg" alt="' . esc_attr_x( 'Post Content Image 5', 'Theme starter content', 'maudern' ) . '"/></figure></li></ul></figure>
						<!-- /wp:gallery -->

						<!-- wp:paragraph -->
						<p>I\'m baby farm-to-table heirloom synth pug photo booth, af migas dreamcatcher. Everyday carry plaid hella portland prism tumblr. Salvia farm-to-table pickled shaman copper mug franzen kickstarter intelligentsia aesthetic. Narwhal small batch messenger bag, echo park put a bird on it occupy deep v organic pitchfork skateboard keytar fam austin. Lumbersexual selfies drinking vinegar venmo. Vexillologist art party scenester, portland affogato bushwick air plant shaman fanny pack yr swag live-edge tilde +1 ramps.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Twee hexagon tbh fanny pack, knausgaard VHS beard pour-over polaroid aesthetic ramps blue bottle mlkshk deep v. Occupy you probably haven\'t heard of them shabby chic slow-carb butcher. Kinfolk squid tumeric migas live-edge man braid viral, godard meh roof party williamsburg pop-up. </p>
						<!-- /wp:paragraph -->

						<!-- wp:heading {"textAlign":"center","align":"wide"} -->
						<h2 class="alignwide has-text-align-center">Mlkshk gluten-free succulents whatever squid. Lyft seitan beard VHS, everyday carry pop-up church-key cloud bread. Lumbersexual tofu photo booth try-hard chicharrones, four loko typewriter fashion axe.</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>PBR&amp;B irony stumptown small batch leggings truffaut distillery tilde selvage kombucha. Farm-to-table pinterest cold-pressed, scenester biodiesel distillery venmo butcher listicle portland air plant iPhone. Banh mi tumeric af, taxidermy pug 8-bit blog lyft pickled selvage direct trade air plant cliche. Everyday carry waistcoat franzen, authentic tumblr +1 jean shorts. Humblebrag lo-fi succulents gentrify. .</p>
						<!-- /wp:paragraph -->',
					),
					'the-ultimate-guide-for-sneaker-shopping-for-this-season' => array(
						'post_type'    => 'post',
						'post_title'   => esc_html_x( 'The Ultimate Guide for Sneaker Shopping for This Season', 'Theme starter content', 'maudern' ),
						'thumbnail'    => '{{post-image-4}}',
						'post_content' => '<!-- wp:paragraph -->
						<p>Vice narwhal shaman, af drinking vinegar sustainable food truck tousled aesthetic readymade glossier tilde vegan kale chips mlkshk. Hell of venmo distillery, cronut blog salvia polaroid portland. Organic trust fund venmo, beard lyft godard hot chicken leggings bespoke mixtape forage tbh selvage actually. Fashion axe migas bitters, flannel iPhone taiyaki messenger bag cold-pressed. Copper mug beard single-origin coffee pabst, yr williamsburg pork belly church-key slow-carb keffiyeh keytar tumeric truffaut selfies.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Kogi cardigan raclette keytar swag, williamsburg YOLO thundercats letterpress. Man bun flannel leggings, you probably haven\'t heard of them pickled marfa activated charcoal YOLO normcore chillwave asymmetrical cronut butcher austin. Fixie quinoa chia enamel pin taiyaki crucifix vice adaptogen post-ironic. Quinoa adaptogen VHS enamel pin, post-ironic mumblecore master cleanse asymmetrical art party shabby chic everyday carry irony literally organic poke. Everyday carry pork belly authentic waistcoat godard selvage cred sustainable, pitchfork ennui whatever retro.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Mustache tilde lo-fi, drinking vinegar vaporware four dollar toast church-key meh keffiyeh jean shorts raclette. Listicle man bun adaptogen single-origin coffee live-edge palo santo activated charcoal jianbing dreamcatcher echo park banh mi neutra man braid. Chillwave intelligentsia listicle iPhone waistcoat irony yr marfa kinfolk try-hard. Glossier fixie taxidermy mlkshk blue bottle, disrupt scenester kogi everyday carry you probably haven\'t heard of them gentrify. Vinyl pabst copper mug XOXO williamsburg truffaut live-edge gluten-free, af brooklyn squid. 8-bit roof party unicorn wolf pickled, butcher selvage thundercats literally green juice intelligentsia man braid PBR&amp;B coloring book direct trade. Health goth salvia meditation mustache, pitchfork chartreuse skateboard keytar letterpress synth.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Fixie aesthetic meditation messenger bag disrupt retro. Fam brunch pinterest vaporware yuccie prism art party vegan quinoa distillery adaptogen cliche taxidermy. Seitan tattooed yr asymmetrical blue bottle cred heirloom occupy migas DIY humblebrag tofu 90\'s slow-carb. Chambray iPhone irony hella palo santo, flexitarian vegan jianbing photo booth. Distillery readymade typewriter banjo meditation.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Paleo helvetica authentic, tacos lyft food truck selvage forage knausgaard bespoke chambray health goth sustainable pug. Flexitarian jean shorts air plant gluten-free, normcore prism intelligentsia. Portland poke tattooed man bun af. Freegan knausgaard ethical vexillologist fixie, glossier skateboard pour-over helvetica pop-up vaporware VHS coloring book seitan small batch. Pabst vape yr waistcoat woke offal subway tile jianbing schlitz single-origin coffee polaroid cliche fanny pack.</p>
						<!-- /wp:paragraph -->',
					),
				),
				// Default to a static front page and assign the front and posts pages.
				'options'     => array(
					'show_on_front'  => 'page',
					'page_on_front'  => '{{frontpage}}',
					'page_for_posts' => '{{blog}}',
				),
				'theme_mods'  => array(
					'custom_logo'                    => '{{maudern-logo}}',
					'logo_height'                    => 48,
					'site_icon'                      => '{{maudern-favicon}}',
					'footer_image'                   => '{{maudern-cards}}',
					'woocommerce_catalog_columns'    => 5,
					'woocommerce_catalog_rows'       => 2,
					'woocommerce_thumbnail_cropping' => 'custom',
					'woocommerce_thumbnail_cropping_custom_width' => 70,
					'woocommerce_thumbnail_cropping_custom_height' => 95,
				),
				// Set up nav menus for each of the two areas registered in the theme.
				'nav_menus'   => array(
					// Assign a menu to the "primary" location.
					'primary' => array(
						'name'  => esc_html_x( 'Main Navigation', 'Theme starter content', 'maudern' ),
						'items' => array(
							'shop'            => array(
								'type'      => 'post_type',
								'object'    => 'page',
								'object_id' => '{{maudern_shop}}',
							),
							'page_blog',
							'page_about',
							'page_collection' => array(
								'type'      => 'post_type',
								'object'    => 'page',
								'object_id' => '{{collection}}',
							),
						),
					),
					// Assign a menu to the "primary" location.
					'footer'  => array(
						'name'  => esc_html_x( 'Footer Navigation', 'Theme starter content', 'maudern' ),
						'items' => array(
							'shop'     => array(
								'type'      => 'post_type',
								'object'    => 'page',
								'object_id' => '{{maudern_shop}}',
							),
							'cart'     => array(
								'type'      => 'post_type',
								'object'    => 'page',
								'object_id' => '{{maudern_cart}}',
							),
							'checkout' => array(
								'type'      => 'post_type',
								'object'    => 'page',
								'object_id' => '{{maudern_checkout}}',
							),
						),
					),
				),
			);

			// Add products.
			$products = new WP_Query(
				array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => 10,
				)
			);
			if ( $products->found_posts < 6 ) {
				$starter_content_wc_products = $this->starter_content_products();

				if ( ! empty( $starter_content_wc_products ) ) {
					$starter_content['posts'] = array_merge( $starter_content['posts'], $starter_content_wc_products );
				}

					// Use symbols as post name for attachments.
				foreach ( $starter_content['attachments'] as $symbol => $attachment ) {
					$starter_content['attachments'][ $symbol ]['post_name'] = $symbol;
				}
			} else {
				unset( $starter_content['attachments']['hoodie-with-pocket-image'] );
				unset( $starter_content['attachments']['hoodie-with-zipper-image'] );
				unset( $starter_content['attachments']['long-sleeve-tee-image'] );
				unset( $starter_content['attachments']['polo-image'] );
				unset( $starter_content['attachments']['tshirt-image'] );
				unset( $starter_content['attachments']['vneck-tee-image'] );
			}

							// Add WooCommerce pages.
							$starter_content_wc_pages = array();
							$woocommerce_pages        = self::get_woocommerce_pages();

			foreach ( $woocommerce_pages as $option => $page_id ) {
				$page = get_post( $page_id );

				if ( null !== $page ) {
					$starter_content_wc_pages[ 'maudern_' . $page->post_name ] = array(
						'post_title' => $page->post_title,
						'post_name'  => $page->post_name,
						'post_type'  => 'page',
					);
				}
			}

			if ( ! empty( $starter_content_wc_pages ) ) {
				$starter_content['posts'] = array_merge( $starter_content['posts'], $starter_content_wc_pages );
			}

										// Register support for starter content.
										add_theme_support( 'starter-content', apply_filters( 'maudern_starter_content', $starter_content ) );
		}

										/**
										 * Starter content products.
										 *
										 * @since 1.0.0
										 */
		private function starter_content_products() {
			$clothes_name        = esc_attr_x( 'Clothes', 'Theme starter content', 'maudern' );
			$clothes_description = esc_attr_x( 'A short category description', 'Theme starter content', 'maudern' );

			$products = array(
				'hoodie-with-pocket' => array(
					'post_title'     => esc_attr_x( 'Hoodie with Pocket', 'Theme starter content', 'maudern' ),
					'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'post_type'      => 'product',
					'comment_status' => 'open',
					'thumbnail'      => '{{hoodie-with-pocket-image}}',
					'product_data'   => array(
						'regular_price' => '45',
						'price'         => '35',
						'sale_price'    => '35',
						'featured'      => true,
					),
					'taxonomy'       => array(
						'product_cat' => array(
							array(
								'term'        => $clothes_name,
								'slug'        => 'clothes',
								'description' => $clothes_description,
							),
						),
					),
				),
				'hoodie-with-zipper' => array(
					'post_title'     => esc_attr_x( 'Hoodie with Zipper', 'Theme starter content', 'maudern' ),
					'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'post_type'      => 'product',
					'comment_status' => 'open',
					'thumbnail'      => '{{hoodie-with-zipper-image}}',
					'product_data'   => array(
						'regular_price' => '45',
						'price'         => '45',
						'featured'      => true,
					),
					'taxonomy'       => array(
						'product_cat' => array(
							array(
								'term'        => $clothes_name,
								'slug'        => 'clothes',
								'description' => $clothes_description,
							),
						),
					),
				),
				'long-sleeve-tee'    => array(
					'post_title'     => esc_attr_x( 'Long Sleeve Tee', 'Theme starter content', 'maudern' ),
					'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'post_type'      => 'product',
					'comment_status' => 'open',
					'thumbnail'      => '{{long-sleeve-tee-image}}',
					'product_data'   => array(
						'regular_price' => '25',
						'price'         => '25',
						'featured'      => false,
					),
					'taxonomy'       => array(
						'product_cat' => array(
							array(
								'term'        => $clothes_name,
								'slug'        => 'clothes',
								'description' => $clothes_description,
							),
						),
					),
				),
				'polo'               => array(
					'post_title'     => esc_attr_x( 'Polo', 'Theme starter content', 'maudern' ),
					'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'post_type'      => 'product',
					'comment_status' => 'open',
					'thumbnail'      => '{{polo-image}}',
					'product_data'   => array(
						'regular_price' => '20',
						'price'         => '20',
						'sale_price'    => '18',
						'featured'      => false,
					),
					'taxonomy'       => array(
						'product_cat' => array(
							array(
								'term'        => $clothes_name,
								'slug'        => 'clothes',
								'description' => $clothes_description,
							),
						),
					),
				),
				'tshirt'             => array(
					'post_title'     => esc_attr_x( 'Tshirt', 'Theme starter content', 'maudern' ),
					'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'post_type'      => 'product',
					'comment_status' => 'open',
					'thumbnail'      => '{{tshirt-image}}',
					'product_data'   => array(
						'regular_price' => '18',
						'price'         => '18',
						'stock_status'  => 'outofstock',
						'featured'      => false,
					),
					'taxonomy'       => array(
						'product_cat' => array(
							array(
								'term'        => $clothes_name,
								'slug'        => 'clothes',
								'description' => $clothes_description,
							),
						),
					),
				),
				'vneck-tee'          => array(
					'post_title'     => esc_attr_x( 'Vneck Tshirt', 'Theme starter content', 'maudern' ),
					'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
					'post_type'      => 'product',
					'comment_status' => 'open',
					'thumbnail'      => '{{vneck-tee-image}}',
					'product_data'   => array(
						'regular_price' => '18',
						'price'         => '18',
						'featured'      => false,
					),
					'taxonomy'       => array(
						'product_cat' => array(
							array(
								'term'        => $clothes_name,
								'slug'        => 'clothes',
								'description' => $clothes_description,
							),
						),
					),
				),
			);

			// Use symbols as post name.
			foreach ( $products as $symbol => $product ) {
				$products[ $symbol ]['post_name'] = $symbol;
			}

				return apply_filters( 'maudern_starter_content_products', $products );
		}

												/**
												 * Get WooCommerce page ids.
												 *
												 * @since 1.0.0
												 */
		public static function get_woocommerce_pages() {
			$woocommerce_pages = array();

			$wc_pages_options = apply_filters(
				'maudern_page_option_names',
				array(
					'woocommerce_cart_page_id',
					'woocommerce_checkout_page_id',
					'woocommerce_myaccount_page_id',
					'woocommerce_shop_page_id',
					'woocommerce_terms_page_id',
				)
			);

			foreach ( $wc_pages_options as $option ) {
				$page_id = get_option( $option );

				if ( ! empty( $page_id ) ) {
					$page_id = intval( $page_id );

					if ( null !== get_post( $page_id ) ) {
						$woocommerce_pages[ $option ] = $page_id;
					}
				}
			}

						return $woocommerce_pages;
		}

																/**
																 * Filter Blog main query to include starter content products.
																 *
																 * @since 1.0.0
																 * @param object $query The Query.
																 * @return void
																 */
		public function wp_query( $query ) {
			if ( ! is_customize_preview() || true !== (bool) get_option( 'fresh_site' ) ) {
				return;
			}

			if ( ! $query->is_main_query() || is_admin() || ! $query->is_home() ) {
																	return;
			}

					$post__in = array();

					// Add existing products.
					$existing_posts = $this->get_existing_wp_posts();

			if ( ! empty( $existing_posts ) ) {
																		$post__in = array_merge( $post__in, $existing_posts );
			}

																															// Add starter content.
																															$created_posts = $this->get_created_starter_content_products();

			if ( false !== $created_posts ) {

				// Merge starter content products.
				$post__in = array_merge( $post__in, $created_posts );

				// Allow for multiple status.
				$query->set( 'post_status', get_post_stati() );
			}

																															// Add products to query.
																															$query->set( 'post__in', $post__in );
		}

																					/**
																					 * Filter WooCommerce main query to include starter content products.
																					 *
																					 * @since 1.0.0
																					 * @param object $query The Query.
																					 * @return void
																					 */
		public function wc_query( $query ) {
			if ( ! is_customize_preview() || true !== (bool) get_option( 'fresh_site' ) ) {
				return;
			}

				$post__in = array();

				// Add existing products.
				$existing_products = $this->get_existing_wc_products();

			if ( ! empty( $existing_products ) ) {
																						$post__in = array_merge( $post__in, $existing_products );
			}

					// Add starter content.
					$created_products = $this->get_created_starter_content_products();

			if ( false !== $created_products ) {

																							// Merge starter content products.
																							$post__in = array_merge( $post__in, $created_products );

																							// Allow for multiple status.
																							$query->set( 'post_status', get_post_stati() );
			}

																																									// Add products to query.
																																									$query->set( 'post__in', $post__in );
		}

																									/**
																									 * Add page meta to starter content.
																									 *
																									 * @since 1.0.0
																									 */
		public function set_frontpage_meta() {
			if ( ! is_customize_preview() || true !== (bool) get_option( 'fresh_site' ) ) {
				return;
			}

				$frontpage = get_option( 'page_on_front' );
				$post_name = get_post_meta( $frontpage, '_customize_draft_post_name', true );

			if ( 'maudern-store' !== $post_name ) {
																										return;
			}

					update_post_meta( $frontpage, 'maudern_page_title', 'on' );
		}

																												/**
																												 * Add product taxonomies to starter content.
																												 *
																												 * @since 1.0.0
																												 */
		public function add_product_tax() {
			if ( ! is_customize_preview() || true !== (bool) get_option( 'fresh_site' ) ) {
				return;
			}

				$created_products = $this->get_created_starter_content_products();

			if ( false === $created_products ) {
																													return;
			}

					$starter_products = $this->starter_content_products();

			if ( is_array( $created_products ) ) {
				foreach ( $created_products as $product ) {
					$product = get_post( $product );

					if ( ! $product ) {
																														continue;
					}

																													$post_name = get_post_meta( $product->ID, '_customize_draft_post_name', true );

					if ( ! $post_name || ! array_key_exists( $post_name, $starter_products ) ) {
										continue;
					}

					if ( array_key_exists( 'product_cat', $starter_products[ $post_name ]['taxonomy'] ) ) {
						$categories = $starter_products[ $post_name ]['taxonomy']['product_cat'];

						if ( ! empty( $categories ) ) {
							$category_ids = array();

							foreach ( $categories as $category ) {
								// Check if the term already exists.
								$category_exists = term_exists( $category['term'], 'product_cat' );

								if ( $category_exists ) {
									$category_ids[] = (int) $category_exists['term_id'];

									continue;
								}

									// Create new category.
									$created_category = wp_insert_term(
										$category['term'],
										'product_cat',
										array(
											'description' => $category['description'],
											'slug'        => $category['slug'],
										)
									);

								if ( ! is_wp_error( $created_category ) ) {
									$category_ids[] = $created_category['term_id'];
								}
							}

										wp_set_object_terms( $product->ID, $category_ids, 'product_cat' );
						}
					}
				}
			}
		}

																																								/**
																																								 * Add product data to starter products.
																																								 *
																																								 * @since 1.0.0
																																								 * @return void
																																								 */
		public function set_product_data() {
			if ( ! is_customize_preview() || true !== (bool) get_option( 'fresh_site' ) ) {
				return;
			}

				$created_products = $this->get_created_starter_content_products();

			if ( false === $created_products ) {
																																									return;
			}

					$starter_products = $this->starter_content_products();

			if ( is_array( $created_products ) ) {
				foreach ( $created_products as $product ) {
					$product = wc_get_product( $product );

					if ( ! $product ) {
																																										continue;
					}

																																									$post_name = get_post_meta( $product->get_id(), '_customize_draft_post_name', true );

					if ( ! $post_name || ! array_key_exists( $post_name, $starter_products ) ) {
										continue;
					}

					if ( ! array_key_exists( 'product_data', $starter_products[ $post_name ] ) ) {
						continue;
					}

																																									$product_data = $starter_products[ $post_name ]['product_data'];

																																									// Set visibility.
																																									$product->set_catalog_visibility( 'visible' );

																																									// Set regular price.
					if ( ! empty( $product_data['regular_price'] ) ) {
							$product->set_regular_price( floatval( $product_data['regular_price'] ) );
					}

																																									// Set price.
					if ( ! empty( $product_data['price'] ) ) {
						$product->set_price( floatval( $product_data['price'] ) );
					}

																																									// Set sale price.
					if ( ! empty( $product_data['sale_price'] ) ) {
							$product->set_sale_price( floatval( $product_data['sale_price'] ) );
					}

																																									// Set price.
					if ( ! empty( $product_data['stock_status'] ) ) {
						$product->set_stock_status( strval( $product_data['stock_status'] ) );
					}

																																									// Set featured.
					if ( ! empty( $product_data['featured'] ) ) {
							$product->set_featured( true );
					} else {
						$product->set_featured( false );
					}

																																									// Save.
																																									$product->save();
				}
			}
		}

																																																						/**
																																																						 * WooCommerce 3.0.0 changes the title of all auto-draft products to "AUTO-DRAFT".
																																																						 * Here we change the title back when the post status changes.
																																																						 *
																																																						 * @since 1.0.0
																																																						 * @param string  $new_status New status.
																																																						 * @param string  $old_status Old status.
																																																						 * @param WP_Post $post       Post data.
																																																						 */
		public function transition_post_status( $new_status, $old_status, $post ) {
			if ( 'publish' === $new_status && 'auto-draft' === $old_status && in_array( $post->post_type, array( 'product' ), true ) ) {
				$post_name = get_post_meta( $post->ID, '_customize_draft_post_name', true );

				$starter_products = $this->starter_content_products();

				if ( $post_name && array_key_exists( $post_name, $starter_products ) ) {
					$update_product = array(
						'ID'         => $post->ID,
						'post_title' => $starter_products[ $post_name ]['post_title'],
					);

					wp_update_post( $update_product );
				}
			}
		}

																																																									/**
																																																									 * WooCommerce 3.0.0 changes the title of all auto-draft products to "AUTO-DRAFT".
																																																									 * Here we filter the title and display the correct one instead.
																																																									 *
																																																									 * @since 1.0.0
																																																									 * @param string $title   Post title.
																																																									 * @param int    $post_id Post id.
																																																									 */
		public function filter_auto_draft_title( $title, $post_id = null ) {
			if ( ! $post_id ) {
				return $title;
			}

				$post = get_post( $post_id );

			if ( $post && 'auto-draft' === $post->post_status && in_array( $post->post_type, array( 'product' ), true ) && 'AUTO-DRAFT' === $post->post_title ) {
																																																										$post_name = get_post_meta( $post->ID, '_customize_draft_post_name', true );

																																																										$starter_products = $this->starter_content_products();

				if ( $post_name && array_key_exists( $post_name, $starter_products ) ) {
					return $starter_products[ $post_name ]['post_title'];
				}
			}

						return $title;
		}

																																																													/**
																																																													 * Get a list of posts created by starter content.
																																																													 *
																																																													 * @since 1.0.0
																																																													 * @return mixed false|array $query Array of post ids.
																																																													 */
		private function get_created_starter_content_products() {
			global $wp_customize;

			$setting = $wp_customize->get_setting( 'nav_menus_created_posts' );

			if ( is_object( $setting ) ) {
				$created_products_ids = $setting->value();

				if ( ! empty( $created_products_ids ) ) {
					return (array) $created_products_ids;
				}
			}

					return false;
		}

																																																																/**
																																																																 * Get a list of existing products in the store.
																																																																 *
																																																																 * @since 1.0.0
																																																																 * @return array $query Array of product ids.
																																																																 */
		private function get_existing_wc_products() {
			$query_args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => -1,
			);

			$products = get_posts( $query_args );

			if ( $products && ! empty( $products ) ) {
				return $products;
			}

				return array();
		}

																																																																		/**
																																																																		 * Get a list of existing posts in the store.
																																																																		 *
																																																																		 * @since 1.0.0
																																																																		 * @return array $query Array of product ids.
																																																																		 */
		private function get_existing_wp_posts() {
			$query_args = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => -1,
			);

			$posts = get_posts( $query_args );

			if ( $posts && ! empty( $posts ) ) {
				return $posts;
			}

				return array();
		}
	}

																																																																				endif;

																																																																				return new Maudern_Starter_Content();
