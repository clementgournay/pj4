<?php
/**
 * Lost password form
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<form method="post" class="lost_reset_password">

	<?php if('lost_password' == $args['form']) : ?>

		<p><?php echo apply_filters('woocommerce_lost_password_message', esc_html__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'cosmeli')); ?></p>

		<p class="form-row form-row-first"><label for="user_login"><?php esc_html_e('Username or email', 'cosmeli'); ?></label> <input class="input-text" type="text" name="user_login" id="user_login" /></p>

	<?php else : ?>

		<p><?php echo apply_filters('woocommerce_reset_password_message', esc_html__('Enter a new password below.', 'cosmeli')); ?></p>

		<p class="form-row form-row-first">
			<label for="password_1"><?php esc_html_e('New password', 'cosmeli'); ?> <span class="required">*</span></label>
			<input type="password" class="input-text" name="password_1" id="password_1" />
		</p>
		<p class="form-row form-row-last">
			<label for="password_2"><?php esc_html_e('Re-enter new password', 'cosmeli'); ?> <span class="required">*</span></label>
			<input type="password" class="input-text" name="password_2" id="password_2" />
		</p>

		<input type="hidden" name="reset_key" value="<?php echo isset($args['key']) ? $args['key'] : ''; ?>" />
		<input type="hidden" name="reset_login" value="<?php echo isset($args['login']) ? $args['login'] : ''; ?>" />

	<?php endif; ?>

	<div class="clear"></div>

	<p class="form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<input type="submit" class="button" value="<?php echo 'lost_password' == $args['form'] ? esc_html__('Reset Password', 'cosmeli') : esc_html__('Save', 'cosmeli'); ?>" />
	</p>

	<?php wp_nonce_field($args['form']); ?>

</form>
