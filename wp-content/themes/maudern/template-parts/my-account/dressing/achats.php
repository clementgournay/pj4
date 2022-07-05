<?php
require_once 'init.php';
define('PAGE', 'achats');
get_template_part('template-parts/my-account/parts/nav'); 

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

$query = new WC_Order_Query();
$query->set('customer', wp_get_current_user()->ID);
$orders = $query->get_orders();

?>

<div class="menu-section achats" data-root-url="<?php echo get_site_url(); ?>">

    <div class="table filters clearfix">

        <?php if (get_option('brand_filtering') == true): ?>
        <div class="tr brands">
            <div class="td label">
                <span>Par marque:</span>
            </div>
            <div class="td clearfix">
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
            <div class="td clearfix">
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

    <div class="outer">
        <div class="results receipt table">
            <div class="tr head">
                <div class="td no">Numéro</div>
                <div class="td title">Description</div>
                <div class="td tac category">Catégorie</div>
                <div class="td tac date">Date</div>
                <div class="td tac seller">Vendeur</div>
                <div class="td tac ref">Ref</div>
                <div class="td tac color">Couleur</div>
                <div class="td tac size">Taille</div>
                <div class="td tac brand">Marque</div>
                <div class="td tac org-price">Prix d'origine</div>
                <div class="td tac price">Prix remisé</div>
                <div class="td image-col tac">Photo</div>
                <div class="td advices">Conseils d'utilisation</div>
            </div>
            <?php
                foreach($orders as $order) {

                    if ($order->get_meta('user_specific') !== '1') {
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
                                303 => 'Ochre',
                                251 => 'Blanc et noir'
                            );

                            
                            $dt = new DateTime($order->date_paid);
                            $productID = $item['product_id'];
                            $product = wc_get_product($productID);

                            $terms = get_the_terms($productID, 'product_cat');
                            $category = (count($terms) > 0) ? $terms[0]->slug : 'unknown';

                            echo '
                            <div class="row tr" data-product-id="'.$productID.'" data-category="'.$product->get_attribute('category').'" data-brand="'.$product->get_attribute('brand').'" data-product-url="'.$product->get_permalink().'">
                                <div class="td no">'.$order->get_meta('receipt_no').'</div>
                                <div class="td title">'.$product->get_title().'</div>
                                <div class="td tac category">
                                    <span class="icon '.$category.'"></span>
                                </div>
                                <div class="td tac date">'.$dt->format('d/m/Y').'</div>
                                <div class="td tac seller">'.$order->get_meta('seller').'</div>
                                <div class="td tac ref">'.$product->get_attribute('reference').'</div>
                                <div class="td tac color">'.$colorSTR[$product->get_attribute('color')].'</div>
                                <div class="td tac size">'.$item->get_meta('size').'</div>';
                                if ($product->get_attribute('brand') === 'dika') {
                                    echo '<div class="td tac brand">'.(($product->get_attribute('brand')) ? '<img src="'.get_template_directory_uri().'/assets/images/logos/'.$product->get_attribute('brand').'.png">' : '').'</div>';
                                } else {
                                    echo '<div class="td tac brand"></div>';
                                }
                                echo '<div class="td tac org-price tac">'.$product->get_price().'€</div>
                                <div class="td tac price tac bold">'.$item->get_total().'€</div>
                                <div class="td tac image">
                                    '.$product->get_image().'
                                </div>
                                <div class="td comment tac">
                                    <i class="fa fa-tag advices-btn"></i>
                                    <input type="hidden" name="composition" value="'.$product->get_attribute('composition').'">
                                </div>
                            </div>';

                        }

                        echo '<div class="row tr total">
                            <div class="td">'.$order->get_meta('receipt_no').'</div>
                            <div class="td"></div>
                            <div class="td"></div>
                            <div class="td"></div>
                            <div class="td"></div>
                            <div class="td"></div>
                            <div class="td"></div>
                            <div class="td"></div>
                            <div class="td tac"></div>
                            <div class="td tac">Montant</div>
                            <div class="td tac bold">'.$order->get_total().'€</div>
                            <div class="td"></div>
                            <div class="td"></div>
                        </div>';
                        
                    }
                }
            ?>
        </div>
        <?php if (count($orders) === 0): ?>
        <div class="row tr no-results">
            <div class="text">Aucun achat n'a été effectué actuellement.</div>
        </div>
        <?php endif; ?>
        
    </div>

    <div class="table results actions">
        <div class="tr head">
            <div class="td">Actions</div>
        </div>
        <?php 
            foreach($orders as $order) {
                if ($order->get_meta('user_specific') !== '1') {
                    foreach($order->get_items() as $item) {
                        $productID = $item['product_id'];
                        $product = wc_get_product($productID);
                        ?>
                        <div class="row tr" data-product-id="<?php echo $productID; ?>" data-category="<?php echo $product->get_attribute('category'); ?>" data-brand="<?php echo $product->get_attribute('brand'); ?>" data-product-url="<?php echo $product->get_permalink(); ?>">
                            <div class="td">
                                <div class="context">
                                    <button type="button" class="btn more open">...</button>
                                    <div class="menu">
                                        <ul>
                                            <li class="reclamation-btn">Faire une réclamation</li>
                                            <li class="sell-btn">Vendre</li>
                                            <li class="share-btn">Recommander à un ami</li>
                                            <li class="related-btn">Articles associés</li>
                                            <li class="remove">Retirer le produit du dressing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '<div class="row tr total">
                        <div class="td">&nbsp;</div>
                    </div>';
                }
            }
        ?>
    </div>


</div>

<?php get_template_part('template-parts/modals/advices'); ?>
<?php get_template_part('template-parts/modals/reclamation'); ?>
<?php get_template_part('template-parts/modals/share-clothes'); ?>