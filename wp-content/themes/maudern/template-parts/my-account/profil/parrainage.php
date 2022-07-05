<?php
require_once 'init.php';
define('PAGE', 'parrainage');
get_template_part('template-parts/my-account/parts/nav'); 
?>

<div class="menu-section">
    <p>Copiez le lien ci-dessous et parrainez un ami et obtenez de nombreux avantages !</p>

    <?php echo do_shortcode('[wp-referral-code var="copy_ref_link"]'); ?>
</div>