<?php
/**
 * Single posts and pages. A page whose content has its own H1 (built from the
 * Avaleht or Kontakt pattern) gets the full-width section layout instead, so
 * the title and featured image aren't shown twice.
 */

if ( is_page() && taipan_content_has_h1( get_queried_object() ) ) {
	taipan_render_sections();
	return;
}

get_header();
?>

<main id="main" class="container">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="page-header">
				<?php if ( is_single() ) : ?>
					<span class="kicker">
						<?php echo esc_html( get_the_date() ); ?>
						<?php if ( has_category() ) : ?>
							· <?php echo wp_strip_all_tags( get_the_category_list( ', ' ) ); ?>
						<?php endif; ?>
					</span>
				<?php endif; ?>
				<?php the_title( '<h1 class="display">', '</h1>' ); ?>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="plate wide entry-thumb">
					<?php the_post_thumbnail( 'full', array( 'sizes' => '(max-width: 1200px) 100vw, 1200px', 'loading' => false ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
		</article>

		<?php
		if ( is_single() ) {
			the_post_navigation( array(
				'prev_text' => '<span class="kicker">Eelmine</span>%title',
				'next_text' => '<span class="kicker">Järgmine</span>%title',
			) );
		}

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>

<?php
get_footer();
