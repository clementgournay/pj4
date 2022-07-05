<div class="manage-looks">
    <?php
    define('PAGE', 'draft');
    require_once '../wp-content/plugins/manage-looks/parts/nav.php'; 

    $user = wp_get_current_user();
    $args = array(
        'author' => $user->ID,
        'post_type' => 'product', 
        'posts_per_page' => -1, 
        'product_cat' => 'look'
    );
    $query = new WP_Query($args);

    $posts = $query->posts;
    ?>

    <div class="looks" data-root-url="<?php echo plugin_dir_url(__FILE__); ?>">
        <?php
            for($i = 0; $i < count ($posts); $i++) {
                $post = $posts[$i];
                $product = wc_get_product($post->ID);
            
                if ($product->get_attribute('confirm_status') === 'draft') {
                    $image_id  = $product->get_image_id();
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                    echo '<a class="look" href="./admin.php?page=manage_clients&feature=looks&id='.$post->ID.'" data-id="'.$post->ID.'">
                        <div class="remove">x</div>
                        <div class="image" style="background-image: url('.$image_url.')"></div>
                        <div class="title">'.$product->get_title().'</div>
                        <div class="validation">Demande de validation</div>
                    </a>';
                }
            }
        ?>
    </div>

    <?php get_template_part('template-parts/modals/look-removal'); ?>
    <?php get_template_part('template-parts/modals/look-validation'); ?>
</div>