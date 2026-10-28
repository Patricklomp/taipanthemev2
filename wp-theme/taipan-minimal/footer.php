<?php
/**
 * Site footer. On the contact page the Customizer's footer tagline follows the company name.
 */

$tagline = taipan_is_contact() ? taipan_mod( 'contact_footer_tagline' ) : '';
$email   = taipan_mod( 'contact_email' );
$phone   = taipan_mod( 'contact_phone' );
?>
<div class="container">
	<footer class="site-footer">
		<span>© <?php echo esc_html( taipan_mod( 'company_name' ) . ( $tagline ? " · $tagline" : '' ) ); ?></span>
		<span class="footer-contact">
			<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
			<a href="<?php echo esc_url( taipan_tel_href( $phone ) ); ?>" class="tel"><?php echo esc_html( $phone ); ?></a>
		</span>
		<span><?php echo esc_html( taipan_mod( 'footer_location' ) ); ?></span>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
