<?php 
/* Template name: Assistant */



$brands = [
    'dika' => 'DiKa',
    'zara' => 'Zara',
    'hermes' => 'Hermès',
    'louis-vuitton' => 'Louis Vuitton'
];

$cat = get_term_by('slug', 'clothes', 'product_cat');
$terms = get_terms('product_cat', array('child_of' => $cat->term_id, 'hide_empty' => false));

$cat_slugs = ['coat', 'vest', 'dress', 'skirt', 'top_tshirt', 'shirt', 'pants', 'short', 'jumpsuit', 'accessory'];
$cat_labels = [];

foreach($terms as $category) { 
    $cat_labels[$category->slug] = $category->name;
}

define('CATEGORIES', $cat_slugs);
define('CATEGORY_LABEL', $cat_labels);
$shop = (get_query_var('shop') !== '') ? get_query_var('shop') : 'smart-personal-shopper';
define('BRAND_ID', $shop);
define('BRAND_LABEL', $brands[BRAND_ID]);


$date = new DateTime();

//if (!isset($_COOKIE['token'])) {
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
//}

get_header();

?>


<style>#main { grid-template-columns: none !important }</style>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/three.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/fflate.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/loaders/FBXLoader.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/loaders/GLTFLoader.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/controls/OrbitControls.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/scene.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/marketplace.js"></script>

<div class="assistant look-editor" id="assistant">

    <div id="lcd" class="lcd">

        <div class="background" data-depth="0.2" style="background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/banners/<?php echo BRAND_ID; ?>.jpg)"></div>

        <div class="logo" data-depth="0.5">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/logos/<?php echo BRAND_ID; ?>.png" />
        </div>

        <?php if (BRAND_ID === 'dika') :?>
        <div class="screens">
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/dika/video1.webm" type="video/webm"/>
                </video>
                <div class="title">Nos looks phares</div>
            </div>
            <div class="screen">
                <div class="image" style="background-image: url(<?php echo get_template_directory_uri() ?>/assets/images/dika/image1.jpg)"></div>
                <div class="title">Soldes jusqu'à -50%</div>
            </div>
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/dika/video2.webm" type="video/webm"/>
                </video>
                <div class="title">Dernière collection</div>
            </div>
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/dika/video3.webm" type="video/webm"/>
                </video>
                <div class="title">Behind the scenes</div>
            </div>
        </div>
        <?php endif;?>

        <?php if (BRAND_ID === 'hermes') :?>
        <div class="screens">
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/hermes/video1.mp4" type="video/mp4"/>
                </video>
                <div class="title">Défilé homme été 2023</div>
            </div>
            <div class="screen">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/hermes/bags.jpg" />
                <div class="title">Collection accessoires 2022</div>
            </div>
            <div class="screen">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/hermes/terre.webp" />
                <div class="title">Terre d'Hermès</div>
            </div>
        </div>
        <?php endif;?>

        <?php if (BRAND_ID === 'louis-vuitton') :?>
        <div class="screens">
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/louis-vuitton/show-2023.mp4" type="video/mp4"/>
                </video>
                <div class="title">Défilé homme été 2023</div>
            </div>
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/louis-vuitton/lea.mp4" type="video/mp4"/>
                </video>
                <div class="title">Léa Seydoux et le capucines</div>
            </div>
            <div class="screen">
                <video autoplay="autoplay" loop muted>
                    <source src="<?php echo get_template_directory_uri() ?>/assets/videos/louis-vuitton/tambour.mp4" type="video/mp4"/>
                </video>
                <div class="title">Tambour Street Diver</div>
            </div>
        </div>
        <?php endif;?>
    </div>

    <a class="get-back" href="../">
        <i class="fas fa-arrow-left"></i> Retour au choix des marques
    </a>

    <section class="profiling">
        <p>Je suis</p>
        <select class="nature">
            <option value="women">une femme</option>
            <option value="men">un homme</option>
            <option value="girl">une fille</option>
            <option value="boy">un garçon</option>
        </select>
        <p>qui met du</p>
        <select class="size">
            <option value="34">34</option>
            <option value="36" selected>36</option>
            <option value="38">38</option>
            <option value="40">40</option>
            <option value="42">42</option>
            <option value="44">44</option>
        </select><br>
        <p>et je recherche </p>
        <select class="category">
            <option value="clothes">un vêtement</option>
            <option value="shoes">des chaussures</option>
            <option value="bags">un sac</option>
            <option value="accessories">des accessoires</option>
        </select>
        <p>pour aller</p>
        <select class="context">
            <option value="town">en ville</option>
            <option value="work">au travail</option>
            <option value="beach">à la plage</option>
            <option value="party">à une fête</option>
            <option value="wedding">à un mariage</option>
        </select>        
    </section>

    <input type="hidden" name="brand_id" value="<?php echo BRAND_ID; ?>">
    <input type="hidden" name="seller_id" value="<?php echo get_current_user_id(); ?>">
    <input type="hidden" name="root_url" value="<?php echo get_site_url(); ?>">
    <input type="hidden" name="calibration_url" value="<?php echo CALIBRATION_URL; ?>">
    <input type="hidden" name="token" value="<?php echo $_COOKIE['token']; ?>">
    <input type="hidden" name="size" value="<?php echo get_user_meta($userID, 'size_pants', true); ?>">

    <div class="editor">

        <div class="product-selection sp-active">
            <h2 class="main-title">
                <span>Sélection du vêtement</span>
                <div class="toggle-filter" data-filter="category">
                    <i class="fas fa-filter"></i>
                </div>
            </h2>
            
            <div class="toolbar">
                <div class="tool" data-view="must-have"><i class="fas fa-gem"></i> Incontournables</div>
                <div class="tool" data-view="fashion"><i class="fas fa-fire"></i> Tendances</div>
            </div>

            <div class="wizard">
                <div class="view active" data-view="selection">
                    <div class="bar">
                        <div class="title">Vêtements</div>
                    </div>
                    <div class="categories sp-active">
                        <?php 
                        foreach(CATEGORIES as $category) {
                            if ($category !== 'accessory') {
                                echo '<div class="category" data-category="'.$category.'">
                                    <span class="drawing '.$category.'"></span>
                                    <span class="name">'.$cat_labels[$category].'</span>
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="view loading" data-view="products">
                    <div class="bar">
                        <div class="back"><i class="fas fa-arrow-left"></i></div>
                        <div class="title"></div>
                    </div>
                    <div class="filters">
                        <div class="filter color">
                            <select>
                                <option disabled selected>Couleur...</option>
                                <option value="all">Tout</option>
                                <option value="blue">Bleu</option>
                                <option value="yellow">Jaune</option>
                                <option value="green">Vert</option>
                                <option value="pink">Rose</option>s
                                <option value="white">Blanc</option>
                                <option value="black">Noir</option>
                                <option value="orange">Orange</option>
                                <option value="purple">Violet</option>
                                <option value="beige">Beige</option>
                                <option value="brown">Marron</option>
                            </select>
                        </div>
                        <div class="filter cut">
                            <select>
                                <option disabled selected>Coupe...</option>
                                <option value="all">Tout</option>
                                <option value="regular">Regular</option>
                                <option value="slim">Slim</option>
                                <option value="skinny">Skinny</option>
                                <option value="super-skinny">Super Skinny</option>
                            </select>
                        </div>
                        <div class="filter composition">
                            <select class="composition">
                                <option disabled selected>Composition...</option>
                                <option value="all">Tout</option>
                                <option value="cotton">Cotton</option>
                                <option value="wool">Laine</option>
                                <option value="polyester">Polyester</option>
                                <option value="elastane">Elastane</option>
                            </select>
                        </div>
                        <div class="filter sale">
                            <input type="checkbox" id="sale"> 
                            <label for="sale">En solde</label>
                        </div>

                    </div>
                    <div class="products"></div>
                </div>

                <!--<div class="view must-have" data-view="must-have">
                    <div class="bar">
                        <div class="title">Incontournables</div>
                    </div>
                    <div class="content">
                        here
                    </div>
                </div>-->
            </div>

            <!--
            <div class="option must-have">
                <h2>Les incontournables chez <?php echo BRAND_LABEL; ?></h2>
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
                            <div class="image" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/trends/total-white.jpg)"></div>
                            <span class="title">Total look blanc</span>
                        </div>
                        <div class="item color-sping22" data-category="color-sping22">
                            <div class="image" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/trends/color-spring22.jpg)"></div>
                            <span class="title">Couleurs Printemps-Ete 2022</span>
                        </div>
                    </div>
                </div>
            </div>
            -->

        </div>
        <div class="model-cont">
            <div class="model-outer">
                <div class="window settings-cont edit-model">
                    <h2>Apparence du mannequin</h2>
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="settings">
                        <div class="filter-selection face">
                            <h3>Visage</h3>
                            <div class="filter-btn" data-filter="1-36">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/36.png)"></div>
                                <div class="name">Européenne 1</div>
                            </div>
                            <div class="filter-btn selected" data-filter="2-36">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/36.png)"></div>
                                <div class="name">Européenne 2</div>
                            </div>
                            <div class="filter-btn" data-filter="3-36">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/3/36.png)"></div>
                                <div class="name">Asiatique</div>
                            </div>
                        </div>
                        <div class="filter-selection size">
                            <h3>Taille de vêtement</h3>
                            <div class="filter-btn selected" data-filter="1-36">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/36.png)"></div>
                                <div class="name">36</div>
                            </div>
                            <div class="filter-btn" data-filter="1-38">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/38.png)"></div>
                                <div class="name">38</div>
                            </div>
                            <div class="filter-btn" data-filter="1-42">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/42.png)"></div>
                                <div class="name">42</div>
                            </div>
                        </div>
                        <div class="filter-selection hair">
                            <h3>Coupe de cheveux</h3>
                            <div class="filter-btn selected" data-filter="2-36">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/36.png)"></div>
                                <div class="name">Attachés</div>
                            </div>
                            <div class="filter-btn" data-filter="2-hair-2">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/hair-2.png)"></div>
                                <div class="name">Courts</div>
                            </div>
                            <div class="filter-btn" data-filter="2-hair-3">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/hair-3.png)"></div>
                                <div class="name">Longs</div>
                            </div>
                        </div>
                        <div class="filter-selection celibrity">
                            <h3>Filtre célébrité</h3>
                            <div class="filter-btn" data-filter="2-36">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/filters/normal.jpg)"></div>
                                <div class="name">Normal</div>
                            </div>
                            <div class="filter-btn" data-filter="kardashian">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/filters/kardashian.jpg)"></div>
                                <div class="name">Kim Kardashian</div>
                            </div>
                            <div class="filter-btn" data-filter="rihanna">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/filters/rihanna.jpg)"></div>
                                <div class="name">Rihanna</div>
                            </div>
                            <div class="filter-btn" data-filter="beyonce">
                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/filters/beyonce.jpg)"></div>
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
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/dressing.jpg)"></div>
                                <div class="name">Dressing</div>
                            </div>
                            <div class="filter-btn" data-scene="office">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/office.jpg)"></div>
                                <div class="name">Bureaux</div>
                            </div>
                            <div class="filter-btn" data-scene="city">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/city.jpg)"></div>
                                <div class="name">Ville</div>
                            </div>
                            <div class="filter-btn" data-scene="city-night">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/city-night.jpg)"></div>
                                <div class="name">Ville nuit</div>
                            </div>
                            <div class="filter-btn" data-scene="nature">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/nature.jpg)"></div>
                                <div class="name">Nature</div>
                            </div>
                            <div class="filter-btn" data-scene="romantic">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/romantic.jpg)"></div>
                                <div class="name">Romantic</div>
                            </div>
                            <div class="filter-btn" data-scene="beach">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/beach.jpg)"></div>
                                <div class="name">Plage</div>
                            </div>
                            <div class="filter-btn" data-scene="beach-way">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/beach-way.jpg)"></div>
                                <div class="name">Chemin de plage</div>
                            </div>
                            <div class="filter-btn" data-scene="party">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/party.jpg)"></div>
                                <div class="name">Party</div>
                            </div>
                            <div class="filter-btn" data-scene="red-carpet">
                                <div class="photo" style="background-image :url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/scenes/red-carpet.jpg)"></div>
                                <div class="name">Tapis rouge</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="window settings-cont label-desc">
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="desc" data-label="oeko-standard">
                        <div class="center">
                            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/oeko-tex_standard.png" alt="OEKO TEX Standard" title="OEKO TEX Standard"/>
                            <p>Assure que les substances nocives ne sont pas présentes dans nos textiles.</p>
                        </div>
                    </div>
                    <div class="desc" data-label="oeko-step">
                        <div class="center">
                            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/oeko-tex_step.jpg" alt="OEKO TEX Step" title="OEKO TEX Step"/>
                            <p>Production durable de manière transparente, fiable et claire pour le consommateur.</p>
                        </div>
                    </div>
                    <div class="desc" data-label="grs">
                        <div class="center">
                            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/grs.png" alt="Global Recycled Standard" title="Global Recycled Standard"/>
                            <p>Il certifie que le contenu déclaré est précis et conforme, les bonnes conditions de travail et l’impact réduit des effets chimiques sur l’environnement.</p>
                        </div>
                    </div>
                    <div class="desc" data-label="woolmark">
                        <div class="center">
                            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/woolmark.png" alt="Woolmark" title="Woolmark"/>
                            <p>Permet de certifier les produits de laine d’une grande qualité.</p>
                        </div>
                    </div>
                </div>
                <div class="window cloth-replace">
                    <h2>Remplacer vêtement</h2>
                    <div class="close">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="products">
                        <img class="loading" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>
                <div class="window coat-vest" data-category="coat, vest">
                    <div class="list"></div>
                    <div class="products">
                        <div class="close"><i class="fas fa-times"></i></div>
                        <img class="loading" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
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
                        <img class="loading" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
                        <div class="product-list"></div>
                        <button type="button" class="btn replace">Remplacer</button>
                    </div>
                </div>

                <div class="clothing">
                    <img class="model selected" data-model="1-36" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/36.png">
                    <img class="model" data-model="1-38" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/38.png">
                    <img class="model" data-model="1-42" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/42.png">
                    <img class="model" data-model="1-hair-2" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/hair-2.png">
                    <img class="model" data-model="1-hair-3" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/hair-3.png">

                    <img class="model" data-model="2-36" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/36.png">
                    <img class="model" data-model="2-38" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/38.png">
                    <img class="model" data-model="2-42" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/42.png">
                    <img class="model" data-model="2-hair-2" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/hair-2.png">
                    <img class="model" data-model="2-hair-3" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/hair-3.png">
                   
                    <img class="model" data-model="3-36" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/3/36.png">
                    <img class="model" data-model="3-38" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/3/38.png">
                    <img class="model" data-model="3-42" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/3/42.png">
                    <img class="model" data-model="3-hair-2" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/hair-2.png">
                    <img class="model" data-model="3-hair-3" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/hair-3.png">

                    <img class="model" data-model="kardashian" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/kardashian.png">
                    <img class="model" data-model="rihanna" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/rihanna.png">
                    <img class="model" data-model="beyonce" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/beyonce.png">
          
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
    
                <button type="button" class="btn action-btn buy"><i class="fas fa-shopping-cart"></i> ACHETER CE LOOK</button>

                <div class="logo">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/logos/<?php echo BRAND_ID; ?>.png" />
                </div>
            </div>
        </div>

        <div class="sp-menu">
            <div class="item active" data-view="dressing"><span>Dressing</span></div>
            <div class="item" data-view="looks"><span>Looks proposés</span></div>
            <div class="item" data-view="model"><span>Visualisation</span></div>
        </div>

        <div class="related-looks">
            <div class="view active" data-view="looks">
                <h2 class="main-title">
                    <span>Looks proposés (<span class="count">0</span>)</span>
                    <div class="toggle-filter" data-filter="category">
                        <i class="fas fa-filter"></i>
                    </div>
                </h2>
                <div class="items">
                    <div class="tags"></div>
                    <div class="looks proposed active" data-category="proposed">
                        <span class="no-result" style="display: block">Veuillez sélectionner un produit dans la liste de gauche.</span>
                    </div>
                    <div class="looks favorites" data-category="favorites">
                        <img class="loading" src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
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

            <div id="product-detail" class="view" data-view="product-detail">
                <h2 class="main-title">
                    <span>Détail du produit</span>
                </h2>
                <div class="window">
                    <div class="bar">
                        <div class="back"><i class="fas fa-arrow-left"></i></div>
                        <div class="title">Détail du produit</div>
                    </div>
                    <div class="photos">
                        <div class="main">
                            <div class="expand">
                                <i class="fas fa-expand-alt"></i>
                            </div>
                            <div class="zoom"></div>
                            <div class="photo"></div>
                            <div class="brand"></div>
                            <div class="price" data-price></div>
                        </div>
                        <div class="others">
                            <div class="photo"></div>
                            <div class="photo"></div>
                            <div class="photo"></div>
                        </div>
                    </div>

                    <div class="reference">
                        <span>Référence: </span><span data-ref></span>
                    </div>
                    
                    <div class="scrollable">
                        <div class="description">
                            <p data-description>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae bibendum dolor, sit amet molestie eros. Praesent vel molestie massa, quis hendrerit dui. </p>
                        </div>
                        <div class="blocks">
                            <div class="block left">
                                <div class="field">
                                    <div class="title">Matières, origine, entretien</div>
                                    <div class="content">
                                        <div class="origin-block">
                                            <div class="subtitle">Origine</div>
                                            <div class="origin" data-origin></div>
                                        </div>
                                        <div class="composition-block">
                                            <div class="subtitle">Composition</div>
                                            <div class="composition" data-composition></div>
                                        </div>
                                        <div class="advice-block">
                                            <div class="subtitle">Conseils d'utilisation</div>
                                            <ul class="advices" data-advices></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="title">Description du produit</div>
                                    <div class="content">
                                        <div class="row category-block">
                                            <div class="td label">Catégorie:</div> 
                                            <div class="td value" data-category></div>
                                        </div>
                                        <div class="row brand-block">
                                            <div class="td label">Marque:</div> 
                                            <div class="td value" data-brand></div>
                                        </div>
                                        <div class="row cut-block">
                                            <div class="td label">Coupe:</div> 
                                            <div class="td value" data-cut></div>
                                        </div>                   
                                        <div class="row collection-block">
                                            <div class="td label">Collection:</div> 
                                            <div class="td value" data-collection></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="title">Disponibilité</div>
                                    <div class="content">
                                        <div class="type">
                                            <select name="delivery-type">
                                                <option value="store" selected>Retrait en boutique</option>
                                                <option value="home">Livraison</option>
                                            </select>
                                        </div>
                                        <ul class="list-group stores">
                                            <li class="option store selected">
                                                <div class="line">
                                                    <div class="name"><i class="fas fa-store"></i> DiKa Nice</div> 
                                                    <div class="distance">5km</div> 
                                                </div>
                                                <div class="line">
                                                    <div class="actions">
                                                        <i class="fas fa-phone phone-call"></i>
                                                        <i class="fas fa-comment-dots vocal-message"></i>
                                                    </div>
                                                    <div class="stock">5 disponibles</div>
                                                </div>
                                            </li>
                                            <li class="option store">
                                                <div class="line">
                                                    <div class="name"><i class="fas fa-store"></i> DiKa Rouen</div> 
                                                    <div class="distance">25km</div> 
                                                </div>
                                                <div class="line">
                                                    <div class="actions">
                                                        <i class="fas fa-phone"></i>
                                                        <i class="fas fa-comment-dots"></i>
                                                    </div>
                                                    <div class="stock">4 disponibles</div>
                                                </div>
                                            </li>
                                            <li class="option store">
                                                <div class="line">
                                                    <div class="name"><i class="fas fa-store"></i> DiKa Paris</div> 
                                                    <div class="distance">504km</div> 
                                                </div>
                                                <div class="line">
                                                    <div class="actions">
                                                        <i class="fas fa-phone"></i>
                                                        <i class="fas fa-comment-dots"></i>
                                                    </div>
                                                    <div class="stock">2 disponibles</div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="delivery-delay">
                                            <i class="fas fa-home"></i> Livraison chez vous en 10 jour ouvrés.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block right">
                                <div class="field size-block">
                                    <div class="title">Tailles disponibles</div>
                                    <div class="content">
                                        <div class="sizes" data-size></div>
                                        <div class="model-selection">
                                            <div class="model selected" data-filter="1-36">
                                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/1/36.png)"></div>
                                            </div>
                                            <div class="model" data-filter="2-36">
                                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/2/36.png)"></div>
                                            </div>
                                            <div class="model" data-filter="3-36">
                                                <div class="photo" style="background-image: url(<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/models/3/36.png)"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field color-block">
                                    <div class="title">Couleurs disponibles</div>
                                    <div class="content">
                                        <div class="colors" data-colors></div>
                                    </div>
                                </div>
                                <div class="field label-block">
                                    <div class="title">Labels</div>
                                    <div class="content">
                                        <div class="col">
                                            <div class="label oeko-tex-standard" data-label="oeko-standard">
                                                <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/oeko-tex_standard.png" alt="OEKO TEX Standard" title="OEKO TEX Standard"/>
                                            </div>
                                            <div class="label oeko-tex-step" data-label="oeko-step">
                                                <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/oeko-tex_step.jpg" alt="OEKO TEX Step" title="OEKO TEX Step"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="label grs" data-label="grs">
                                                <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/grs.png" alt="Global Recycled Standard" title="Global Recycled Standard"/>
                                            </div>
                                            <div class="label woolmark" data-label="woolmark">
                                                <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/labels/woolmark.png" alt="woolmark" title="Woolmark"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
             
                        </div>

                    </div>


                    <div class="related-items">
                        <h3>Articles associés (<span class="item-count">0</span>)</h3>
                        <div class="outer">
                            <div class="inner"></div>
                        </div>
                    </div>

                    <div class="controls">
                        <button type="button" class="btn"><i class="fas fa-shopping-cart"></i> AJOUTER AU PANIER</button>
                        <br>
                        <a href="#">Conditions générales de vente</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="character-wizard">
        <div class="character">
            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/look-editor/wizard.png" />
        </div>
        <div class="description">
            <p class="step active">
                Bonjour, je suis votre assistant.<br>
                Cliquez sur moi afin que je vous montre par où commencer.
            </p>
            <p class="step" data-focus=".profiling">
                Voici la section pour définir vos besoins.<br>
                Cela me premettra de faire apparaître les produits qui vous correspondent.<br>
                Remplissez la phrase qui vous définit et cliquez moi quand vous avez fini.<br>
            </p>
            <p class="step" data-focus=".product-selection" data-wait-actions="click{.wizard .categories .category} | click{.wizard .products .product}">
                Choisissez ensuite le type de vêtement que vous recherchez.<br>
                Vous pouvez également utiliser les filtres pour affiner vos recherche.<br>
                C'est à vous !
            </p>
            <p class="step" data-focus=".related-looks" data-wait-actions="click{.related-looks .item}">
                Voici les looks que j'ai crée à partir du vêtement que vous avez sélectionné.<br>
                Cliquez sur les différents looks pour visualiser l'ensemble dans le mirroir.
            </p>
            <p class="step" data-focus=".model-outer" data-wait-actions="mouseenter{.model-outer .cloth}">
                Voici le look que vous avez choisi.<br>
                Passez la souris sur un vêtement pour afficher son détail.
            </p>
            <p class="step" data-focus="#product-detail" data-wait-actions="click{#product-detail .size}">
                Ceci est la fiche produits où vous pouvez consulter les caractéristiques du produit, sa disponibilité ou alors sélectionner la taille et le colori.<br>
                Commencez par modifier la taille du vêtement.
            </p>
            <p class="step" data-focus="#product-detail" data-wait-actions="click{#product-detail .related-items .product}">
                Tout changement dans la fiche produit se traduit dans le mirroir. Pratique n'est-ce pas ?<br>
                Vous pouvez également modifier une partie du look en cliquant dans les produits associés.<br>
                Cliquez sur un produit parmis la liste des articles associés.
            </p>
            <p class="step" data-focus=".editor">
                Vous pouvez alors acheter le produit selectionné ou bien le look entier.
            </p>
            <p class="step">
                Voilà tout ce que vous devez savoir pour utiliser Smart Personal Shopper.<br>
                Vous pouvez revoir ce tutoriel en cliquant sur le bouton ci-dessous.<br>
                Quant à moi j'apparaîtrait à d'autres endroits pour vou présenter les fonctionnalités avancées.<br>
                A bientôt !<br>
                <button type="button">Je veux revoir le tutoriel</button>
                <button type="button">A bientôt</button>
            </p>
        </div>
    </div>

    <div class="popup" data-category="dress-black">
        <h2>La robe noire</h2>
        <p>Impossible de ne pas vous en parler. Popularisée par Coco Chanel en 1926, la robe noire est devenue emblématique. La star des intemporels doit se choisir selon sa silhouette mais toujours dans une belle matière et une jolie texture. Choisissez-là aussi sexy, avec une taille marquée. Glamour et séduisante, elle peut se porter en soirée comme en journée, en hiver comme en été, à 20 ans comme à 50. Bref, LA robe à posséder, sans discussion possible.</p>
        <div class="products">
            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="plain-tshirt">
        <h2>Tshirt uni</h2>
        <p>Blanc, noir ou gris. Le t-shirt uni fluide doit vous mettre à l’aise et se marier avec l’intégralité de votre dressing. Donnez-vous une allure décontractée ou habillée, tendance ou très classique, boyish ou girly. Encore une fois, un tas de possibilités. C’est a vous de jouer !</p>
        <div class="products">
            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="vest-jean">
        <h2>Veste en jean</h2>
        <p>Multifonction encore ! Juxtaposée à un débardeur, nouée à la taille, la chemise en jean peut se porter de mille façons possibles. En denim brut ou bleu ciel, optez pour une jolie boutonnière, légèrement cintrée ou empruntez-là à votre petit-ami ou à un ami dans un style plus oversize, en retroussant vos manches pour ne pas trop noyer votre silhouette. Existe aussi en gris, noir et un peu destroy pour une tenue plus rock’n’roll.</p>
        <div class="products">
            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
        </div>
    </div>

    <div class="popup" data-category="total-white">
        <h2>Total look blanc</h2>
        <p>Des Suffragettes aux Boys Band, le total-look blanc est un incontournable. Ces dernières années, il a su s'imposer dans nos vestiaires autant l'hiver que l'été.</p>
        <div class="products">
            <img src="<?php echo get_site_url(); ?>/wp-content/plugins/personal-shopper-assistant/images/icons/loading.gif" />
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

<!--
<?php get_template_part('template-parts/parts/product-detail'); ?>


<div id="product-detail">
    
    <div class="name" data-name>BAG</div>
    <div class="photos">
        <div class="main"></div>
        <div class="composition" data-composition></div>
        <div class="others">
            <div class="photo"></div>
            <div class="photo"></div>
            <div class="photo"></div>
        </div>
    </div>

    <div class="price" data-price></div>
    <div class="stock">
        <p><span data-stock>5</span> pièces restantes</p>
    </div>

    <div class="origin" data-origin></div>

    <div class="controls">
        <button type="button" class="btn"><i class="fas fa-cart"></i>Acheter</button>
    </div>
</div>-->

<?php echo get_footer(); ?>