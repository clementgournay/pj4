<?php

if (!isset($_GET['user_id'])) header('Location: ./admin.php?page=manage_clients');

$userID = $_GET['user_id'];
define('USER_ID', $userID);
$user = get_user_by('id', $userID);
$suggested_looks = get_user_meta($userID, 'suggested_looks', true);

$orders = wc_get_orders([
    'customer_id' => $userID,
    'limit' => -1
]);

$norm_orders = [];
$spec_orders = [];

foreach($orders as $order) {
    if ($order->get_meta('user_specific') === '1') {
        array_push($spec_orders, $order);
    } else {
        array_push($norm_orders, $order);
    }
}

$cat = get_term_by('slug', 'clothes', 'product_cat');
$terms = get_terms('product_cat', array('child_of' => $cat->term_id, 'hide_empty' => false));

$cat_slugs = ['coat', 'vest', 'dress', 'skirt', 'top_tshirt', 'shirt', 'pants', 'short', 'jumpsuit', 'accessory'];
$cat_labels = [];

foreach($terms as $category) { 
    $cat_labels[$category->slug] = $category->name;
}

define('CATEGORIES', $cat_slugs);
define('CATEGORY_LABEL', $cat_labels);


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



<h1 class="cva">CVA</h1>
<div class="manage-clients look-editor has-premium" id="look-editor">

    <h1>Suggestion de look pour <?php echo get_user_meta($userID, 'firstname', true); ?> <?php echo get_user_meta($userID, 'lastname', true); ?></h1>
    <p class="subtitle">(<?php echo $user->user_login; ?>)</p>

    <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
    <input type="hidden" name="seller_id" value="<?php echo get_current_user_id(); ?>">
    <input type="hidden" name="root_url" value="<?php echo get_site_url(); ?>">
    <input type="hidden" name="calibration_url" value="<?php echo CALIBRATION_URL; ?>">
    <input type="hidden" name="token" value="<?php echo $_COOKIE['token']; ?>">
    <input type="hidden" name="size" value="<?php echo get_user_meta($userID, 'size_pants', true); ?>">

    <div class="editor">

        <div class="user-products sp-active">
            <h2 class="main-title">
                <span>Dressing DiKa (<span class="count">0</span>)</span>
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
                        if ($order->get_meta('user_specific') !== '1') {
                            foreach($order->get_items() as $item) {
                                $product = wc_get_product($item->get_product_id());
                                $image_id  = $product->get_image_id();
                                $image_url = wp_get_attachment_image_url($image_id, 'full');

                                echo '<div class="item" data-id="'.$product->get_id().'" data-ref="'.$product->get_attribute('reference').'" data-ready="'.$product->get_attribute('ready').'" data-price="'.$product->get_price().'" data-sale-price="'.$product->get_attribute('sale_price').'" data-category="'.$product->get_attribute('category').'" data-org-category="'.$product->get_attribute('org_category').'" data-image="'.$image_url.'">';

                                    echo "<div class=\"image\" style=\"background-image: url('".$image_url."')\"></div>
                                    <div class=\"name\">
                                        <span>".$item->get_name()."</span>
                                    </div>";
                                    
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div>

            <div class="option must-have">
                <h2>Les incontournables chez DiKa</h2>
                <div class="result">
                    <div class="items">
                        <div class="item" data-category="dress-black">
                            <span class="icon dress"></span>
                            <span class="title">Robe noire</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="plain-tshirt">
                            <span class="icon top_tshirt"></span>
                            <span class="title">Tshirt uni</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="trench">
                            <span class="icon coat"></span>
                            <span class="title">Trench coat</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="vest-jean">
                            <span class="icon vest"></span>
                            <span class="title">Veste jean</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="silk-shirt">
                            <span class="icon shirt"></span>
                            <span class="title">Chemisier en soie</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="caban">
                            <span class="icon shirt"></span>
                            <span class="title">Caban bleu marine</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="high-heel">
                            <span class="icon accessory"></span>
                            <span class="title">Escarpins</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="vest-leather">
                            <span class="icon vest"></span>
                            <span class="title">Veste en cuir</span>
                        </div>
                        <div class="item" data-category="pants-jean">
                            <span class="icon pants"></span>
                            <span class="title">Jean brut</span>
                            <span class="dont-have-txt">
                                Cliquez pour parcourir la gallerie
                            </span>
                        </div>
                        <div class="item" data-category="vest-black">
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
            <div class="model-outer" data-scene="dressing">
                <div class="window settings-cont edit-model">
                    <h2>Apparence du mannequin</h2>
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="settings">
                        <div class="filter-selection size">
                            <h3>Taille de vêtement</h3>
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
                            <h3>Coupe de cheveux</h3>
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
                        <div class="filter-selection face">
                            <h3>Filtre célébrité</h3>
                            <div class="filter-btn" data-filter="36">
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
                    </div>
                </div>
                <div class="window settings-cont edit-scene">
                    <h2>Changer la scène</h2>
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="settings">
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
                            <div class="filter-btn" data-scene="romantic">
                                <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/romantic.jpg)"></div>
                                <div class="name">Romantic</div>
                            </div>
                            <div class="filter-btn" data-scene="beach">
                                <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/beach.jpg)"></div>
                                <div class="name">Plage</div>
                            </div>
                            <div class="filter-btn" data-scene="party">
                                <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/party.jpg)"></div>
                                <div class="name">Party</div>
                            </div>
                            <div class="filter-btn" data-scene="red-carpet">
                                <div class="photo" style="background-image :url(<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/scenes/red-carpet.jpg)"></div>
                                <div class="name">Tapis rougey</div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <div class="title">Manteaux Vestes</div>
                    <div class="controls">
                        <div class="toggle"><i class="fas fa-eye"></i></div>
                    </div>
                    <div class="list"></div>
                    <div class="products">
                        <div class="close"><i class="fas fa-times"></i></div>
                        <img class="loading" src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>
                <div class="window accessories" data-category="accessory">
                    <div class="title">Accessoires</div>
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
                    <img class="model" data-model="hair-2" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/hair-2.png">
                    <img class="model" data-model="hair-3" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/hair-3.png">
                    <img class="model" data-model="kardashian" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/kardashian.png">
                    <img class="model" data-model="rihanna" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/rihanna.png">
                    <img class="model" data-model="beyonce" src="<?php echo get_template_directory_uri(); ?>/assets/images/look-editor/models/beyonce.png">
                </div>
                <div class="customize">
                    <div class="btn model-settings">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="btn scene-settings">
                        <i class="fas fa-image"></i>
                    </div>
                </div>
                <div class="vote">
                    <div class="like"><i class="fas fa-thumbs-up"></i></div>
                    <div class="dislike"><i class="fas fa-thumbs-down"></i></div>
                </div>
                <div class="zoom">
                    <i class="fas fa-search-minus"></i>
                </div>

                <!--<div class="comment">
                    <i class="fas fa-comment-dots"></i>
                </div>-->
                <div class="mensurations">
                    <div class="toggle-btn">
                        <i class="fas fa-ruler"></i>
                    </div>
                    <div class="values">
                        <div class="group">
                            <label>Haut</label>
                            <div class="table">
                                <div class="tr">
                                    <div class="td">
                                        <span>Taille de bonnet</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_cup', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">
                                        <span>Tour de poitrine sous les seins</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_bra', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">
                                        <span>Taille pulls, tee-shirts, sweats, polos</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_top', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">
                                        <span>Taille chemise</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_shirt', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group">
                            <label>Robe</label>
                            <div class="table">
                                <div class="tr">
                                    <div class="td">
                                        <span>Taille</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_dress', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group">
                            <label>Bas</label>
                            <div class="table">
                                <div class="tr">
                                    <div class="td">
                                        <span>Pantalon</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_pants', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group">
                            <label>Chaussures</label>
                            <div class="table">
                                <div class="tr">
                                    <div class="td">
                                        <span>Pointure</span>
                                    </div>
                                    <div class="td value">
                                        <?php $size = get_user_meta($user->ID, 'size_shoes', true);
                                        $sizeSTR = ($size !== '') ? $size : 'N/A'; ?>
                                        <span><?php echo $sizeSTR; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn action-btn propose"><i class="fas fa-paper-plane"></i> Proposer ce look</button>
                <button type="button" class="btn action-btn unpropose"><i class="fas fa-ban"></i> Retirer la proposition</button>
            </div>
        </div>

        <div class="sp-menu">
            <div class="item active" data-view="dressing"><span>Dressing</span></div>
            <div class="item" data-view="looks"><span>Looks proposés</span></div>
            <div class="item" data-view="model"><span>Visualisation</span></div>
        </div>
        <div class="related-looks">
            <h2 class="main-title">
                <span>Looks proposés (<span class="count">0</span>)</span>
                <div class="toggle-filter" data-filter="tags">
                    <i class="fas fa-filter"></i>
                </div>
            </h2>
            <div class="tabs">
                <div class="tab active" title="Looks proposés" data-category="proposed">
                    <span><i class="fas fa-tshirt"></i> Looks proposés</span>
                    <span class="cat-count"></span>
                </div>
                <div class="tab" title="Favoris" data-category="favorites">
                    <span><i class="fas fa-heart"></i> Looks adaptés</span>
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
                    <span class="no-result">Veuillez sélectionner un produit dans la liste de gauche.</span>
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
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="plain-tshirt">
        <h2>Tshirt uni</h2>
        <p>Blanc, noir ou gris. Le t-shirt uni fluide doit vous mettre à l’aise et se marier avec l’intégralité de votre dressing. Donnez-vous une allure décontractée ou habillée, tendance ou très classique, boyish ou girly. Encore une fois, un tas de possibilités. C’est a vous de jouer !</p>
        <div class="products">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="vest-jean">
        <h2>Veste en jean</h2>
        <p>Multifonction encore ! Juxtaposée à un débardeur, nouée à la taille, la chemise en jean peut se porter de mille façons possibles. En denim brut ou bleu ciel, optez pour une jolie boutonnière, légèrement cintrée ou empruntez-là à votre petit-ami ou à un ami dans un style plus oversize, en retroussant vos manches pour ne pas trop noyer votre silhouette. Existe aussi en gris, noir et un peu destroy pour une tenue plus rock’n’roll.</p>
        <div class="products">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="trench">
        <h2>Trench</h2>
        <p></p>
        <div class="products">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="total-white">
        <h2>Total look blanc</h2>
        <p>Des Suffragettes aux Boys Band, le total-look blanc est un incontournable. Ces dernières années, il a su s'imposer dans nos vestiaires autant l'hiver que l'été.</p>
        <div class="products">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loading.gif" />
        </div>
    </div>

</div>

<div class="modal" id="confirm-proposal">
    <div class="window">
        <div class="header">
            <span>Confirmation</span>
        </div>
        <div class="body">
            <p>
                Souhaitez-vous vraiment envoyer ce look au client ?
            </p>
        </div>
        <div class="footer">
            <button typ="button" class="btn btn-secondary close">Non</button>
        </div>
    </div>
</div>
<div class="modal" id="confirm-unproposal">
    <div class="window">
        <div class="header">
            <span>Confirmation</span>
        </div>
        <div class="body">
            <p>
                Êtes-vous sûr de vouloir retirer la proposition au client ?
            </p>
        </div>
        <div class="footer">
            <button typ="button" class="btn btn-secondary close">Non</button>
        </div>
    </div>
</div>
<div class="modal" id="proposal-success">
    <div class="window">
        <div class="header">
            <span>Information</span>
        </div>
        <div class="body">
            <p>
                La proposition a été envoyé au client avec succès.
            </p>
        </div>
        <div class="footer">
            <button typ="button" class="btn close">OK</button>
        </div>
    </div>
</div>
<div class="modal" id="unproposal-success">
    <div class="window">
        <div class="header">
            <span>Information</span>
        </div>
        <div class="body">
            <p>
                La proposition a bien été retirée.
            </p>
        </div>
        <div class="footer">
            <button typ="button" class="btn close">OK</button>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/modals/comment-look'); ?>

<?php require_once 'parts/client-actions.php'; ?>