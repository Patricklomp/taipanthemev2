<?php
if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="h2-md">Kommentaarid</h2>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'avatar_size' => 0 ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_submit'       => 'btn btn-primary',
		'title_reply'        => 'Jäta kommentaar',
		'title_reply_before' => '<h2 id="reply-title" class="h2-md">',
		'title_reply_after'  => '</h2>',
	) );
	?>
</section>
