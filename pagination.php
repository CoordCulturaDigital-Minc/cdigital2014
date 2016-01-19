<div class="pagination">
		<?php if( function_exists( 'wp_pagenavi' ) ) : ?>
			<?php wp_pagenavi(); ?>
		<?php else : ?>
			<div class="wp-pagenavi">
				<div class="nextpostslink"><?php previous_posts_link( 'Mais novo &gt;'); ?></div>
				<div class="prevpostslink"><?php next_posts_link( '&lt; Mais antigo' ); ?></div>
		<?php endif; ?>	
</div>