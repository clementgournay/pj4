<?php

if (!isset($_GET['user_id'])) header('Location: ./admin.php?page=manage_clients');
$userID = $_GET['user_id'];
define('USER_ID', $userID);
$user = get_userdata($_GET['user_id']);

if (isset($_POST['size_cup'])) update_usermeta($user->ID, 'size_cup', $_POST['size_cup']);
if (isset($_POST['size_bra'])) update_usermeta($user->ID, 'size_bra', $_POST['size_bra']);
if (isset($_POST['size_top'])) update_usermeta($user->ID, 'size_top', $_POST['size_top']);
if (isset($_POST['size_shirt'])) update_usermeta($user->ID, 'size_shirt', $_POST['size_shirt']);
if (isset($_POST['size_dress'])) update_usermeta($user->ID, 'size_dress', $_POST['size_dress']);
if (isset($_POST['size_pants'])) update_usermeta($user->ID, 'size_pants', $_POST['size_pants']);
if (isset($_POST['size_shoes'])) update_usermeta($user->ID, 'size_shoes', $_POST['size_shoes']);

?>


<div class="manage-clients measurement">
    <h1>Mensurations de <?php echo get_user_meta($userID, 'firstname', true); ?> <?php echo get_user_meta($userID, 'lastname', true); ?></h1>
    <p class="subtitle">(<?php echo $user->user_login; ?>)</p>
    <form class="woocommerce-EditAccountForm edit-account mensurations" action="./admin.php?page=manage_clients&feature=measurement&user_id=<?php echo $user->ID; ?>&saved=true" method="post">
        <fieldset>
            <legend>Haut</legend>

            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/haut.png">
            </div>
            <div class="right part table">
                <p class="tr">
                    <?php 
                    $sizes = ['AA', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
                    $user_size = get_user_meta($user->ID, 'size_cup', true); ?>
                    <div class="td">
                        <label for="account_cup">Taille de bonnet&nbsp;</label>
                    </div>
                    <div class="td">
                        <select name="size_cup" id="account_cup">
                            <?php 
                                foreach($sizes as $size) {
                                    $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </p>
                <p class="tr">
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
                    <div class="td">
                        <label for="account_bra">Tour de poitrine sous les seins&nbsp;</label>
                    </div>
                    <div class="td">
                        <select name="size_bra" id="account_bra">
                            <?php 
                                foreach($sizes as $size=>$desc) {
                                    $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'('.$desc.')</option>';
                                }
                            ?>
                        </select>
                    </div>
                </p>
                <p class="tr">
                    <?php
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'];
                    $user_size = get_user_meta($user->ID, 'size_top', true); ?>
                    <div class="td">
                        <label for="account_bra">Taille pulls, tee-shirts, sweats, polos&nbsp;</label>
                    </div>
                    <div class="td">
                        <select name="size_top" id="account_top">
                            <?php 
                                foreach($sizes as $size) {
                                    $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </p>
                <p class="tr">
                    <?php
                    $sizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46'];
                    $user_size = get_user_meta($user->ID, 'size_shirt', true); ?>
                    <div class="td">
                        <label for="account_chemise">Taille de chemise&nbsp;</label>
                    </div>
                    <div class="td">
                        <select name="size_shirt" id="account_chemise">
                            <?php 
                                foreach($sizes as $size) {
                                    $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </p>
            </div>
        </fieldset>


        <fieldset>
            <legend>Robe</legend>
            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/dress.png">
            </div>
            <div class="right part table">
            <p class="tr">
                <?php
                $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'];
                $user_size = get_user_meta($user->ID, 'size_dress', true); ?>
                <div class="td">
                    <label for="account_dress">Taille&nbsp;</label>
                </div>
                <div class="td">
                    <select name="size_dress" id="account_dress">
                        <?php 
                            foreach($sizes as $size) {
                                $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </p>
            </div>
        </fieldset>

        <fieldset>
            <legend>Bas</legend>
            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/bas.png">
            </div>
            <div class="right part table">
                <p class="tr">
                <?php
                    $sizes = ['36', '38', '40', '42', '44', '46', '48', '50'];
                    $user_size = get_user_meta($user->ID, 'size_pants', true); ?>
                    <div class="td">
                        <label for="account_pants">Pantalon&nbsp;</label>
                    </div>
                    <div class="td">
                        <select name="size_pants" id="account_pants">
                            <?php 
                                foreach($sizes as $size) {
                                    $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </p>
            </div>
        </fieldset>

        <fieldset class="clear">
            <legend>Chaussures</legend>
            <div class="left part">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/my-account/body-parts/chaussures.png">
            </div>
            <div class="right part table">
                <p class="tr">
                    <?php
                    $sizes = ['30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50'];
                    $user_size = get_user_meta($user->ID, 'size_shoes', true); ?>
                    <div class="td">
                        <label for="account_shoes">Pointure&nbsp;</label>
                    </div>
                    <div class="td">
                        <select name="size_shoes" id="account_shoes">
                            <?php 
                                foreach($sizes as $size) {
                                    $selectedSTR =  ($user_size == $size) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selectedSTR.'>'.$size.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </p>
            </div>
        </fieldset>

        <div class="controls">
            <button type="submit" class="btn save" name="save_account_details" value="Enregistrer les modifications">Enregistrer les modifications</button>
        </div>

    </form>

    <div class="modal" id="save-success">
        <div class="window">
            <div class="header">
                <span>Sauvegarde réussie</span>
            </div>
            <div class="body">
                <p>La sauvegarde a été effectuée correctement.</p>
            </div>
            <div class="footer">
                <button typ="button" class="btn btn-primary close">OK</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'parts/client-actions.php'; ?>