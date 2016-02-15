<?php
/*
Function Name: Widget Related Posts
Plugin URI: http://xemele.cultura.gov.br/
Version: 0.1
Author: Marcos Maia Lopes, atualizado por Cleber Santos
Updated 2014-09-08
Author URI: http://xemele.cultura.gov.br/
*/

class widget_related_posts extends WP_Widget
{	
	function __construct()
	{
		$widget_args = array('classname' => 'widget_related_posts', 'description' => __( 'Posts relacionados') );
		parent::__construct('related_posts', __('Related Posts'), $widget_args);
	}

	function widget($args, $instance)
	{
	    extract($args);

	    global $post;

	     if ( empty($post->ID) ) 
	     	return false;

	    $tags = wp_get_post_tags( $post->ID );

	    if ( empty( $tags ) ) 
	     	return false;
	     
	    $title 				= apply_filters('widget_title', empty($instance['title']) ? 'Posts Relacionados' : $instance['title']);
	    $maxPosts	 		= empty($instance['maxPosts']) ? 5 : $instance['maxPosts'];
	    $removeTags			= empty($instance['removeTags']) ? '' : $instance['removeTags'];

		print $before_widget;

		$blog_url = get_bloginfo( 'url' );

		if( !empty( $instance[ 'title' ] ) )
		{
			print $before_head;
			print $before_title . "<a href='{$blog_url}/blog' title='ver mais posts'> " .  $instance[ 'title' ] ."</a>". $after_title;
			print $after_head;
		}

		print $before_body;

		?>
		
			<?php if( $tags ) : ?>
				<?php $tag_ids = array(); ?>

				<?php foreach( $tags as $tag ) $tag_ids[] = $tag->term_id; ?>

				<?php

					$query = array (
							'tag__in' 			=> $tag_ids,
							'post__not_in' 		=> array( $post->ID ),
							'showposts'			=> $maxPosts
							// 'orderby'			=>'rand'
						);
				?>

				<?php $sugestoes = new WP_Query( $query ); ?>

				<?php if( $sugestoes->have_posts() ) : ?>
					<div class="section section-carousel">

						<div class="section-body" id="sugestoes">

							<?php while ( $sugestoes->have_posts() ) : $sugestoes->the_post(); ?>
								<div class="post">
									<?php if ( has_post_thumbnail()) : ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('thumbnail'); ?></a>
									<?php else : ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><img src="<?php echo get_bloginfo('template_directory'); ?>/images/icons/cdbr.jpg" alt="<?php echo get_the_title(); ?>" /></a>
									<?php endif; ?>

									<div class="post-head">
										<div class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
									</div>
								</div>
							<?php endwhile; ?>

						</div>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php wp_reset_query(); ?>
		<?php 
		

	    print $after_body;
		print $after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		if( $instance != $new_instance )
		{
			$instance = $new_instance;
		}
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'title'	      => __( 'Related Posts', 'buddypress' ),
			'maxPosts'    => 10,
			'removeTags'  => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title 		= strip_tags( $instance['title'] );
		$removeTags = ( $instance['removeTags'] );
		$maxPosts 	= esc_attr( $instance['maxPosts'] );

        ?>
            <p><label for="<?php print $this->get_field_id('title'); ?>">Título:</label></p>
            <p><input class="widefat" type="text" id="<?php print $this->get_field_id('title'); ?>" name="<?php print $this->get_field_name('title'); ?>" value="<?php print esc_attr( $title ); ?>"/></p>
	         
	        <p>
				<label for="<?php print $this->get_field_id('maxPosts'); ?>">Número máximo de posts:</label>
				<select id="<?php print $this->get_field_id('maxPosts'); ?>" name="<?php print $this->get_field_name('maxPosts'); ?>">
				    <?php for($i=0; $i <= 15; $i++) : ?>
				        <option <?php if($maxPosts == $i) print 'selected="selected"'; ?> value="<?php if($i == 0) print '1'; else print $i; ?>"><?php if($i == 0) print '1'; else print $i; ?></option>
				    <?php endfor; ?>
				</select>
        	</p>

        <?php
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("widget_related_posts");'));
