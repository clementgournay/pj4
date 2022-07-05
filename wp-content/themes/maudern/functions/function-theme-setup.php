<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @package maudern
 * @since 1.0
 */

 define('MY_ACCOUNT_URL', get_permalink(get_option('woocommerce_myaccount_page_id')));

if ( ! function_exists( 'maudern_setup' ) ) :
	/**
	 * Theme setup function.
	 */
	function maudern_setup() {

		if ( ! isset( $content_width ) ) {
			$content_width = 775;
		}

		// Load theme languages.
		load_theme_textdomain( 'maudern', get_template_directory() . '/languages' );

		// Enable support for post thumbnails and featured images.
		add_theme_support( 'post-thumbnails' );

		// Enable block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for block embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for template editor.
		add_theme_support( 'block-templates' );

		// Add automatic feed links for post and comment in the head.
		add_theme_support( 'automatic-feed-links' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for WooCommerce.
		add_theme_support( 'woocommerce' );

		// Woocommerce Gallery.
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );

		// Add title-tag support.
		add_theme_support( 'title-tag' );

		// Google font weights filter.
		add_filter( 'maudern_google_font_weights', array( 'Maudern_Fonts', 'get_google_font_weights' ), 10, 1 );

		// Add support for custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 50,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Registrer menus.
		register_nav_menus(
			array(
				'primary'   => esc_html_x( 'Primary Menu', 'Menu Locations', 'maudern' ),
				'secondary' => esc_html_x( 'Mobile Menu', 'Menu Locations', 'maudern' ),
				'footer'    => esc_html_x( 'Footer Menu', 'Menu Locations', 'maudern' ),
			)
		);

		// Add support for HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
			)
		);

		// Block editor styles.
		add_editor_style( 'assets/css/editor-styles.css' );

		// Excerpt Settings.
		add_filter(
			'excerpt_length',
			function() {
				return 60;
			},
			999
		);
		add_filter(
			'excerpt_more',
			function() {
				return ' ...';
			},
			21
		);


	}
endif;
add_action( 'after_setup_theme', 'maudern_setup' );

add_action(
	'init',
	function() {
		add_post_type_support( 'page', 'page-attributes' );
	}
);


/**
 * Registers widget areas.
 */
function maudern_register_widget_areas() {
	register_sidebar(
		array(
			'name'          => esc_html_x( 'Shop Filters', 'Sidebar name', 'maudern' ),
			'id'            => 'shop-filters-widgets',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html_x( 'Footer Widgets', 'Sidebar name', 'maudern' ),
			'id'            => 'footer-widgets',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'maudern_register_widget_areas' );


function custom_dashboard_widgets() {
	global $current_user;
	global $wp_meta_boxes;

	if (!in_array('administrator', $current_user->roles)) {
		$wp_meta_boxes['dashboard']['normal']['core'] = array();
		$wp_meta_boxes['dashboard']['side']['core'] = array();
		remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal');
	}

	wp_add_dashboard_widget('objective_widget', 'Objectif boutique', 'objective_widget');
	wp_add_dashboard_widget('my_objectives_widget', 'Mes objectifs du mois', 'my_objectives_widget');
	wp_add_dashboard_widget('sales_widget', 'Ventes ces 6 derniers mois', 'sales_widget');
	wp_add_dashboard_widget('categories_widget', 'Vêtements vendus par catégorie', 'categories_widget');
	//wp_add_dashboard_widget('last_order_widget', 'Dernières commandes', 'last_order_widget');
	//wp_add_dashboard_widget('my_tasks_widget', 'Mes tâches', 'my_tasks_widget');
}
add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

function objective_widget() {
	echo '<div id="objective" class="progress">
		<div class="text">4500/5000€</div>
		<svg>
			<circle class="bg" cx="150" cy="150" r="120" />
			<circle class="meter-1" cx="150" cy="150" r="120" />
		</svg>
  	</div>';
}

function my_objectives_widget() {
	echo '<h3>Looks proposés</h3>';
	echo '<div id="my-objectives" class="progress">
		<div class="text">3/5</div>
		<svg>
			<circle class="bg" cx="57" cy="57" r="52" />
			<circle class="meter-1" cx="57" cy="57" r="52" />
		</svg>
  	</div>';
}

function sales_widget() {
	echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
	echo '<div id="curve_chart" style="width: 100%; height: 500px"></div>';
}

function categories_widget() {
	echo '<div id="pie_chart" style="width: 100%; height: 500px"></div>';
}

function last_order_widget() {
	echo '<div id="curve_chart" style="width: 900px; height: 500px"></div>';
}

function my_tasks_widget() {
	echo '<div class="tasks list-button">
		<a href="#" class="item">
			<span>Répondre au dernier message de Patricia Bacqueville</span>
		</a>
		<a href="#" class="item">
			<span>La cliente Martine Chevreau a acheté 3 nouveaux articles. Proposer un look</span>
		</a>
		<a href="#" class="item">
			<span>Traiter la demande de retouche de Mme</span>
		</a>
	</div>
	<a href="#" class="see-messages">Voir tous les messages</a>';
}

function custom_menu() {

	global $current_user;
	if (!in_array('administrator', $current_user->roles)) {
		remove_submenu_page( 'index.php', 'update-core.php');
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'users.php' );
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'wpcf7' );
		remove_menu_page( 'edit.php?post_type=page' );
		remove_menu_page( 'edit.php?post_type=store' );
		remove_menu_page( 'themes.php' );
	}

}
add_action('admin_head', 'custom_menu');


/**
 * Adds conditional body classes.
 *
 * @param array $classes Classes added to the body tag.
 * @return array Classes added to the body tag.
 */
function maudern_body_classes( $classes ) {
	global $post;
	$post_type = isset( $post ) ? $post->post_type : false;

	// Check whether we're singular.
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	// Slim page template class names (class = name - file suffix).
	if ( is_page_template() ) {
		$classes[] = basename( get_page_template_slug(), '.php' );
	}

	// Check whether we're in the customizer preview.
	if ( is_customize_preview() ) {
		$classes[] = 'customizer-preview';
	}

	return $classes;
}
add_filter( 'body_class', 'maudern_body_classes' );

/**
 * Search - set post types to be retrieved.
 *
 * @param object $query Search query.
 */
function maudern_search_filter( $query ) {
	if ( $query->is_search ) {
		if ( ! isset( $query->query_vars['post_type'] ) ) {
			$query->set( 'post_type', array( 'post', 'page' ) );
		}
	}
	return $query;
}
add_filter( 'pre_get_posts', 'maudern_search_filter' );



/**
 * Menu dropdown arrows.
 *
 * @param string $output The output.
 * @param object $item Menu item.
 * @param object $depth Menu item depth.
 * @param object $args Menu args.
 */
function maudern_add_menu_dropdown_arrow( $output, $item, $depth, $args ) {
	$menus = array( 'primary', 'secondary' );

	// Only add class to 'top level' items on the 'primary' menu.
	if ( in_array( $args->theme_location, $menus, true ) && in_array( 'menu-item-has-children', $item->classes, true ) && ( 0 === $depth ) ) {
		$output .= '<span class="sub-menu-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 24 24"><path d="M 2.65625 6.25 L 1.34375 7.75 L 11.34375 16.75 L 12 17.34375 L 12.65625 16.75 L 22.65625 7.75 L 21.34375 6.25 L 12 14.65625 Z "></path></svg></span>';
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'maudern_add_menu_dropdown_arrow', 10, 4 );

/**
 * Returns true if WooCommerce is installed and active.
 */
function maudern_is_wc_active() {

	return class_exists( 'WooCommerce' );
}

/**
* Redirect users to custom URL based on their role after login
*
* @param string $redirect
* @param object $user
* @return string
*/
function wc_custom_user_redirect( $redirect, $user ) {
	// Get the first of all the roles assigned to the user
	$role = $user->roles[0];
	$dashboard_url = get_site_url().'/wp-admin/';

	$myaccount = get_permalink(get_option('woocommerce_myaccount_page_id') );
	if( $role == 'administrator' ) {
	  //Redirect administrators to the dashboard
	  $redirect = $dashboard_url;
	} elseif ( $role == 'shop_manager' ) {
	  //Redirect shop managers to the dashboard
	  $redirect = $dashboard_url;
	} elseif ( $role == 'editor' ) {
	  //Redirect editors to the dashboard
	  $redirect = $dashboard_url;
	} elseif ( $role == 'author' ) {
	  //Redirect authors to the dashboard
	  $redirect = $dashboard_url;
	} elseif ( $role == 'customer' || $role == 'subscriber' ) {
	  //Redirect customers and subscribers to the "My Account" page
	  $redirect = $myaccount.'profil';
	} else {
	  //Redirect any other role to the previous visited page or, if not available, to the home
	  $redirect = wp_get_referer() ? wp_get_referer() : home_url();
	}
	return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 ); 

 
function text_domain_logout_link() {
    global $menu;
    $menu[9999] = array('<span class="icon dashicons dashicons-exit"></span>'.__('Se déconnecter'), 'manage_options', wp_logout_url());
    $menu[9999] = array('<span class="icon dashicons dashicons-exit"></span>'.__('Se déconnecter'), 'manage_woocommerce', wp_logout_url());
}
add_action('admin_init', 'text_domain_logout_link');

add_action('init', 'custom_register_post_type');
function custom_register_post_type() {
    $args = array(
        'taxonomies' => array('category'),
    );
    register_post_type( 'look', $args );
}



add_action('admin_footer', 'custom_admin_header');
function custom_admin_header() {
	echo '<div id="toggle-admin-menu">
		<i class="fas fa-bars"></i>
	</div>';
}

function shapeSpace_enable_admin_query_params($removable_url_params) {
	unset($removable_url_params);
	$removable_url_params = array();
	return $removable_url_params;
}
add_filter('removable_query_args', 'shapeSpace_enable_admin_query_params');

function shortcode_youtube($attributes){
	extract(shortcode_atts(
        array(
		 'id' => 'Li1YqgW2Vlw',
		 'start' => '0',
		 'end' => '20'
		), $attributes)
	);
    return '<div id="youtubeEmbed" class="youtube" data-video-id="'.$id.'" data-loop-start="'.$start.'" data-loop-end="'.$end.'"></div>';
}
add_shortcode('youtube', 'shortcode_youtube');



function shortcode_nav($attributes){
	extract(shortcode_atts(
        array(
		 'page' => '',
		), $attributes)
	);
    return get_template_part('/template-parts/nav/'.$page);
}
add_shortcode('nav', 'shortcode_nav');

function shortcode_gmap($attributes) {
	extract(shortcode_atts(
        array(
		 'id' => 'map',
		 'height' => 500
		), $attributes)
	);
    return '<div class="map-container"><input id="searchTextField" class="form-control" type="text"><div id="'.$id.'" style="height: '.$height.'px" class="google-map"></div></div>';
}
add_shortcode('gmap', 'shortcode_gmap');

function shortcode_stores($attributes) {
	extract(shortcode_atts(
        array(
		), $attributes)
	);
	return '<div id="stores-cont"></div>';
}
add_shortcode('stores', 'shortcode_stores');

function shortcode_stores_top($attributes) {
	extract(shortcode_atts(
        array(
		), $attributes)
	);

	$args = array(
        'post_type' => 'store', 
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);
	$posts = $query->posts;

	$html = '<div class="stores top">';
	for($i = 0; $i < 4; $i++) {
		$store = $posts[$i];
		$html .= '<div class="store">
			<div class="title">'.$store->post_title.'</div>
			<div class="address">
				'.get_field('address', $store->ID).'<br>
				'.get_field('postal_code', $store->ID).' '.get_field('city', $store->ID).'
			</div>
			<div class="country">'.get_field('country', $store->ID).'</div>
			<div class="phone">'.get_field('phone', $store->ID).'</div>
			<div class="email">'.get_field('email', $store->ID).'</div>
			<div class="url">'.get_field('site_url', $store->ID).'</div>
			<br>
			<div class="opening-hours">'.get_field('opening_hours', $store->ID).'</div>
		</div>';
	}
	$html .= '</div>';

	return $html;
}
add_shortcode('stores-top', 'shortcode_stores_top');

function shortcode_looks($attributes) {
	extract(shortcode_atts(
        array(
			'attribute' => '',
			'value' => '',
			'limit' => 'none',
			'size' => 'medium',
			'category' => 'look'
		), $attributes)
	);

	$args = array(
        'post_type' => 'product', 
        'posts_per_page' => -1, 
		'product_cat' => $category
    );
    $query = new WP_Query($args);
	$posts = $query->posts;

	$looks = [];

	
	for ($i = 0; $i < count($posts); $i++) {
		$post = $posts[$i];
		$product = wc_get_product($post->ID);

		if ($limit === 'none' || count($looks) < intval($limit)) {
			if ($attribute !== '' && $value !== '') {
				if ($product->get_attribute($attribute) == $value) {
					array_push($looks, $product);
				}
			} else {
				array_push($looks, $product);
			}
		}
	}

	$classSTR = '';
	if ($size !== 'medium') {
		$classSTR = $size;
	}

	$html = '<div class="look-list" data-logged-in="'.is_user_logged_in().'">';
	foreach($looks as $look) {
		$image_id  = $look->get_image_id();
    	$image_url = wp_get_attachment_image_url($image_id, 'full');
		$html .= '<a class="look '.$classSTR.'" href="'.$look->get_permalink().'" data-id="'.$look->get_id().'">
			<div class="vote clearfix">
				<div class="vote-btn like left"><i class="fa fa-thumbs-up"></i></div>
				<div class="vote-btn dislike right"><i class="fa fa-thumbs-down"></i></div>
			</div>
			<div class="image" style="background-image: url('.$image_url.')"></div>
			<div class="title">'.$look->get_title().'</div>
		</a>';
	}
	$html .= '</div>';
	return $html;
}
add_shortcode('looks', 'shortcode_looks');

function shortcode_keyvisual($attributes) {
	extract(shortcode_atts(
        array(
			'pc' => '/2021/12/privatisation.png',
			'sp' => '/2021/12/privatisation-sp.png'
		), $attributes)
	);

	$html = '<div class="main-keyvisual animate__animated anim__fadeIn">
		<div class="slides">
			<div class="slide slide1">
				<div class="img-wrapper">
					<img class="md" src="'.get_site_url().'/wp-content/uploads'.$pc.'" alt="privatisation">
					<img class="sm" src="'.get_site_url().'/wp-content/uploads'.$sp.'" alt="privatisation">	
					<a class="btn contest md" href="'.MY_ACCOUNT_URL.'dressing/jeux/">
						<div class="inner">
							<i class="fa fa-gift"></i>
							<span>Jeux concours</span>
						</div>
					</a>
				</div>
				<div class="wrapper md">
					<div class="title-cont">
						<div class="title">PRIVATISATION</div>
					</div>
				</div>
			</div>
		</div>
		<div class="controls md">
			<a class="btn register" href="'.MY_ACCOUNT_URL.'profil">CRÉER VOTRE PROFIL</a>
		</div>
	</div>
	<div class="personal-shopper sm">
		<h2 class="">Privatisez avec un personal shopper</h2>
		<a class="btn register" href="'.MY_ACCOUNT_URL.'profil">Créer votre profil</a>
		<a class="btn contest" href="'.MY_ACCOUNT_URL.'dressing/jeux/">Jeux concours</a>
	</div>
	';

	return $html;
}
add_shortcode('keyvisual', 'shortcode_keyvisual');

function shortcode_banner($attributes) {
	extract(shortcode_atts(
        array(
		), $attributes)
	);

	$html = '<div class="main-keyvisual animate__animated anim__fadeIn">
		<div class="slides">
			<div class="slide slide1">
				<div class="img-wrapper">
					<video id="look" autoplay loop muted>
						<source type="video/webm" src="'.get_template_directory_uri().'/assets/videos/SPS.mp4" />
					</video>
				</div>
			</div>
		</div>
		<div class="controls md">
			<a class="btn register" href="'.get_site_url().'/marketplace">ESSAYEZ DES VÊTEMENTS</a>
		</div>
	</div>
	<div class="personal-shopper sm">
		<h2 class="">Privatisez avec un personal shopper</h2>
		<a class="btn register" href="'.MY_ACCOUNT_URL.'profil">Créer votre profil</a>
		<a class="btn contest" href="'.MY_ACCOUNT_URL.'dressing/jeux/">Jeux concours</a>
	</div>
	';

	return $html;
}
add_shortcode('banner', 'shortcode_banner');

function shortcode_editor_demo($attributes){
	extract(shortcode_atts(
        array(
		), $attributes)
	);
	return '<a class="no-bg" href="'.MY_ACCOUNT_URL.'dressing/looks">
		<video id="personal-shopper" autoplay loop muted>
			<source type="video/webm" src="'.get_template_directory_uri().'/assets/videos/demo.webm" />
		</video>
	</a>';
	/*return '<a class="no-bg" href="'.MY_ACCOUNT_URL.'dressing/looks">
		<img class="" src="'.get_template_directory_uri().'/assets/images/look-editor/demo.gif" />
	</a>';*/
}
add_shortcode('editor-demo', 'shortcode_editor_demo');

function shortcode_sns($attributes){
	extract(shortcode_atts(
        array(
		 'facebook' => 'https://www.facebook.com/DIKAenFRANCE/',
		 'instagram' => 'https://www.instagram.com/dikaofficiel/?hl=fr',
		 'twitter' => 'https://twitter.com/officieldika'
		), $attributes)
	);
	return '<div class="sns-links" target="_blank">
		<a class="sns-link" href="'.$facebook.'" target="_blank">
			<img src="'.get_template_directory_uri().'/assets/images/icons/fb.png" alt="Facebook">
		</a>
		<a class="sns-link" href="'.$instagram.'" target="_blank">
			<img src="'.get_template_directory_uri().'/assets/images/icons/insta.png" alt="Instagram">
		</a>
		<a class="sns-link" href="'.$twitter.'" target="_blank">
			<img src="'.get_template_directory_uri().'/assets/images/icons/twitter.png" alt="Twitter">
		</a>
	</div>';
}
add_shortcode('sns', 'shortcode_sns');


function shortcode_booking_categories($attributes) {
	extract(shortcode_atts(
        array(

		), $attributes)
	);
	$booking_url = get_site_url().'/privatisation-2';
	return '<div class="booking-categories">
		<a class="category" href="'.$booking_url.'/#farewell">
			<div class="item">
				<div class="photo" style="background-image: url('.get_template_directory_uri().'/assets/images/privatisation/farewell.jpg)"></div>
				<div class="title">Pot de départ</div>
			</div>
		</a>
		<a class="category" href="'.$booking_url.'/#bachelorette">
			<div class="item">
				<div class="photo" style="background-image: url('.get_template_directory_uri().'/assets/images/privatisation/bachelorette.jpg)"></div>
				<div class="title">Enterrement de vie de jeune fille</div>
			</div>
		</a>
		<a class="category" href="'.$booking_url.'/#birthday">
			<div class="item">
				<div class="photo" style="background-image: url('.get_template_directory_uri().'/assets/images/privatisation/birthday.jpg)"></div>
				<div class="title">Anniversaire</div>
			</div>
		</a>
		<a class="category" href="'.$booking_url.'/#fashion">
			<div class="item">
				<div class="photo" style="background-image: url('.get_template_directory_uri().'/assets/images/privatisation/fashion.jpg)"></div>
				<div class="title">Fashion time</div>
			</div>
		</a>
		<a class="category" href="'.$booking_url.'/#parties">
			<div class="item">
				<div class="photo" style="background-image: url('.get_template_directory_uri().'/assets/images/privatisation/parties.jpg)"></div>
				<div class="title">Fêtes diverses</div>
			</div>
		</a>
	</div>';
}
add_shortcode('booking-categories', 'shortcode_booking_categories');


function shortcode_new_collection($attributes) {
	extract(shortcode_atts(
        array(

		), $attributes)
	);
	return '<figure class="wp-block-image alignfull size-large keyvisual">
		<a class="key-wrapper" href="https://www.dika.com/fr/catalog/243/Pre%20Spring.html" target="_blank">
			<img src="https://worth-dev.epicea.tech/wp-content/uploads/2021/10/Affiche-dika_a3_transparent.png" alt="" class="wp-image-112 animate__animated anim__fadeIn" />
			<a class="look look1" href="./looks/?category=frenchy"><span>FRENCHY</span></a><a class="look look2" href="./looks/?category=business">
				<span>BUSINESS</span>
			</a>
			<a class="look look3" href="./looks/?category=trendy">
				<span>TRENDY</span>
			</a>
			<a class="look look4" href="./looks/?category=chic/">
				<span>CHIC</span>
			</a>
			<a class="look look5" href="./looks/?category=casual">
				<span>CASUAL</span>
			</a>
		</a>
	</figure>';
}
add_shortcode('new-collection', 'shortcode_new_collection');

