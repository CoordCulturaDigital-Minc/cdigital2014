<?php get_header(); ?>
			<div class="main container">
				<div id="index-content" class="site-content">
					<div class="two column doubling ui grid">
						<div class="twelve wide column">
						
							<?php if( have_posts() ) : ?>

								<section id="main-section" class="section section-index">
									<div class="section-head">
										<?php if( is_home() ) : ?>
										<h2 class="section-title ui header">Últimas Postagens</h2>
										<?php elseif( is_category() ) : ?>
											<h2 class="section-title ui header"><?php single_cat_title(); ?></h2>
										<?php elseif( is_tag() ) : ?>
											<h2 class="section-title ui header">Posts com a tag <span>&quot;<?php single_tag_title(); ?>&quot;</span></h2>
										<?php elseif( is_day() ) : ?>
											<h2 class="section-title ui header">Posts do dia <span><?php print get_the_time( 'd \d\e F \d\e Y' ); ?><span></h2>
										<?php elseif( is_month() ) : ?>
											<h2 class="section-title ui header">Posts do mês <span><?php print get_the_time( 'F \d\e Y' ); ?></span></h2>
										<?php elseif( is_year() ) : ?>
											<h2 class="section-title ui header">Posts do ano <span><?php print get_the_time( 'Y' ); ?></span></h2>
										<?php elseif( is_author() ) : ?>
											<h2 class="section-title ui header">Posts do(a) autor(a) <span><?php print get_userdata( intval( $author ) )->nickname; ?></span></h2>
										<?php elseif( is_search() ) : ?>
											<h2 class="section-title ui header">Busca por <span>&quot;<?php the_search_query(); ?>&quot;</span></h2>
										<?php endif; ?>
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
			