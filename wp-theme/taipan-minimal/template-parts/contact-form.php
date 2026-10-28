<?php
/**
 * The built-in contact form, placed with the [taipan_contact_form] shortcode.
 * Submissions are handled in inc/contact-form.php.
 */

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display-only status flag.
$status   = isset( $_GET['kontakt'] ) ? sanitize_key( $_GET['kontakt'] ) : '';
$messages = array(
	'sent'    => 'Aitäh! Sõnum on saadetud.',
	'invalid' => 'Palun sisesta nimi ja korrektne e-posti aadress.',
	'error'   => 'Sõnumi saatmine ebaõnnestus. Palun kirjuta otse aadressil ' . taipan_mod( 'contact_email' ) . '.',
);
?>
<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="taipan_contact">
	<input type="hidden" name="redirect" value="<?php echo esc_url( get_permalink() ); ?>">
	<p class="hp-field" aria-hidden="true">
		<label>Veebileht <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
	</p>
	<div class="row">
		<label class="field">
			<span>Nimi</span>
			<input class="input" type="text" name="name" autocomplete="name" required>
		</label>
		<label class="field">
			<span>Email</span>
			<input class="input" type="email" name="email" autocomplete="email" required>
		</label>
	</div>
	<label class="field">
		<span>Teema</span>
		<input class="input" type="text" name="subject">
	</label>
	<label class="field">
		<span>Sõnum</span>
		<textarea class="input" name="message" rows="6"></textarea>
	</label>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Saada</button>
		<?php if ( isset( $messages[ $status ] ) ) : ?>
			<span class="form-status<?php echo 'sent' === $status ? '' : ' is-error'; ?>" role="status"><?php echo esc_html( $messages[ $status ] ); ?></span>
		<?php endif; ?>
	</div>
</form>
