<?php
/**
 * The template for diplaying the primary menu
 *
 * @package maudern
 * @version Maudern 1.0
 */

?>

<div id="secondary-menu-wrapper" class="flex-1 text-right">

	<div class="links md">
		<a href="<?php echo site_url(); ?>/boutiques">Trouver un magasin</a>
		<a href="<?php echo site_url(); ?>/contact">Contact</a>
	</div>
	<ul id="menu-site-tools" class="secondary-menu no-list-style no-margin no-padding">
		<li id="search-site-tool" class="menu-item">
			<button class="menu-icon"><span class="screen-reader-text"><?php echo esc_html( 'Search Toggle' ); ?></span></button>
			<?php
			// Search Form.
			maudern_search_form();
			?>
		</li>

		<?php if ( maudern_is_wc_active() ) { ?>
			<li id="my-account-site-tool" class="menu-item">
				<a class="menu-icon account-menu-icon" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>profil"></a>
			</li>
		<?php } ?>

		<?php if ( maudern_is_wc_active() ) { ?>
			<li id="shopping-bag-site-tool" class="menu-item">
				<button class="menu-icon bag-menu-icon">
					<span class="screen-reader-text"><?php echo esc_html( 'Minicart Toggle' ); ?></span>
					<span class="bag-product-count"><span><?php echo is_object( WC()->cart ) ? esc_html( WC()->cart->get_cart_contents_count() ) : ''; ?></span></span>
				</button>
			</li>
		<?php } ?>
	</ul>

</div>
