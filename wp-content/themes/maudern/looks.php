<?php 
/* Template name: Looks */
get_header();
$cat = (isset($_GET['category']) && $_GET['category'] !== '') ? $_GET['category'] : 'none';
define('CAT', $cat);

?>
<article class="page type-page status-publish hentry">
    <div class="entry-content">
        <div class="wp-block-group alignfull looks-container no-margin-bottom">
            <h1>Nos looks</h1>
            
            <ul class="categories-list flex-3 text-center-md-down no-padding-left no-list-style no-margin margin-b-lg-down clearfix">
                <li class="cat-item <?php echo (CAT === 'none') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/">TOUS</a>
                </li>
                <li class="cat-item <?php echo (CAT === 'frenchy') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/?category=chic">FRENCHY</a>
                </li>
                <li class="cat-item <?php echo (CAT === 'business') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/?category=business">BUSINESS</a>
                </li>
                <li class="cat-item <?php echo (CAT === 'trendy') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/?category=trendy">TRENDY</a>
                </li>
                <li class="cat-item <?php echo (CAT === 'chic') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/?category=chic">CHIC</a>
                </li>
                <li class="cat-item <?php echo (CAT === 'casual') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/?category=casual">CASUAL</a>
                </li>
                <li class="cat-item <?php echo (CAT === 'tiktok') ? 'active' : ''; ?>">
                    <a href="<?php echo get_site_url(); ?>/looks/?category=tiktok">TIKTOK</a>
                </li>
            </ul>
            <?php get_template_part('template-parts/nav/looks.php'); ?>
            <?php 
                if (CAT === 'none') {
                    echo do_shortcode('[looks attribute="confirm_status" value="public"]');
                } else {
                    echo do_shortcode('[looks attribute="confirm_status" value="public" category="'.CAT.'"]');
                }
            ?>
        </div>
    </div>
</article>

<?php get_footer(); ?>