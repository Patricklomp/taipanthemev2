<?php
/**
 * Customizer settings for what sits outside page content: the footer and
 * where the contact form delivers. Appearance → Customize → Taipan.
 * The header is the "primary" menu (Appearance → Menus).
 */

defined( 'ABSPATH' ) || exit;

function taipan_defaults() {
	return array(
		'company_name'           => 'Taipan OÜ',
		'contact_email'          => 'anu@saarlane.ee',
		'contact_phone'          => '+372 527 3737',
		'footer_location'        => 'Saaremaa · Kuressaare',
		'contact_footer_tagline' => 'Aitame Teie ideel küpseks saada!',
		'form_recipient'         => '',
	);
}

/** A theme setting; an emptied field falls back to its default. */
function taipan_mod( $key ) {
	$defaults = taipan_defaults();
	$value    = get_theme_mod( $key, '' );
	return '' === $value ? ( $defaults[ $key ] ?? '' ) : $value;
}

function taipan_customize_register( $wp_customize ) {
	$defaults = taipan_defaults();

	$wp_customize->add_section( 'taipan', array(
		'title'    => 'Taipan',
		'priority' => 30,
	) );

	$fields = array(
		'company_name'           => array( 'Ettevõtte nimi (jalus)', 'text' ),
		'contact_email'          => array( 'E-post (jalus)', 'email' ),
		'contact_phone'          => array( 'Telefon (jalus)', 'text' ),
		'footer_location'        => array( 'Asukoht (jalus)', 'text' ),
		'contact_footer_tagline' => array( 'Jaluse lisatekst kontaktilehel', 'text' ),
		'form_recipient'         => array( 'Kontaktivormi saaja (tühi = jaluse e-post)', 'email' ),
	);

	foreach ( $fields as $key => list( $label, $type ) ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => 'email' === $type ? 'sanitize_email' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $label,
			'section' => 'taipan',
			'type'    => $type,
		) );
	}
}
add_action( 'customize_register', 'taipan_customize_register' );
