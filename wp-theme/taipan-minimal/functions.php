<?php
/**
 * Taipan Minimal: theme setup, assets and small template helpers.
 */

defined( 'ABSPATH' ) || exit;

const TAIPAN_VERSION   = '1.0.2';
const TAIPAN_FONTS_URL = 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Lora:ital,wght@0,400;0,600;1,400&display=swap';

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/contact-form.php';

function taipan_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( TAIPAN_FONTS_URL, 'assets/css/ds.css', 'assets/css/site.css', 'assets/css/wp.css', 'assets/css/editor.css' ) );

	register_nav_menus( array( 'primary' => 'Päise menüü' ) );
}
add_action( 'after_setup_theme', 'taipan_setup' );

function taipan_assets() {
	$uri = get_template_directory_uri() . '/assets/css';

	wp_enqueue_style( 'taipan-fonts', TAIPAN_FONTS_URL, array(), null );
	wp_enqueue_style( 'taipan-ds', "$uri/ds.css", array( 'taipan-fonts' ), TAIPAN_VERSION );
	wp_enqueue_style( 'taipan-site', "$uri/site.css", array( 'taipan-ds' ), TAIPAN_VERSION );
	wp_enqueue_style( 'taipan-wp', "$uri/wp.css", array( 'taipan-site' ), TAIPAN_VERSION );

	wp_enqueue_script( 'taipan-nav', get_template_directory_uri() . '/assets/js/nav.js', array(), TAIPAN_VERSION, array( 'strategy' => 'defer' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'taipan_assets' );

/** Preconnect to Google Fonts so the two families arrive sooner. */
function taipan_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'taipan_resource_hints', 10, 2 );

/**
 * Block styles and the pattern category for the homepage and Kontakt layouts
 * (patterns/*.php, registered automatically).
 */
function taipan_block_styles() {
	register_block_style( 'core/image', array( 'name' => 'plate', 'label' => 'Raamitud' ) );
	register_block_style( 'core/button', array( 'name' => 'ghost', 'label' => 'Tekstinupp' ) );
	register_block_pattern_category( 'taipan', array( 'label' => 'Taipan' ) );
}
add_action( 'init', 'taipan_block_styles' );

function taipan_tel_href( $phone ) {
	return 'tel:' . preg_replace( '/[^\d+]/', '', $phone );
}

function taipan_is_contact() {
	return is_page( 'kontakt' );
}

/**
 * The header menu's top-level items: the "primary" menu (Appearance → Menus),
 * or the live site's pages when no menu is assigned yet.
 */
function taipan_nav_items() {
	$locations = get_nav_menu_locations();
	$items     = empty( $locations['primary'] ) ? false : wp_get_nav_menu_items( $locations['primary'] );

	if ( $items ) {
		return array_filter( $items, function ( $item ) {
			return ! (int) $item->menu_item_parent;
		} );
	}

	$page = function ( $slug, $title, $classes = array() ) {
		$post = get_page_by_path( $slug );
		return (object) array(
			'url'       => $post ? get_permalink( $post ) : home_url( "/$slug/" ),
			'title'     => $title,
			'type'      => 'post_type',
			'object_id' => $post ? $post->ID : 0,
			'classes'   => $classes,
		);
	};

	return array(
		$page( 'giiditeenused-saaremaal', 'Giiditeenused' ),
		$page( 'giidituurid', 'Giidituurid' ),
		$page( 'teenused', 'Nõustamine' ),
		$page( 'kontakt', 'Saame tuttavaks!', array( 'nav-cta' ) ),
	);
}

/**
 * Prints the header menu. Items get aria-current on their own page; an item
 * with the CSS class "nav-cta" (Menus → Screen Options → CSS Classes) is drawn
 * as the outlined button and stays visible in the mobile header.
 */
function taipan_nav_links() {
	$links = '';
	$cta   = '';

	foreach ( taipan_nav_items() as $item ) {
		$current = 'post_type' === $item->type && (int) $item->object_id && (int) $item->object_id === get_queried_object_id() && is_singular();
		$is_cta  = in_array( 'nav-cta', (array) $item->classes, true );
		$link    = sprintf(
			'<a class="%s" href="%s"%s>%s</a>',
			$is_cta ? 'btn btn-primary' : 'navlink',
			esc_url( $item->url ),
			$current ? ' aria-current="page"' : '',
			esc_html( $item->title )
		);

		if ( $is_cta ) {
			$cta .= $link;
		} else {
			$links .= $link;
		}
	}

	if ( $links ) {
		echo '<div id="site-nav-menu" class="site-nav-menu">' . $links . '</div>';
		echo '<button type="button" class="btn btn-secondary btn-icon nav-toggle" aria-expanded="false" aria-controls="site-nav-menu">'
			. '<span class="screen-reader-text">Menüü</span>'
			. '<svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true"><path d="M2 6h14M2 12h14" stroke="currentColor" stroke-width="1.2"/></svg>'
			. '</button>';
	}
	echo $cta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts above.
}

/** Whether a post's blocks include a level-1 heading, i.e. the content brings its own page title. */
function taipan_content_has_h1( $post ) {
	$find = function ( $blocks ) use ( &$find ) {
		foreach ( $blocks as $block ) {
			if ( 'core/heading' === $block['blockName'] && 1 === ( $block['attrs']['level'] ?? 2 ) ) {
				return true;
			}
			if ( $block['innerBlocks'] && $find( $block['innerBlocks'] ) ) {
				return true;
			}
		}
		return false;
	};
	return $post && has_blocks( $post ) && $find( parse_blocks( $post->post_content ) );
}

/** Prints the current page's block content full width: the homepage, the "Sektsioonid" template and pages with their own H1. */
function taipan_render_sections() {
	get_header();
	?>
	<main id="main" class="container landing">
		<?php
		while ( have_posts() ) {
			the_post();
			the_content();
		}
		?>
	</main>
	<?php
	get_footer();
}

