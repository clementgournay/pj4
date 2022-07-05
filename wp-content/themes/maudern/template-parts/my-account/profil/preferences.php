<?php
require_once 'init.php';
define('PAGE', 'preferences');
get_template_part('template-parts/my-account/parts/nav'); 
$keywords = ['noir', 'blanc', 'vert', 'jaune', 'bleu', 'violet', 'rose', 'orange', 'beige', 'robes', 'jupes', 'manteaux', 'débardeur', 'chaussures', 'talons', 'sneakers'];
?>

<div class="menu-section preferences">
    <div class="banner clothes"></div>

    <p>Choisissez les tags qui correspondent à vos goûts et préférences vestimentaires:</p>

    <div class="input">
        <input type="text" id="filter" placeholder="Recherche de tags">
    </div>
    <div class="tags selection-tags clearfix">
        <?php 
            foreach($keywords as $keyword) {
                echo '<div class="tag">#'.$keyword.'</div>';
            }

        ?>
    </div>

    <p>Tags sélectionnés:</p>
    <div class="tags selected-tags clearfix"></div>

    <button type="submit" class="woocommerce-Button button" name="save_account_details" value="Enregistrer les modifications">Enregistrer les modifications</button>
</div>
