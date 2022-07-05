<?php 

if (!isset($_GET['user_id'])) header('Location: ./admin.php?page=manage_clients');

$userID = $_GET['user_id'];
define('USER_ID', $userID);
$user = get_user_by('id', $userID);

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
$query->set('customer', $user->ID);
$orders = $query->get_orders();

require_once 'includes/upload-photo.php';

?>
<h1 class="cva">CVA</h1>
<div class="manage-clients dressing">
    <h1>Dressing de <?php echo get_user_meta($user->ID, 'firstname', true) ?> <?php echo get_user_meta($user->ID, 'lastname', true) ?></h1>
    <p class="subtitle">(<?php echo $user->user_login; ?>)</p>

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
                    <div class="td">Numéro ticket</div>
                    <div class="td tac ref-col">Référence produit</div>
                    <div class="td tac">Catégorie</div>
                    <div class="td tac">Description</div>
                    <div class="td tac">Date</div>
                    <div class="td tac">Vendeur</div>
                    <div class="td tac">Couleur</div>
                    <div class="td tac">Taille</div>
                    <div class="td tac">Marque</div>
                    <div class="td tac">Etat</div>
                    <div class="td tac">Disponibilité</div>
                    <div class="td tac">Prix produit</div>
                    <div class="td tac">Montant payé</div>
                    <div class="td image-col tac">Photo</div>
                </div>
                <?php
                    foreach($orders as $order) {

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
                                251 => 'Blanc et noir'
                            );

                            
                            $dt = new DateTime($order->date_paid);
                            $productID = $item['product_id'];
                            $product = wc_get_product($productID);

                            $image_id  = $product->get_image_id();
                            $image_url = wp_get_attachment_image_url($image_id, 'full');

                            $terms = get_the_terms($productID, 'product_cat');
                            $category = (count($terms) > 0) ? $terms[0]->slug : 'unknown';
        
                            echo '
                            <div class="row item tr" data-product-id="'.$productID.'" data-category="'.$product->get_attribute('category').'" data-brand="'.$product->get_attribute('brand').'">
                                <span class="td no">'.$order->get_meta('receipt_no').'</span>
                                <span class="td tac ref">
                                    <a href="'.get_admin_url().'post.php?post='.$productID.'&action=edit" target="_blank">'.$product->get_attribute('reference').'</a>
                                </span>
                                <div class="td tac category">
                                    <span class="icon '.$category.'"></span>
                                </div>
                                <span class="td tac description">'.$product->get_name().'</span>
                                <span class="td tac date">'.$dt->format('d/m/Y H:i').'</span>
                                <span class="td tac seller">'.$order->get_meta('seller').'</span>
                                <span class="td tac color">'.$colorSTR[$product->get_attribute('color')].'</span>
                                <span class="td tac size">'.$item->get_meta('size').'</span>
                                <span class="td tac brand">'.(($product->get_attribute('brand')) ? '<img src="'.get_template_directory_uri().'/assets/images/logos/'.$product->get_attribute('brand').'.png">' : '').'</span>
                                <span class="td tac state">'.$statesSTR[$product->get_attribute('state')].'</span>
                                <span class="td tac status">'.$statusesSTR[$product->get_stock_status()].'</span>
                                <span class="td tac org-price tac bold">'.$product->get_price().'€</span>
                                <span class="td tac price tac bold">'.$item->get_total().'€</span>';

                                if (has_post_thumbnail($productID)) {
                                    echo '<div class="td tac image">
                                        '.$product->get_image().'
                                    </div>';
                                } else {
                                    echo '<div class="td tac image">
                                        <form method="POST" action="./admin.php?page=manage_clients&feature=dressing&user_id='.$userID.'" enctype="multipart/form-data">
                                            <input type="file" name="photo">
                                            <input type="hidden" name="product_id" value="'.$productID.'">
                                            <button type="submit" class="btn" name="send_photo">Ajouter la photo</button>
                                        </form>
                                    </div>';
                                }
                            echo '</div>';

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

    </div>

    
</div>

<?php require_once 'parts/client-actions.php'; ?>