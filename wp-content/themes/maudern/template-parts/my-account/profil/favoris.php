<?php
require_once 'init.php';
define('PAGE', 'favoris');
get_template_part('template-parts/my-account/parts/nav'); 
?>
<div class="menu-section">
    <?php echo do_shortcode('[yith_wcwl_wishlist]'); ?>
</div>