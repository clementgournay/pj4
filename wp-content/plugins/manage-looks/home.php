<div class="manage-looks">
    <?php
    define('PAGE', 'home');
    require_once '../wp-content/plugins/manage-looks/parts/nav.php'; 

    $args = array(
        'post_type' => 'product', 
        'posts_per_page' => -1, 
        'product_cat' => 'look'
    );
    $query = new WP_Query($args);

    $posts = $query->posts;
    ?>

    <div class="looks">
        <?php
            for($i = 0; $i < count ($posts); $i++) {
                $post = $posts[$i];
                $product = wc_get_product($post->ID);
            
                if ($product->get_attribute('confirm_status') === 'published' || $product->get_attribute('confirm_status') === 'public') {
                    $image_id  = $product->get_image_id();
                    $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                    echo '<a class="look"" href="./admin.php?page=manage_clients&feature=looks&id='.$post->ID.'" data-id="'.$post->ID.'">
                        <div class="remove">x</div>
                        <div class="image" style="background-image: url('.$image_url.')"></div>
                        <div class="title">'.$product->get_title().'</div>
                    </a>';
                }
            }
        ?>
    </div>
</div>