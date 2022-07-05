<?php 


if (!isset($_GET['id'])) header('Location: ./admin.php?page=manage_receipts');
define('ID', $_GET['id']);

$order = wc_get_order(ID);
if (!$order) header('Location: ./admin.php?page=manage_receipts');
$customer_id = $order->get_customer_id();
$dt = new DateTime($order->get_date_paid());

$cat = get_term_by('slug', 'clothes', 'product_cat');
$terms = get_terms('product_cat', array('child_of' => $cat->term_id, 'hide_empty' => false));

$cat_slugs = ['coat', 'vest', 'dress', 'skirt', 'top_tshirt', 'shirt', 'pants', 'short', 'jumpsuit', 'accessory'];
$cat_labels = [];

foreach($terms as $category) { 
    $cat_labels[$category->slug] = $category->name;
}
define('CATEGORIES', $cat_slugs);
define('CATEGORY_LABEL', $cat_labels);
define('BRANDS', ['dika', 'hermes', 'louis-vuitton']);
define('BRAND_LABEL', [
    'dika' => 'DiKa',
    'hermes' => 'Hermès',
    'louis-vuitton' => 'Louis Vuitton'
]);

?>
<div class="manage-receipts view-receipt" data-plugin-url="<?php echo plugin_dir_url(__FILE__); ?>">
    <h1>Ticket #<?php echo $order->get_meta('receipt_no'); ?></h1>
    <p class="total <?php echo ($order->get_total() < 0) ? 'red ' : 'green'; ?>">Montant: <?php echo $order->get_total(); ?>€</p>
    <p class="date"><?php echo $dt->format('d/m/Y H:i:s'); ?></p> 
    <div class="client">
        <?php if ($customer_id): ?>
            <?php $customer  = get_userdata($customer_id); ?>
            <p class="red" style="display: none">Non attribué</p>
            <p class="name"><?php echo get_user_meta($customer_id, 'firstname').' '.get_user_meta($customer_id, 'lastname'); ?></p>
            <p class="display-name">(<?php echo $customer->data->user_login; ?>)</p>
        <?php endif; ?>
        <?php if (!$customer_id): ?>
            <p class="red">Non attribué</p>
            <p class="name"></p>
            <p class="display-name"></p>
        <?php endif; ?>
    </div>


    <input type="hidden" name="order_id" value="<?php echo $order->get_id(); ?>">

    <div class="menu-section achats">

        <div class="table filters">

            <?php if (get_option('brand_filtering') == true): ?>
            <div class="tr brands">
                <div class="td label">
                    <span>Par marque:</span>
                </div>
                <div class="td filter-cont filter-brand clearfix">
                    <div class="category-btn all active">
                        <div>TOUT</div>
                        <span class="count">(0)</span>
                    </div>
                    <?php 
                        foreach(BRANDS as $brand) {
                            echo '<div class="category-btn" title="'.BRAND_LABEL[$brand].'" data-brand="'.$brand.'">
                            <img src="'.get_template_directory_uri().'/assets/images/logos/'.$brand.'.png">
                                <span class="cat-count"></span>
                            </div>';
                        }
                    ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="tr categories">
                <div class="td label">
                    <span>Par catégorie:</span>
                </div>
                <div class="td filter-cont filter-cat clearfix">
                    <div class="category-btn all active">
                        <div>TOUT</div>
                        <span class="count">(0)</span>
                    </div>
                    <?php 
                        foreach(CATEGORIES as $category) {
                            echo '<div class="category-btn" title="'.CATEGORY_LABEL[$category].'" data-category="'.$category.'">
                                <span class="icon '.$category.'"></span>
                                <span class="cat-count"></span>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="outer">
            <div class="results table">
                <div class="tr head">
                    <div class="td col-ref">Référence</div>
                    <div class="td tac">Description</div>
                    <div class="td tac">Catégorie</div>
                    <div class="td tac">Vendeur</div>
                    <div class="td tac">Couleur</div>
                    <div class="td tac">Taille</div>
                    <div class="td tac">Marque</div>
                    <div class="td tac">Provenance</div>
                    <div class="td col-comp">Composition</div>
                    <div class="td tac">Prix d'origine</div>
                    <div class="td tac">Remise</div>
                    <div class="td tac">Montant payé</div>
                    <div class="td image-col tac">Photo</div>
                </div>
                <?php

                    foreach($order->get_items() as $item) {

                        $statesSTR = array(
                            'new' => 'Neuf',
                            'used' => 'Usé'
                        );
    
                        $statusesSTR = array(
                            'instock' => 'En stock',
                            'outofstock' => 'Rupture de stock',
                            'supplying' => 'En cours d\'approvisionnement'
                        );

                        $colorSTR = array(
                            900 => 'Rouge et noir',
                            906 => 'Multicolore',
                            908 => 'Rouge, noir et blanc',
                            909 => 'Marron et gris',
                            910 => 'Noir et jaune',
                            912 => 'Noir et jaune',
                            400 => 'Bleu marine',
                            602 => 'Rouge et noir',
                            627 => 'Léopard',
                            800 => 'Gris',
                            304 => 'Jaune',
                            303 => 'Jaune',
                            251 => 'Blanc et noir'
                        );
                        
                        $productID = $item['product_id'];
                        $product = wc_get_product($productID);

                        $terms = get_the_terms($productID, 'product_cat');
                        $category = (count($terms) > 0) ? $terms[0]->slug : 'unknown';

                        $color = isset($colorSTR[$product->get_attribute('color')]) ? $colorSTR[$product->get_attribute('color')] : 'Inconnue';
    
                        echo '
                        <div class="row item tr" data-product-id="'.$productID.'" data-category="'.$product->get_attribute('category').'" data-brand="'.$product->get_attribute('brand').'">
                            <span class="td ref">'.$product->get_attribute('reference').'</span>
                            <span class="td tac title">'.$product->get_title().'</span>
                            <div class="td tac category">
                                <span class="icon '.$category.'"></span>
                            </div>
                            <span class="td tac seller">'.$order->get_meta('seller').'</span>
                            <span class="td tac color">'.$color.'</span>
                            <span class="td tac size">'.$item->get_meta('size').'</span>
                            <span class="td tac brand">'.(($product->get_attribute('brand')) ? '<img src="'.get_template_directory_uri().'/assets/images/logos/'.$product->get_attribute('brand').'.png">' : '').'</span>
                            <div class="td prov tac">Serbia</div>
                            <div class="td comment">
                                <textarea readonly>'.$product->get_attribute('composition').'</textarea>
                            </div>

                            <span class="td tac org-price tac bold">'.$product->get_price().'€</span>
                            <span class="td tac discount tac bold">'.($product->get_price() - $item->get_total()).'€</span>
                            <span class="td tac price tac bold">'.$item->get_total().'€</span>
                            <div class="td tac image">
                                '.$product->get_image().'
                            </div>
                        </div>';

                    }

                        
                ?>
            </div>

            
        </div>

    </div>

    <div class="controls">
        <button type="button" class="btn attribute">Attribuer à un client</button>
        <button type="button" class="btn disattribute" style="<?php echo ($customer_id) ? 'display: inline-block' : 'display: none'; ?>">Désattribuer le ticket</button>
    </div>

    <a class="go-back" href="./admin.php?page=manage_receipts">Retour à la liste des tickets</a>
    
    <?php get_template_part('template-parts/modals/client-selection'); ?>
    
</div>