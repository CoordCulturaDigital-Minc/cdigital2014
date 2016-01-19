<?php global $theme_options; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>

		<?php if( $theme_options[ 'index_thumb' ] && has_post_thumbnail() ) : ?><div class="post-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?></a></div><?php endif; ?>	
		<header class="post-header">
			<?php if( $theme_options[ 'index_category' ] ) : ?><div class="post-category"><?php the_category( ', ' ); ?></div><?php endif; ?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		</header>
		<div class="post-content">
			<?php if( $theme_options[ 'index_excerpt' ] ) : ?><div class="post-entry"><?php print limit_chars( get_the_excerpt(), 250 ); ?></div><?php endif; ?>
		</div>
		<footer class="post-meta clearfix">
			<?php if( $theme_options[ 'index_author' ] ) : ?><div class="post-author"><?php echo get_avatar( get_the_author_meta('user_email'), 30 ); ?> <?php the_author_posts_link(); ?></div><?php endif; ?>
			<?php if( $theme_options[ 'index_date' ] ) : ?><div class="post-date"><i class="calendar icon"></i><a href="<?php print get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ); ?>" title="<?php the_time( 'j \d\e F \d\e Y' ); ?>"><time datetime="<?php the_time( 'Y-m-d\TH:i:s+00:00' ); ?>"><?php the_time( 'j \d\e F \d\e Y' ); ?></time></a></div><?php endif; ?>
			<?php if( $theme_options[ 'index_modified_date' ] ) : ?><div class="post-date"><i class="time icon"></i><a href="<?php print get_day_link( get_the_modified_time( 'Y' ), get_the_modified_time( 'm' ), get_the_modified_time( 'd' ) ); ?>" title="<?php the_modified_time( 'j \d\e F \d\e Y' ); ?>"><time datetime="<?php the_modified_time( 'Y-m-d\TH:i:s+00:00' ); ?>"><?php the_modified_time( 'j \d\e F \d\e Y' ); ?></time></a></div><?php endif; ?>
			<?php if( $theme_options[ 'index_comments' ] ) : ?><div class="post-comment"><i class="comment outline icon"></i><?php comments_popup_link( '0', '1', '%' ); ?></div><?php endif; ?>
			<?php if( $theme_options[ 'index_tag' ] ) : ?><div class="post-tag"><i class="tags icon"></i><?php the_tags( ' ', ', ' ); ?></div><?php endif; ?>
		</footer>
</article>
<div class="ui section divider"></div>

<!-- .post -->
    			
	