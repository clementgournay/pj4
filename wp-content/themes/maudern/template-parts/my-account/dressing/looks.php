<?php



require_once 'init.php';
define('PAGE', 'looks');

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

$user = wp_get_current_user();

/*
update_user_meta($user->ID, 'suggested_looks', []);
update_user_meta($user->ID, 'messages', []);
update_user_meta($user->ID, 'favorites', []);
*/
?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v12.0" nonce="Eh3RPvqn"></script>

<div class="look-editor client has-premium" id="look-editor" data-share-url="<?php echo get_site_url(); ?>/share-look/">

    <?php

    global $current_user;
    $user = $current_user;
    $userID = $user->ID;
    $query = new WC_Order_Query();
    $query->set('customer', $user->user_email);
    $orders = $query->get_orders();

    $orders = wc_get_orders([
        'customer_id' => $userID,
        'limit' => -1
    ]);

    $suggested_looks = get_user_meta($userID, 'suggested_looks', true);

    $norm_orders = [];
    $spec_orders = [];
    foreach($orders as $order) {

        if ($order->get_meta('user_specific') === '1') {
            array_push($spec_orders, $order);
        } else {
            array_push($norm_orders, $order);
        }
    }

    $date = new DateTime();

    if (!isset($_COOKIE['token'])) {
        $request = new WP_REST_Request('POST', '/jwt-auth/v1/token');
        $request->set_header('content-type', 'application/json');
        $request->set_body(json_encode(
            [
                'username' => 'seller',
                'password' => 'testTest12$',
            ]
        ));
        $response = rest_do_request($request);
        $server = rest_get_server();
        $data = $server->response_to_data($response, false);
        setcookie('token', $data['token'], time() + (6 * 60 * 60 * 1000), '/');
    }

?>

    <h1>Suggestion de looks</h1>

    <input type="hidden" name="token" value="<?php echo $_COOKIE['token']; ?>">
    <input type="hidden" name="selected_look" value="<?php echo (isset($_GET['look'])) ? $_GET['look'] : 'none'; ?>">


    <div class="editor">
        <div class="user-products sp-active">
        <h2 class="main-title">
                <span>Mon dressing DiKa (<span class="count">0</span>)</span>
                <div class="toggle-filter" data-filter="category">
                    <i class="fas fa-filter"></i>
                </div>
            </h2>
            <div class="outer filter-window" data-filter="category">
                <div class="tabs clearfix">
                    <div class="tab active" data-category="all">TOUT</div>
                    <?php 
                        foreach(CATEGORIES as $category) {
                            echo '<div class="tab" title="'.CATEGORY_LABEL[$category].'" data-category="'.$category.'">
                                <span class="icon '.$category.'"></span>
                                <span class="cat-count"></span>
                            </div>';
                        }
                    ?>
                </div>
            </div>

            <div class="result items sp-active">
                <?php 
                    foreach($norm_orders as $order) {
                        foreach($order->get_items() as $item) {
                            $product = wc_get_product($item->get_product_id());
                            $image_id  = $product->get_image_id();
                            $image_url = wp_get_attachment_image_url($image_id, 'full');
                            $pos_calculated = $product->get_attribute('pos_calculated');
                            $is_ready = ($pos_calculated !== '');
                            $ready_str = '';

                            echo '<div class="item '.$ready_str.'" data-id="'.$product->get_id().'" data-ref="'.$product->get_attribute('reference').'" data-ready="'.$product->get_attribute('ready').'" data-price="'.$product->get_price().'" data-sale-price="'.$product->get_attribute('sale_price').'" data-category="'.$product->get_attribute('category').'" data-org-category="'.$product->get_attribute('org_category').'" data-image="'.$image_url.'">';
                                echo "<div class=\"image\" style=\"background-image: url('".$image_url."')\"></div>
                                <div class=\"name\">
                                    <span>".$item->get_name()."</span>
                                </div>";
                            echo '</div>';
                        }
                    }
                ?>
            </div>

            <div class="option must-have">
                <h2>Les incontournables chez DiKa</h2>
                <div class="result">
                    <div class="items">
                        <div class="item dress-black" data-category="dress-black">
                            <span class="icon dress"></span>
                            <span class="title">Robe noire</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item trench dont-have" data-category="tshirt">
                            <span class="icon top_tshirt"></span>
                            <span class="title">Tshirt uni</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item trench dont-have" data-category="trench">
                            <span class="icon coat"></span>
                            <span class="title">Trench coat</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item vest-denim" data-category="vest-denim">
                            <span class="icon vest"></span>
                            <span class="title">Veste jean</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item silk-shirt" data-category="silk-shirt">
                            <span class="icon shirt"></span>
                            <span class="title">Chemisier en soie</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item caban" data-category="caban">
                            <span class="icon shirt"></span>
                            <span class="title">Caban bleu marine</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item high-heel" data-category="high-heel">
                            <span class="icon accessory"></span>
                            <span class="title">Escarpins</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item vest-leather" data-category="vest-leather">
                            <span class="icon vest"></span>
                            <span class="title">Veste en cuir</span>
                        </div>
                        <div class="item jean-pants" data-category="jean-pants">
                            <span class="icon pants"></span>
                            <span class="title">Jean brut</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item skirt-trapeze" data-category="skirt-trapeze">
                            <span class="icon skirt"></span>
                            <span class="title">Jupe trapèze</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item other" data-category="vest-black">
                            <span class="icon vest"></span>
                            <span class="title">Veste noir</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="option trends">
                <h2>Tendances</h2>
                <div class="result">
                    <div class="items">
                        <div class="item total-white" data-category="total-white">
                            <div class="image" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/trends/total-white.jpg)"></div>
                            <span class="title">Total look blanc</span>
                        </div>
                        <div class="item color-sping22" data-category="color-sping22">
                            <div class="image" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/trends/color-spring22.jpg)"></div>
                            <span class="title">Couleurs Printemps-Ete 2022</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="model-cont">
            <div class="filter-selection size">
                <div class="filter-btn selected" data-filter="36">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/36-thumb.jpg)"></div>
                    <div class="name">36</div>
                </div>
                <div class="filter-btn" data-filter="38">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/38-thumb.jpg)"></div>
                    <div class="name">38</div>
                </div>
                <div class="filter-btn" data-filter="42">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/42-thumb.jpg)"></div>
                    <div class="name">42</div>
                </div>
            </div>
            <div class="filter-selection hair">
                <div class="filter-btn selected" data-filter="36">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/36-thumb.jpg)"></div>
                    <div class="name">Attachés</div>
                </div>
                <div class="filter-btn" data-filter="hair-2">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/hair-2-thumb.jpg)"></div>
                    <div class="name">Longs</div>
                </div>
                <div class="filter-btn" data-filter="hair-3">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/hair-3-thumb.jpg)"></div>
                    <div class="name">Courts</div>
                </div>
            </div>
            <div class="model-outer">
                <div class="window cloth-replace">
                    <h2>Remplacer vêtement</h2>
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="products">
                        <img class="loading" src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>

                <div class="window coat-vest" data-category="coat, vest">
                    <div class="list"></div>
                    <div class="products">
                        <div class="close"><i class="fas fa-times"></i></div>
                        <img class="loading" src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                    <div class="controls">
                        <div class="toggle"><i class="fas fa-eye"></i></div>
                    </div>
                </div>

                <div class="window accessories" data-category="accessory">
                    <div class="list"></div>
                    <div class="products">
                        <div class="close"><i class="fas fa-times"></i></div>
                        <img class="loading" src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>
                <div class="clothing">
                    <img class="model selected" data-model="36" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/36.png">
                    <img class="model" data-model="38" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/38.png">
                    <img class="model" data-model="42" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/42.png">
                    <img class="model" data-model="kardashian" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/kardashian.png">
                    <img class="model" data-model="rihanna" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/rihanna.png">
                    <img class="model" data-model="beyonce" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/beyonce.png">
                </div>
                <button type="button" class="btn action-btn book"><i class="fas fa-shopping-cart"></i> Réserver en boutique</button>

                <div class="zoom">
                    <i class="fas fa-search-minus"></i>
                </div>
                <div class="vote">
                    <div class="like"><i class="fas fa-thumbs-up"></i></div>
                    <div class="dislike"><i class="fas fa-thumbs-down"></i></div>
                </div>

                <div class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/dika.png" />
                </div>
            </div>
            <div class="filter-selection face">
                <div class="filter-btn selected" data-filter="normal">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/filters/normal.jpg)"></div>
                    <div class="name">Normal</div>
                </div>
                <div class="filter-btn" data-filter="kardashian">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/filters/kardashian.jpg)"></div>
                    <div class="name">Kim Kardashian</div>
                </div>
                <div class="filter-btn" data-filter="rihanna">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/filters/rihanna.jpg)"></div>
                    <div class="name">Rihanna</div>
                </div>
                <div class="filter-btn" data-filter="beyonce">
                    <div class="photo" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/filters/beyonce.jpg)"></div>
                    <div class="name">Beyoncé</div>
                </div>
            </div>
            <div class="filter-selection scenes">
                <div class="filter-btn selected" data-scene="dressing">
                    <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/dressing.jpg)"></div>
                    <div class="name">Dressing</div>
                </div>
                <div class="filter-btn" data-scene="office">
                    <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/office.jpg)"></div>
                    <div class="name">Bureaux</div>
                </div>
                <div class="filter-btn" data-scene="city">
                    <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/city.jpg)"></div>
                    <div class="name">Ville</div>
                </div>
                <div class="filter-btn" data-scene="nature">
                    <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/nature.jpg)"></div>
                    <div class="name">Nature</div>
                </div>
                <div class="filter-btn" data-scene="beach">
                    <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/beach.jpg)"></div>
                    <div class="name">Plage</div>
                </div>
                <div class="filter-btn" data-scene="party">
                    <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/party.jpg)"></div>
                    <div class="name">Party</div>
                </div>
            </div>
        </div>
        <div class="related-looks loading">
            <h2 class="main-title">
                <span>Suggestions de looks (<span class="count">0</span>)</span>
                <div class="toggle-filter" data-filter="category">
                    <i class="fas fa-filter"></i>
                </div>
            </h2>

            <div class="tabs">
                <div class="tab active" title="Looks proposés" data-category="proposed">
                    <span><i class="fas fa-tshirt"></i> Looks proposés</span>
                    <span class="cat-count"></span>
                </div>
                <div class="tab" title="Favoris" data-category="favorites">
                    <span><i class="fas fa-heart"></i> Favoris</span>
                    <span class="cat-count"></span>
                </div>
            </div>
            <div class="items">
                <div class="tags filter-window" data-filter="tags">
                    <div class="tag">#vintage</div>
                    <div class="tag">#chic</div>
                    <div class="tag">#casual</div>
                    <div class="tag">#classique</div>
                    <div class="tag">#audacieux</div>
                    <div class="tag">#business</div>
                </div>
                <div class="looks proposed active" data-category="proposed">
                </div>
                <div class="looks favorites" data-category="favorites">
                    <img class="loading" src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
                    <span class="no-result">Aucun favoris pour l'instant.</span>
                </div>
                <div id="replace-cloth">
                    <div class="triangle"></div>
                    <div class="products"></div>
                    <div class="footer">
                        <button type="button" class="btn replace" disabled>Remplacer le vêtement</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup" data-category="dress-black">
        <h2>La robe noire</h2>
        <p>Impossible de ne pas vous en parler. Popularisée par Coco Chanel en 1926, la robe noire est devenue emblématique. La star des intemporels doit se choisir selon sa silhouette mais toujours dans une belle matière et une jolie texture. Choisissez-là aussi sexy, avec une taille marquée. Glamour et séduisante, elle peut se porter en soirée comme en journée, en hiver comme en été, à 20 ans comme à 50. Bref, LA robe à posséder, sans discussion possible.</p>
        <div class="products">
            <div class="product">
                <div class="image" style="background-image: url(<?php echo get_home_url(); ?>/wp-content/uploads/2022/03/41Й2-405-900-2.jpg"></div>
                <div class="name">ROBE</div>
            </div>
            <div class="product">
                <div class="image" style="background-image: url(<?php echo get_home_url(); ?>/wp-content/uploads/2022/03/41F7-B12-900-3.jpg"></div>
                <div class="name">ROBE</div>
            </div>
            <div class="product">
                <div class="image"></div>
                <div class="name">ROBE</div>
            </div>
            <div class="product">
                <div class="image"></div>
                <div class="name">ROBE</div>
            </div>
        </div>
    </div>

    <div class="popup" data-category="total-white">
        <h2>Total look blanc</h2>
        <p>Des Suffragettes aux Boys Band, le total-look blanc est un incontournable. Ces dernières années, il a su s'imposer dans nos vestiaires autant l'hiver que l'été.</p>
        <div class="products">
            <div class="product">
                <div class="image" style="background-image: url(<?php echo get_home_url(); ?>/wp-content/uploads/2022/03/2262-A51-250-3.jpg"></div>
                <div class="name">PANTALON</div>
            </div>
            <div class="product">
                <div class="image" style="background-image: url(<?php echo get_home_url(); ?>/wp-content/uploads/2022/03/1444-C13-250-2.jpg"></div>
                <div class="name">VESTE</div>
            </div>
            <div class="product">
                <div class="image" style="background-image: url(<?php echo get_home_url(); ?>/wp-content/uploads/2022/03/31D6-C13-250-6.jpg"></div>
                <div class="name">JUPE</div>
            </div>
        </div>
    </div>

</div>
