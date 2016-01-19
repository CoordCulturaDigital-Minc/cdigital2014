<?php get_header(); ?>
	<?php $pagename = get_query_var('pagename');  ?>
	<div class="main container <?php echo $pagename ?>">
		<div id="bbpress-content" class="site-content">
			<div class="two column doubling ui grid">
				<div class="twelve wide column <?php get_post_format(); ?>">

					<?php if( have_posts() ) : the_post(); ?>
						<div class="section section-post">
							<div class="section-head">
								<h1 class="section-title"><?php the_category( ',' ); ?></h1>
							</div>
							<div class="section-body">
								<div id="post-<?php the_ID(); ?>" class="post">
									<div class="post-head">
										<?php edit_post_link( 'editar post &raquo;', '<div class="post-edit">', '</div>' ); ?>
										<h1 class="post-title"><?php the_title(); ?></h1>
										<?php if( isset($theme_options[ 'post_excerpt' ] ) and has_excerpt() ): ?><h2 class="post-subtitle"><?php the_excerpt(); ?></h2><?php endif; ?>
										<div class="post-meta">
										
										</div>
									</div>

									<div class="post-entry entry"><?php the_content(); ?></div>

									<div class="post-footer">
									
									</div>

									<div class="clear"></div>
								</div>
							</div>
						</div>
					<?php else : ?>
						<?php get_template_part( 'error' ); ?>
					<?php endif; ?>

					<?php comments_template(); ?>
				</div>
				<div class="four wide column">
					<?php if( !get_post_format() ) get_sidebar(); ?>
				</div>
			</div>	
		</div>
	</div>
<?php get_footer(); ?>