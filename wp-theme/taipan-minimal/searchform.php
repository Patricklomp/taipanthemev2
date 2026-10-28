<?php $taipan_search_id = wp_unique_id( 'search-' ); ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $taipan_search_id ); ?>">Otsi</label>
	<input id="<?php echo esc_attr( $taipan_search_id ); ?>" class="input" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Otsi…">
	<button type="submit" class="btn btn-primary">Otsi</button>
</form>
