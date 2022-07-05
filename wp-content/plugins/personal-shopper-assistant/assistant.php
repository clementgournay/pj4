<?php


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

<div class="assistant look-editor" id="assistant">

    <h1>Assistant Personal Shopper</h1>

    <input type="hidden" name="seller_id" value="<?php echo get_current_user_id(); ?>">
    <input type="hidden" name="root_url" value="<?php echo get_site_url(); ?>">
    <input type="hidden" name="calibration_url" value="<?php echo CALIBRATION_URL; ?>">
    <input type="hidden" name="token" value="<?php echo $_COOKIE['token']; ?>">
    <input type="hidden" name="size" value="<?php echo get_user_meta($userID, 'size_pants', true); ?>">

    <div class="editor">
        <div class="user-products sp-active">
            <h2 class="main-title">
                <span>Pièces du Retail Store (<span class="shop-count">52</span>) <span class="shop-code">F31</span></span>
                <div class="toggle-filter" data-filter="category">
                    <i class="fas fa-filter"></i>
                </div>
            </h2>
            <p class="desc">Sélectionnez un article pour afficher les looks correspondants.</p>
            <div class="wizard">
                <div class="view active" data-view="selection">
                    <div class="bar search-ref">
                        <div class="td field">
                            <input type="text" placeholder="Rechercher par référence...">
                        </div>
                        <div class="td command">
                            <button type="button" class="btn"><i class="fas fa-search"></i> Recherche</button>
                        </div>
                    </div>
                    <div class="categories sp-active">
                        <?php 
                        foreach(CATEGORIES as $category) {
                            echo '<div class="category" data-category="'.$category.'">
                                <span class="drawing '.$category.'"></span>
                                <span class="name">'.$cat_labels[$category].'</span>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="view loading" data-view="products">
                    <div class="bar">
                        <div class="back"><i class="fas fa-arrow-left"></i></div>
                        <div class="title"></div>
                    </div>
                    <div class="products"></div>
                </div>
            </div>

            <div class="option must-have">
                <h2>Les incontournables</h2>
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
                            <div class="image" style="background-image: url(<?php echo plugins_url('images/look-editor/trends/total-white.jpg', __FILE__); ?>)"></div>
                            <span class="title">Total look blanc</span>
                        </div>
                        <div class="item color-sping22" data-category="color-sping22">
                            <div class="image" style="background-image: url(<?php echo plugins_url('images/look-editor/trends/color-spring22.jpg', __FILE__); ?>)"></div>
                            <span class="title">Couleurs Printemps-Ete 2022</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="model-cont">
            <div class="model-outer">
                <div class="window settings-cont edit-model">
                    <h2>Apparence du mannequin</h2>
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="settings">
                        <div class="filter-selection size">
                            <h3>Visage</h3>
                            <div class="filter-btn selected" data-filter="1-36">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/1/36.png', __FILE__); ?>)"></div>
                                <div class="name">Visage 1</div>
                            </div>
                            <div class="filter-btn" data-filter="2-36">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/2/36.png', __FILE__); ?>)"></div>
                                <div class="name">Visage 2</div>
                            </div>
                        </div>
                        <div class="filter-selection size">
                            <h3>Taille de vêtement</h3>
                            <div class="filter-btn selected" data-filter="2-36">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/36-thumb.jpg', __FILE__); ?>)"></div>
                                <div class="name">36</div>
                            </div>
                            <div class="filter-btn" data-filter="2-38">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/38-thumb.jpg', __FILE__); ?>)"></div>
                                <div class="name">38</div>
                            </div>
                            <div class="filter-btn" data-filter="2-42">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/42-thumb.jpg', __FILE__); ?>)"></div>
                                <div class="name">42</div>
                            </div>
                        </div>
                        <div class="filter-selection hair">
                            <h3>Coupe de cheveux</h3>
                            <div class="filter-btn selected" data-filter="36">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/36-thumb.jpg', __FILE__); ?>)"></div>
                                <div class="name">Attachés</div>
                            </div>
                            <div class="filter-btn" data-filter="hair-2">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/hair-2-thumb.jpg', __FILE__); ?>)"></div>
                                <div class="name">Longs</div>
                            </div>
                            <div class="filter-btn" data-filter="hair-3">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/models/hair-3-thumb.jpg', __FILE__); ?>)"></div>
                                <div class="name">Courts</div>
                            </div>
                        </div>
                        <div class="filter-selection celebrity">
                            <h3>Filtre célébrité</h3>
                            <div class="filter-btn" data-filter="36">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/filters/normal.jpg', __FILE__); ?>)"></div>
                                <div class="name">Normal</div>
                            </div>
                            <div class="filter-btn" data-filter="kardashian">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/filters/kardashian.jpg', __FILE__); ?>)"></div>
                                <div class="name">Kim Kardashian</div>
                            </div>
                            <div class="filter-btn" data-filter="rihanna">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/filters/rihanna.jpg', __FILE__); ?>)"></div>
                                <div class="name">Rihanna</div>
                            </div>
                            <div class="filter-btn" data-filter="beyonce">
                                <div class="photo" style="background-image: url(<?php echo plugins_url('images/look-editor/filters/beyonce.jpg', __FILE__); ?>)"></div>
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
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/dressing.jpg', __FILE__); ?>)"></div>
                                <div class="name">Dressing</div>
                            </div>
                            <div class="filter-btn" data-scene="office">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/office.jpg', __FILE__); ?>)"></div>
                                <div class="name">Bureaux</div>
                            </div>
                            <div class="filter-btn" data-scene="city">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/city.jpg', __FILE__); ?>)"></div>
                                <div class="name">Ville</div>
                            </div>
                            <div class="filter-btn" data-scene="nature">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/nature.jpg', __FILE__); ?>)"></div>
                                <div class="name">Nature</div>
                            </div>
                            <div class="filter-btn" data-scene="romantic">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/romantic.jpg', __FILE__); ?>)"></div>
                                <div class="name">Romantic</div>
                            </div>
                            <div class="filter-btn" data-scene="beach">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/beach.jpg', __FILE__); ?>)"></div>
                                <div class="name">Plage</div>
                            </div>
                            <div class="filter-btn" data-scene="party">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/party.jpg', __FILE__); ?>)"></div>
                                <div class="name">Party</div>
                            </div>
                            <div class="filter-btn" data-scene="red-carpet">
                                <div class="photo" style="background-image :url(<?php echo plugins_url('images/look-editor/scenes/red-carpet.jpg', __FILE__); ?>)"></div>
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
                        <img class="loading" src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>
                <div class="window coat-vest" data-category="coat, vest">
                    <div class="list"></div>
                    <div class="products">
                        <div class="close"><i class="fas fa-times"></i></div>
                        <img class="loading" src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
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
                        <img class="loading" src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>
                <div class="clothing">
                    <img class="model" data-model="1-36" src="<?php echo plugins_url('images/look-editor/models/1/36.png', __FILE__); ?>">
                    <img class="model" data-model="1-38" src="<?php echo plugins_url('images/look-editor/models/1/38.png', __FILE__); ?>">
                    <img class="model" data-model="1-42" src="<?php echo plugins_url('images/look-editor/models/1/42.png', __FILE__); ?>">
                    <img class="model" data-model="1-hair-2" src="<?php echo plugins_url('images/look-editor/models/1/hair-2.png', __FILE__); ?>">
                    <img class="model" data-model="1-hair-3" src="<?php echo plugins_url('images/look-editor/models/1/hair-3.png', __FILE__); ?>">
                    <img class="model selected" data-model="2-36" src="<?php echo plugins_url('images/look-editor/models/2/36.png', __FILE__); ?>">
                    <img class="model" data-model="2-38" src="<?php echo plugins_url('images/look-editor/models/2/38.png', __FILE__); ?>">
                    <img class="model" data-model="2-42" src="<?php echo plugins_url('images/look-editor/models/2/42.png', __FILE__); ?>">
                    <img class="model" data-model="2-hair-2" src="<?php echo plugins_url('images/look-editor/models/2/hair-2.png', __FILE__); ?>">
                    <img class="model" data-model="2-hair-3" src="<?php echo plugins_url('images/look-editor/models/2/hair-3.png', __FILE__); ?>">
                    <img class="model" data-model="kardashian" src="<?php echo plugins_url('images/look-editor/models/kardashian.png', __FILE__); ?>">
                    <img class="model" data-model="rihanna" src="<?php echo plugins_url('images/look-editor/models/rihanna.png', __FILE__); ?>">
                    <img class="model" data-model="beyonce" src="<?php echo plugins_url('images/look-editor/models/beyonce.png', __FILE__); ?>">
                    <!--<div class="vote">
                        <div class="like"><i class="fas fa-thumbs-up"></i></div>
                        <div class="dislike"><i class="fas fa-thumbs-down"></i></div>
                    </div>-->
                </div>
                <div class="customize">
                    <div class="btn model-settings">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="btn scene-settings">
                        <i class="fas fa-image"></i>
                    </div>
                </div>
                
                <div class="zoom">
                    <i class="fas fa-search-minus"></i>
                </div>
                <div class="toggle-model">
                    <i class="fas fa-user-slash"></i>
                </div>
                <!--
                <div class="comment">
                    <i class="fas fa-comment-dots"></i>
                </div>
                    -->
                <button type="button" class="btn action-btn buy"><i class="fas fa-shopping-cart"></i> ACHETER CE LOOK</button>

                <div class="logo">
                    <img src="<?php echo plugins_url('images/logos/dika.png', __FILE__); ?>" />
                </div>
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
                <div class="toggle-filter" data-filter="category">
                    <i class="fas fa-filter"></i>
                </div>
            </h2>
            <div class="items">
                <div class="tags filter-window" data-filter="category">
                    <div class="tag">#vintage</div>
                    <div class="tag">#chic</div>
                    <div class="tag">#casual</div>
                    <div class="tag">#classique</div>
                    <div class="tag">#audacieux</div>
                    <div class="tag">#business</div>
                </div>
                <div class="looks proposed active" data-category="proposed">
                    <span class="no-result" style="display: block">Veuillez sélectionner un produit dans la liste de gauche.</span>
                </div>
                <div class="looks favorites" data-category="favorites">
                    <img class="loading" src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
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
            <img src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
        </div>
    </div>

    <div class="popup" data-category="plain-tshirt">
        <h2>Tshirt uni</h2>
        <p>Blanc, noir ou gris. Le t-shirt uni fluide doit vous mettre à l’aise et se marier avec l’intégralité de votre dressing. Donnez-vous une allure décontractée ou habillée, tendance ou très classique, boyish ou girly. Encore une fois, un tas de possibilités. C’est a vous de jouer !</p>
        <div class="products">
            <img src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
        </div>
    </div>

    <div class="popup" data-category="vest-jean">
        <h2>Veste en jean</h2>
        <p>Multifonction encore ! Juxtaposée à un débardeur, nouée à la taille, la chemise en jean peut se porter de mille façons possibles. En denim brut ou bleu ciel, optez pour une jolie boutonnière, légèrement cintrée ou empruntez-là à votre petit-ami ou à un ami dans un style plus oversize, en retroussant vos manches pour ne pas trop noyer votre silhouette. Existe aussi en gris, noir et un peu destroy pour une tenue plus rock’n’roll.</p>
        <div class="products">
            <img src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
        </div>
    </div>

    <div class="popup" data-category="total-white">
        <h2>Total look blanc</h2>
        <p>Des Suffragettes aux Boys Band, le total-look blanc est un incontournable. Ces dernières années, il a su s'imposer dans nos vestiaires autant l'hiver que l'été.</p>
        <div class="products">
            <img src="<?php echo plugins_url('images/icons/loading.gif', __FILE__); ?>" />
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
            <button typ="button" class="btn btn-primary close">Non</button>
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
            <button typ="button" class="btn btn-primary close">Non</button>
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
            <button typ="button" class="btn btn-primary close">OK</button>
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
            <button typ="button" class="btn btn-primary close">OK</button>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/modals/comment-look'); ?>
<?php get_template_part('template-parts/modals/subscribe'); ?>
