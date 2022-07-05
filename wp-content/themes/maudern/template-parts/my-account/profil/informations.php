<?php 
require_once 'init.php';
define('PAGE', 'informations');
get_template_part('template-parts/my-account/parts/nav'); 

$user = wp_get_current_user();
$errors = [];

if (isset($_POST['card_id'])) update_usermeta($user->ID, 'card_id', $_POST['card_id']);
if (isset($_POST['firstname'])) update_usermeta($user->ID, 'firstname', $_POST['firstname']);
if (isset($_POST['lastname'])) update_usermeta($user->ID, 'lastname', $_POST['lastname']);
if (isset($_POST['birthdate'])) update_usermeta($user->ID, 'birthdate', $_POST['birthdate']);
if (isset($_POST['address'])) update_usermeta($user->ID, 'address', $_POST['address']);
if (isset($_POST['city'])) update_usermeta($user->ID, 'city', $_POST['city']);
if (isset($_POST['postal_code'])) update_usermeta($user->ID, 'postal_code', $_POST['postal_code']);
if (isset($_POST['phone'])) update_usermeta($user->ID, 'phone', $_POST['phone']);

if (isset($_POST['password_current']) && $_POST['password_current'] !== '') {
	if (!wp_check_password($_POST['password_current'], $user->user_pass, $user->ID)) {
		$errors['password_current'] = 'Le mot de passe entré est incorrect';
	} else {
		if (isset($_POST['password_1']) && $_POST['password_1'] !== '' && isset($_POST['password_2']) && $_POST['password_2'] !== '') {
			$pass1 = $_POST['password_1'];
			$pass2 = $_POST['password_2'];
			$errors['password'] = [];
			if ($pass1 !== $pass2) {
				array_push($errors['password'], 'Les mots de passe ne correspondent pas.');
			} else {
				if (strlength($pass1) < 6 || strlength($pass1) > 20) {
					array_push($errors['password'], 'Le mot de passe doit contenir entre 6 et 20 caractères.');
				}
			}
		}
	}
}
?>

<div class="menu-section informations">
	<form class="woocommerce-EditAccountForm edit-account" action="<?php echo site_url().'/mon-compte/profil/informations/'; ?>" method="post">

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="account_first_name">Prénom&nbsp;</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="firstname" id="account_first_name" autocomplete="given-name" value="<?php echo get_user_meta($user->ID, 'firstname', true); ?>">
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last clearfix">
			<label for="account_last_name">Nom&nbsp;</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="lastname" id="account_last_name" autocomplete="family-name" value="<?php echo get_user_meta($user->ID, 'lastname', true); ?>">
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
			<label for="account_display">Nom d'affichage&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="display_name" id="account_display"  value="<?php echo $user->display_name; ?>" required>
		</p>
		
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
			<label for="account_email">Adresse de messagerie&nbsp;<span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="email" id="account_email" autocomplete="email" value="<?php echo $user->user_email; ?>" required>
		</p>
		
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
			<label for="account_birthdate">Date de naissance&nbsp;</label>
			<input type="date" class="woocommerce-Input woocommerce-Input--date input-date" name="birthdate" id="account_birthdate"  value="<?php echo get_user_meta($user->ID, 'birthdate', true); ?>">
		</p>
		
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
			<label for="account_address">Adresse&nbsp;<span class="required"></span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="address" id="account_address" value="<?php echo get_user_meta($user->ID, 'address', true); ?>">
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--cp form-row form-row-first clearfix">
			<label for="account_cp">Code Postal&nbsp;</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="postal_code" id="account_cp" autocomplete="postal-code" value="<?php echo get_user_meta($user->ID, 'postal_code', true); ?>">
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--city form-row form-row-last">
			<label for="account_city">Ville&nbsp;</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="city" id="account_city" autocomplete="city" value="<?php echo get_user_meta($user->ID, 'city', true); ?>">
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
			<label for="account_tel">Téléphone&nbsp;</label>
			<input type="tel" class="woocommerce-Input woocommerce-Input--tel input-tel" name="phone" id="account_tel" value="<?php echo get_user_meta($user->ID, 'phone', true); ?>">
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
			<label for="client_id">Numéro de fidélité&nbsp;</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--tel input-tel" name="card_id" id="card_id" value="<?php echo get_user_meta($user->ID, 'card_id', true); ?>">
		</p>

		<fieldset>
			<legend>Changement de mot de passe</legend>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_current">Mot de passe actuel (laisser vide pour le conserver)</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off">
				<?php if (isset($errors['password_current'])) echo '<div class="error">'.$errors['password_current'].'</div>'; ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_1">Nouveau mot de passe (laisser vide pour conserver l’actuel)</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off">
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_2">Confirmer le nouveau mot de passe</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off">
			</p>
		</fieldset>
		<div class="clear"></div>

		<p class="informations-legales">
			<a href="<?php echo site_url(); ?>/mon-compte/profil/informations-legales">Informations légales</a>
		</p>
		
		<p>
			<input type="hidden" name="_wp_http_referer" value="<?php echo get_site_url(); ?>/mon-compte/edit-account/">		
			<button type="submit" class="woocommerce-Button button" name="save_account_details" value="Enregistrer les modifications">Enregistrer les modifications</button>
			<input type="hidden" name="action" value="save_account_details">
		</p>

	</form>
</div>