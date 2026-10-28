<?php
/**
 * Fallback listing: blog, archives and search results.
 */

get_header();
?>

<main id="main" class="container">
	<header class="page-header">
		<?php if ( is_search() ) : ?>
			<span class="kicker">Otsing</span>
			<h1 class="display"><?php echo esc_html( get_search_query() ); ?></h1>
		<?php elseif ( is_archive() ) : ?>
			<?php the_archive_title( '<h1 class="display">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="page-header-desc">', '</div>' ); ?>
		<?php else : ?>
			<h1 class="display"><?php echo is_home() && ! is_front_page() ? esc_html( single_post_title( '', false ) ) : 'Blogi'; ?></h1>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="post-list">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/post-card' );
			endwhile;
			?>
		</div>
		<?php
		the_posts_pagination( array(
			'prev_text' => '← Uuemad',
			'next_text' => 'Vanemad →',
		) );
		?>
	<?php else : ?>
		<div class="entry-content">
			<p>Siit ei leitud midagi. Proovi otsida:</p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</main>

<?php
get_footer();
