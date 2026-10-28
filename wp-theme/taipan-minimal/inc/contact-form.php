<?php
/**
 * The built-in contact form: the [taipan_contact_form] shortcode and its submit
 * handler, which posts to admin-post.php, mails the message with wp_mail() and
 * redirects back to #kontakt with a status.
 *
 * There is no nonce on purpose: the form is public and anonymous, so a forged
 * submission gains nothing, and a nonce would expire inside cached pages.
 * Bots are filtered with a honeypot field instead.
 */

defined( 'ABSPATH' ) || exit;

function taipan_handle_contact() {
	$back = isset( $_POST['redirect'] ) ? esc_url_raw( wp_unslash( $_POST['redirect'] ) ) : '';
	$back = remove_query_arg( 'kontakt', wp_validate_redirect( $back, home_url( '/' ) ) );

	$done = function ( $status ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'kontakt', $status, $back ) . '#kontakt' );
		exit;
	};

	// Humans never see the honeypot; pretend success so bots don't retry.
	if ( ! empty( $_POST['website'] ) ) {
		$done( 'sent' );
	}

	$field = function ( $key, $sanitize = 'sanitize_text_field' ) {
		return isset( $_POST[ $key ] ) ? trim( $sanitize( wp_unslash( $_POST[ $key ] ) ) ) : '';
	};

	$name    = $field( 'name' );
	$email   = $field( 'email', 'sanitize_email' );
	$subject = $field( 'subject' );
	$message = $field( 'message', 'sanitize_textarea_field' );

	if ( '' === $name || ! is_email( $email ) ) {
		$done( 'invalid' );
	}

	$to   = is_email( taipan_mod( 'form_recipient' ) ) ? taipan_mod( 'form_recipient' ) : taipan_mod( 'contact_email' );
	$body = "Nimi: $name\nEmail: $email\nTeema: $subject\n\n$message\n";

	$sent = wp_mail(
		$to,
		sprintf( '[%s] %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), '' !== $subject ? $subject : 'Sõnum kodulehelt' ),
		$body,
		array( sprintf( 'Reply-To: %s <%s>', $name, $email ) )
	);

	$done( $sent ? 'sent' : 'error' );
}
add_action( 'admin_post_nopriv_taipan_contact', 'taipan_handle_contact' );
add_action( 'admin_post_taipan_contact', 'taipan_handle_contact' );

/** Renders the form wherever the shortcode is placed (a Shortcode block on the Kontakt page). */
function taipan_contact_form_shortcode() {
	ob_start();
	get_template_part( 'template-parts/contact-form' );
	return ob_get_clean();
}
add_shortcode( 'taipan_contact_form', 'taipan_contact_form_shortcode' );
