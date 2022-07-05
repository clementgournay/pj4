<?php
require_once 'init.php';
define('PAGE', 'informations-legales');
get_template_part('template-parts/my-account/parts/nav'); 

$page = get_page_by_title('Informations légales'); 
$content = apply_filters('the_content', $page->post_content);
?>

<div class="menu-section">
    <?php echo $content; ?>
</div>