<?php get_header(); ?>
	<?php $pagename = get_query_var('pagename');  ?>
	
	<div id="post-content" class="main container <?php echo $pagename ?>">
	<!-- <div id="post-content" class="container ui column page grid <?php echo $pagename ?>"> -->
		<div id="content" class="site-content" role="main">
			<div class="two column doubling ui grid">
				<div class="twelve wide column <?php get_post_format(); ?>">
					<?php if( have_posts() ) : the_post(); ?>
						<div class="section section-post">
							<div class="section-head">
								
							</div>
							<div class="section-body">
								<div id="post-<?php the_ID(); ?>" class="post">
									<div class="post-head">
										<?php edit_post_link( 'editar post &raquo;', '<div class="post-edit ui mini hover button">', '</div>' ); ?>
										<div class="clear"></div>
										<h1 class="post-title"><?php the_title(); ?></h1>
										<?php if( isset($theme_options[ 'post_excerpt' ] ) and has_excerpt() ): ?><h2 class="post-subtitle"><?php the_excerpt(); ?></h2><?php endif; ?>
										<div class="post-meta">
											<?php if( isset( $theme_options[ 'post_date' ] ) ) : ?><div class="post-date"><i class="calendar icon"></i><a href="<?php print get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ); ?>"><?php the_time( 'j \d\e F \d\e Y' ); ?>, às <?php the_time( 'G:i' ); ?></a></div><?php endif; ?>
										</div>
									</div>

									<div class="clear"></div>

									<div class="post-entry entry"><?php the_content(); ?></div>

									<div class="post-footer">
										<div class="share">
											<div class="share-title">Compartilhe esta publicação</div>
											<div class="tweet">
												<a href="https://twitter.com/share" class="twitter-share-button" data-via="culturadigital" data-lang="pt">Tweetar</a>
												<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
											</div>
											<div class="face">
												<div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
												<div id="fb-root"></div>
												<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
											</div>
										</div>


										<?php if( isset($theme_options[ 'post_author' ] ) ) : ?>
											<?php print get_avatar( get_the_author_meta( 'user_email' ), '62' ); ?>
											<div class="signature">
												<div class="post-author"><?php the_author_posts_link() ?></div>
											</div>
										<?php endif; ?>

										<div class="post-meta clearfix">
											<?php if( isset( $theme_options[ 'post_date' ] ) ) : ?><div class="post-date"><i class="calendar icon"></i><a href="<?php print get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ); ?>"><?php the_time( 'j \d\e F \d\e Y' ); ?>, às <?php the_time( 'G:i' ); ?></a></div><?php endif; ?>
											<?php if( isset( $theme_options[ 'post_modified_date' ] ) ) : ?><div class="post-date"><i class="time icon"></i>atualizado em <a href="<?php print get_day_link( get_the_modified_time( 'Y' ), get_the_modified_time( 'm' ), get_the_modified_time( 'd' ) ); ?>" title="<?php the_modified_time( 'j \d\e F \d\e Y' ); ?>"><time datetime="<?php the_modified_time( 'Y-m-d\TH:i:s+00:00' ); ?>"><?php the_modified_time( 'j \d\e F \d\e Y' ); ?></time></a></div><?php endif; ?>
											<?php if( isset( $theme_options[ 'post_tag' ] ) && has_tag() ) : ?><div class="post-tag"><i class="tags icon"></i><?php the_tags( ' ', ', ' ); ?></div><?php endif; ?>
											<?php if( isset( $theme_options[ 'post_category' ] ) ) : ?><div class="post-category"><i class="url icon"></i><?php the_category( ', ' ); ?></div><?php endif; ?>
										</div>
									</div>

									<div class="clearfix"></div>
								</div>
							</div>
							<div class="section-footer">

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