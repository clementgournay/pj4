<?php 
/* Template name: Marketplace */

get_header();

$brands = [
    'dika' => 'DiKa',
    'zara' => 'Zara',
    'maxmara' => 'Maxmara',
    'sportmax' => 'Sportmax',
    'hermes' => 'Hermès',
    'louis-vuitton' => 'Louis Vuitton',
    'morgan' => 'Morgan'
];
?>

<article class="page type-page status-publish hentry">
    <div class="entry-header">
        <h1>Choisissez une marque</h1>
    </div>
    <div class="brands">
        <a class="brand" href="<?php echo site_url('/marketplace/assistant/'); ?>"><span>TOUTES</span></a> 
        <?php
            foreach ($brands as $id=>$label) {
                echo '<a class="brand" title="'.$label.'" href="'.esc_url(add_query_arg( 'shop', $id, site_url('/marketplace/assistant/'))).'">
                    <img src="'.get_template_directory_uri().'/assets/images/logos/'.$id.'.png" alt="'.$label.'"/>
                </a>';
            }
        ?>
    </div>
</div>



<?php get_footer(); ?>

