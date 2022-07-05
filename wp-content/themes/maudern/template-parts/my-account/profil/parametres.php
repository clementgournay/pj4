<?php
require_once 'init.php';
define('PAGE', 'parametres');
get_template_part('template-parts/my-account/parts/nav'); 
?>


<form class="woocommerce woocommerce-EditAccountForm edit-account" action="" method="post">
    
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active">
		<label for="account_birthdate">Nom d'affichage&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display" id="account_display"  value="" required>
    </p>
    <div class="clear"></div>
    
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active">
		<label for="account_email">Adresse de messagerie&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="" required>
    </p>
    <div class="clear"></div>
	
	<fieldset>
		<legend>Changement de mot de passe</legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current">Mot de passe actuel (laisser vide pour le conserver)</label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off">
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
	
	<p>
		<input type="hidden" id="save-account-details-nonce" name="save-account-details-nonce" value="563c396a2c"><input type="hidden" name="_wp_http_referer" value="/mon-compte/edit-account/">		<button type="submit" class="woocommerce-Button button" name="save_account_details" value="Enregistrer les modifications">Enregistrer les modifications</button>
		<input type="hidden" name="action" value="save_account_details">
	</p>

</form>