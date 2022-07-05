<?php
require_once 'init.php';
define('PAGE', 'mensurations');
get_template_part('template-parts/my-account/parts/nav'); 

$user = wp_get_current_user();

if (isset($_POST['size_cup'])) update_usermeta($user->ID, 'size_cup', $_POST['size_cup']);
if (isset($_POST['size_bra'])) update_usermeta($user->ID, 'size_bra', $_POST['size_bra']);
if (isset($_POST['size_top'])) update_usermeta($user->ID, 'size_top', $_POST['size_top']);
if (isset($_POST['size_shirt'])) update_usermeta($user->ID, 'size_shirt', $_POST['size_shirt']);
if (isset($_POST['size_dress'])) update_usermeta($user->ID, 'size_dress', $_POST['size_dress']);
if (isset($_POST['size_pants'])) update_usermeta($user->ID, 'size_pants', $_POST['size_pants']);
if (isset($_POST['size_shoes'])) update_usermeta($user->ID, 'size_shoes', $_POST['size_shoes']);

?>


<div class="menu-section">
    <form class="woocommerce-EditAccountForm edit-account mensurations" action="<?php echo site_url().'/mon-compte/profil/mensurations/'; ?>" method="post">
        <fieldset>
            <legend>Haut</legend>

            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/haut.png">
            </div>
            <div class="right part">
                <p class="woocommerce-form-row woocommerce-form-row--bra form-row form-row-first">
                    <?php 
                    $sizes = ['AA', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
                    $user_size = get_user_meta($user->ID, 'size_cup', true); ?>
                    <label for="account_cup">Taille de bonnet&nbsp;</label>
                    <select class="woocommerce-Select select" name="size_cup" id="account_cup">
                        <?php 
                            foreach($sizes as $size) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                            }
                        ?>
                    </select>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--bra form-row form-row-last">
                    <?php 
                    $sizes = [
                        '26' => '49-52cm',
                        '28' => '53-56cm',
                        '30' => '57-60cm',
                        '32' => '61-64cm',
                        '34' => '65-68cm',
                        '36' => '69-72cm',
                        '38' => '73-76cm',
                        '40' => '77-80cm',
                        '42' => '81-84cm',
                        '44' => '85-88cm',
                        '46' => '89-92cm',
                        '48' => '93-96cm',
                        '50' => '97-100cm',
                        '52' => '101-104cm',
                        '54' => '105-108cm',
                        '56' => '109-112cm',
                        '58' => '113-116cm',
                        '60' => '117-120cm',
                        '62' => '121-124cm',
                        '64' => '125-128cm'
                    ];
                    $user_size = get_user_meta($user->ID, 'size_bra', true); ?>
                    <label for="account_bra">Tour de poitrine sous les seins&nbsp;</label>
                    <select class="woocommerce-Select select" name="size_bra" id="account_bra">
                        <?php 
                            foreach($sizes as $size=>$desc) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'('.$desc.')</option>';
                            }
                        ?>
                    </select>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--bra form-row form-row-first">
                    <?php
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'];
                    $user_size = get_user_meta($user->ID, 'size_top', true); ?>
                    <label for="account_bra">Taille pulls, tee-shirts, sweats, polos&nbsp;</label>
                    <select class="woocommerce-Select select" name="size_top" id="account_top">
                        <?php 
                            foreach($sizes as $size) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                            }
                        ?>
                    </select>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--chemise form-row form-row-last">
                    <?php
                    $sizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'];
                    $user_size = get_user_meta($user->ID, 'size_shirt', true); ?>
                    <label for="account_chemise">Taille de chemise&nbsp;</label>
                    <select class="woocommerce-Select select" name="size_shirt" id="account_chemise">
                        <?php 
                            foreach($sizes as $size) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                            }
                        ?>
                    </select>
                </p>
            </div>
        </fieldset>


        <fieldset>
            <legend>Robe</legend>
            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/dress.png">
            </div>
            <div class="right part">
            <p class="woocommerce-form-row woocommerce-form-row--dress form-row form-row-first">
                <?php
                $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'];
                $user_size = get_user_meta($user->ID, 'size_dress', true); ?>
                <label for="account_dress">Taille&nbsp;</label>
                <select class="woocommerce-Select select" name="size_dress" id="account_dress">
                    <?php 
                        foreach($sizes as $size) {
                            $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                            echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                        }
                    ?>
                </select>
            </p>
            </div>
        </fieldset>

        <fieldset>
            <legend>Bas</legend>
            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/bas.png">
            </div>
            <div class="right part">
                <p class="woocommerce-form-row woocommerce-form-row--pants form-row form-row-first">
                <?php
                    $sizes = ['36', '38', '40', '42', '44', '46', '48', '50'];
                    $user_size = get_user_meta($user->ID, 'size_pants', true); ?>
                    <label for="account_pants">Pantalon&nbsp;</label>
                    <select class="woocommerce-Select select" name="size_pants" id="account_pants">
                        <?php 
                            foreach($sizes as $size) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                            }
                        ?>
                    </select>
                </p>
            </div>
        </fieldset>

        <fieldset class="clear">
            <legend>Chaussures</legend>
            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/chaussures.png">
            </div>
            <div class="right part">
                <p class="woocommerce-form-row woocommerce-form-row--shoes form-row form-row-first">
                    <?php
                    $sizes = ['30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50'];
                    $user_size = get_user_meta($user->ID, 'size_shoes', true); ?>
                    <label for="account_shoes">Pointure&nbsp;</label>
                    <select class="woocommerce-Select select" name="size_shoes" id="account_shoes">
                        <?php 
                            foreach($sizes as $size) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                            }
                        ?>
                    </select>
                </p>
            </div>
        </fieldset>

        <p>
            <input type="hidden" name="_wp_http_referer" value="/mon-compte/edit-account/">
            <button type="submit" class="woocommerce-Button button" name="save_account_details" value="Enregistrer les modifications">Enregistrer les modifications</button>
            <input type="hidden" name="action" value="save_account_details">
        </p>

    </form>
</div>