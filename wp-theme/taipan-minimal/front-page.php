<?php
/**
 * Homepage. A static front page shows its own block content full width (start
 * from the "Avaleht" pattern); "latest posts" falls back to the blog listing.
 */

if ( 'page' !== get_option( 'show_on_front' ) ) {
	require get_template_directory() . '/index.php';
	return;
}

taipan_render_sections();
