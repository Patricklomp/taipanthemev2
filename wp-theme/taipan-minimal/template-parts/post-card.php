<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card grid-2' ); ?>>
	<div>
		<span class="kicker"><?php echo esc_html( get_the_date() ); ?></span>
		<h2 class="h2-md"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>
	<div class="prose">
		<?php the_excerpt(); ?>
		<p><a href="<?php the_permalink(); ?>" class="btn btn-ghost">Loe edasi</a></p>
	</div>
</article>
