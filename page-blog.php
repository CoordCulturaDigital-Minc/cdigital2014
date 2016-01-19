<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>


	<div id="index-content" class="main container <?php echo $pagename ?>" role="main">
		<div class="site-content">
			<div class="two column doubling ui grid">
				<div class="twelve wide column">
					<?php
						
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

						query_posts('posts_per_page=10&paged=' . $paged); 
					?>
					<?php //query_posts(array('posts_per_page = 10')); ?>

					<?php if( have_posts() ) : ?>

						<section id="main-section" class="section section-index">

							<div class="section-head">
								<h2 class="section-title ui header">Blog</h2>
								<div class="section-description">
									<?php print category_description(); ?>
								</div>
							</div>

							<div class="ui dividing header"></div>
							
							<div class="section-body">
									

									<?php while( have_posts() ) : the_post(); ?>

										<?php get_template_part( 'loop' ); ?>

									<?php endwhile; ?>
							</div>

							<div class="section-footer">
								<?php get_template_part( 'pagination' ); ?>
							</div>
						</section>
						<?php  wp_reset_query(); ?>
					<?php else : ?>
						<?php get_template_part( 'error' ); ?>
					<?php endif; ?>
				</div>
				<div class="four wide column">
					<?php get_sidebar(); ?>
				</div>						
			</div>
			
		</div>
	</div>
<?php get_footer(); ?>
			