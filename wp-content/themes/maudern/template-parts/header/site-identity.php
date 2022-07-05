<?php
/**
 * The template for diplaying the site identity (logo)
 *
 * @package maudern
 * @version Maudern 1.0
 */

?>

<div id="site-identity-wrapper" class="padding-r padding-l text-center">
	<?php
	// Site title or logo.
	maudern_site_logo();
	
	// Site description.
	maudern_site_tagline();
	?>
	<form role="search" method="get" class="search woocommerce-product-search" action="<?php echo get_site_url(); ?>">
		<input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="Rechercher par produit ou par marque..." value="" name="s">
		<button type="submit" value="Recherche">Recherche</button>
		<input type="hidden" name="post_type" value="product">
	</form>
</div>
