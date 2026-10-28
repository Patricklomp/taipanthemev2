<?php
get_header();
?>

<main id="main" class="container">
	<header class="page-header">
		<span class="kicker">404</span>
		<h1 class="display">Lehte ei leitud</h1>
	</header>
	<div class="entry-content">
		<p>Seda lehte pole olemas või on see kolinud. Alusta avalehelt või otsi:</p>
		<?php get_search_form(); ?>
		<p class="btn-row"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Avalehele</a></p>
	</div>
</main>

<?php
get_footer();
