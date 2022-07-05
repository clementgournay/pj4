<?php

$query = new WC_Order_Query();
$query->set('customer', USER_ID);
$orders = $query->get_orders();
$price = 0;
foreach($orders as $order) {
    $price += $order->get_total();
}

$suggested_looks = get_user_meta(USER_ID, 'suggested_looks', true);
if ($suggested_looks === '') $suggested_looks = [];

$suggested_looks = array_reverse($suggested_looks);

$messages = get_user_meta(USER_ID, 'messages', true);
if ($messages === '') $messages = [];

$messages = array_reverse($messages);

?>

<div class="dashboard">

    <div class="user-info">
        <input type="hidden" class="city" value="<?php echo get_user_meta(USER_ID, 'city', true); ?>">
    </div>
    <div class="background left"></div>
    <div class="background right"></div>
    <div class="col">

        <div class="card">
            <div class="header">
                <h3>Mon profil</h3>
            </div>
            <div class="body information">
                <div class="table">
                    <div class="td">
                        <div class="profile-pic" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/my-account/profile-pic.jpg)"></div>
                    </div>
                    <div class="td">
                        <?php if (get_user_meta(USER_ID, 'firstname', true) !== ''): ?>
                            <p class="name"><?php echo get_user_meta(USER_ID, 'firstname', true).' '.get_user_meta(USER_ID, 'lastname', true); ?></p>
                        <?php endif; ?>
                        <?php if (get_user_meta(USER_ID, 'address', true) !== ''): ?>
                            <p class="address">
                                <?php echo get_user_meta(USER_ID, 'address', true); ?><br>
                                <?php echo get_user_meta(USER_ID, 'postal_code', true).' '.get_user_meta(USER_ID, 'city', true); ?>
                            </p>
                        <?php endif; ?>
                        <p class="email">
                            <?php echo $user->user_email; ?>
                        </p>
                        <?php if (get_user_meta(USER_ID, 'phone', true) !== ''): ?>
                            <p class="phone">
                                <?php echo get_user_meta(USER_ID, 'phone', true); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="meteo">
                    <h4>Météo locale</h4>
                    <div class="table">
                        <div class="td icon-cont">
                            <img data-weather-icon alt="meteo">
                        </div>
                        <div class="td">
                            <p class="temp"><span data-weather-temp></span> °C</p>
                            <p data-weather-desc></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <a class="btn" href="<?php echo MY_ACCOUNT_URL ?>profil/informations">Modifier les informations</a>
            </div>
        </div>

        <div class="card my-messages">
            <div class="header">
                <h3>Mes messages</h3>
            </div>
            <div class="body messages list-button">
                <?php 
                    if (count($messages) === 0) {
                        echo '<p class="no-message">Aucun message pour le moment.</p>';
                    } else {
                        $count = 0;
                        foreach($messages as $message) {
                            if ($count < 5) {
                                echo '<a href="'.MY_ACCOUNT_URL.'/dressing/looks?look='.$message->look.'" class="item">
                                    <b>'.$message->text.'</b>
                                </a>';
                                $count++;
                            }
                        }
                    }
                ?>
            </div>
            <div class="footer">
                <a href="#" class="see-messages">Voir tous les messages</a>
            </div>
        </div>

        <div class="card">
            <div class="header">
                <h3>Activités récentes</h3>
            </div>
            <div class="body feed">
                <div class="item">
                    <div class="date">11 Novembre</div>
                    <div class="message">Votre personal shopper vous a proposé un <a href="javascript: void(0)">nouveau look</a>.</div>
                </div>
                <div class="item">
                    <div class="date">8 Novembre</div>
                    <div class="message">Vous avez réservé une privatisation pour le 17 Novembre pour essayer <a href="javascript: void(0)">5 articles.</a></div>
                </div>
                <div class="item">
                    <div class="date">2 Novembre</div>
                    <div class="message">Votre réclamation a été pris en compte. Vous pouvez venir échanger votre article en boutique jusqu'au 28/12/2021.</div>
                </div>
                <div class="item">
                    <div class="date">30 Octobre</div>
                    <div class="message">Vous avez fait une réclamation concernant l'article <a href="javascript: void(0)">MANTEAU</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
    
        <div class="card my-looks">
            <div class="header">
                <h3>Mes derniers looks</h3>
            </div>
            <div class="body looks">
                <?php
                    if (count($suggested_looks) === 0) {
                        echo '<p>Aucun look suggéré pour le moment.</p>';
                    } else {
                        $count = 0;
                        foreach($suggested_looks as $look) {
                            if ($count < 5)  {
                                $products = explode('-', $look->products);
                                echo '<div class="look" data-look="'.$look->products.'">';
                                    foreach($products as $productID) {
                                        $product = wc_get_product($productID);
                                        echo '<div class="product">
                                            <div class="image">'.$product->get_image().'</div>
                                        </div>';
                                    }
                                echo '<div class="desc"><span>Voir le look</span></div>';
                                echo '</div>';
                            }
                            $count++;

                        }
                    }

                ?>
            </div>
            <div class="footer">
                <a href="#" class="see-looks">Voir tous mes looks</a>
            </div>
        </div>

        <div class="card loyalty">
            <div class="header">
                <h3>Mon baromètre fidelité</h3>
            </div>
            <div class="body">
                <p>Vous êtes actuellement <span class="rank silver">SILVER</span></p>
                <div class="barometer">
                    <span class="score">3/5</span>
                    <div class="half-circle">
                        <div class="hiding-cursor"></div>
                    </div>
                </div>
                <p>Encore 2 badges pour devenir <span class="rank gold">GOLD</span></p>
                <div class="badges">
                    <div class="badge visit complete" title="Venez 3 fois en magasin"></div>
                    <div class="badge shop complete" title="Achetez 3 articles"></div>
                    <div class="badge referal complete" title="Parrainez 5 amis"></div>
                    <div class="badge booking" title="Planifier une privatisation"></div>
                    <div class="badge share" title="Partager 2 looks"></div>
                </div>
                <a class="btn contest" href="<?php echo MY_ACCOUNT_URL; ?>dressing/promotions/">
                    <div class="outer">
                        <div class="inner">
                            <i class="fa fa-gift"></i>
                            <span>Promotions</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="footer">
                <a class="#">Voir les avantages des programmes</a>
            </div>
        </div>

        <div class="card my-advices">
            <div class="header">
                <h3>Mes conseils</h3>
            </div>
            <div class="body advices list-button">
                <a href="#" class="item">
                    <span>Comment accorder votre pull rouge</span>
                </a>
                <a href="#" class="item">
                    <span>Les motifs tendance de cette année</span>
                </a>
                <a href="#" class="item">
                    <span>Comment lire les étiquettes pour porter vos articles plus longtemps</span>
                </a>
            </div>
            <div class="footer">
                <a href="#" class="see-advices">Voir tous les conseils</a>
            </div>
        </div>

    </div>
    <div class="col">
    
        <div class="card orders no-padding">
            <div class="table">
                <div class="td label">
                    <span>Mes achats</span>
                    <p class="desc">(affichage dématerialisé)</p>
                    <a class="link" href="<?php echo MY_ACCOUNT_URL ?>dressing/achats">Voir le détail</a>
                </div>
                <div class="td price">
                    <span><?php echo $price; ?>€</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="header">
                <h3>Mes derniers événements</h3>
            </div>
            <div class="body">
                <p>Retrouvez ici vos derniers événements tels que la dernière visite en boutique ou vos derniers achats.</p>
            </div>  
        </div>
        
        <div class="card">
            <div class="header">
                <h3>Actualités</h3>
            </div>
            <div class="body feed">
                <div class="item">
                    <div class="date">25 Novembre</div>
                    <div class="message">Une <a href="#">nouvelle collection</a> vient d'arriver en boutique.</div>
                </div>
                <div class="item">
                    <div class="date">23 Novembre</div>
                    <div class="message">Le nouvel article "<a href="#">L’attention au détail</a>" vient d'être publié.</div>
                </div>
                <div class="item">
                    <div class="date">15 Novembre</div>
                    <div class="message">Un <a href="#">nouveau look</a> vient d'être publié</div>
                </div>
                <div class="item">
                    <div class="date">8 Novembre</div>
                    <div class="message">Nous sommes en solde du 13 au 20 Novembre ! <br><a href="#">Trouver une boutique près de chez vous.</a></div>
                </div>
                <div class="item">
                    <div class="date">30 Octobre</div>
                    <div class="message">Une <a href="#">nouvelle collection</a> vient d'arriver en boutique.</div>
                </div>
                <div class="item">
                    <div class="date">23 Octobre</div>
                    <div class="message">Le nouvel article "<a href="#">Le total look: silhouette d’une couleur/d’un ton</a>" vient d'être publié.</div>
                </div>
                <div class="item">
                    <div class="date">15 Octobre</div>
                    <div class="message">Un <a href="#">nouveau look</a> vient d'être publié</div>
                </div>
                <div class="item">
                    <div class="date">8 Octobre</div>
                    <div class="message">Une nouvelle boutique vient d'ouvrir ses portes à Nice ! <br><a href="#">Trouver une boutique près de chez vous.</a></div>
                </div>
            </div>
        </div>
    </div>

</>