<?php
/*
Function Name: Widget Blogs Main
Plugin URI: http://xemele.cultura.gov.br/
Version: 0.1
Author: Cleber Santos
Author URI: http://xemele.cultura.gov.br/
*/

class widget_blogs_main extends WP_Widget
{	
	function __construct()
	{
		$widget_args = array('classname' => 'widget_blogs_main', 'description' => __( 'Blogs Main') );
		parent::WP_Widget('blogs', __('Blogs Main'), $widget_args);
	}

	function widget($args, $instance)
	{
		if( !function_exists('bp_is_active') ) 
	    	return false;

	    extract( $args );

	    $blog_url = get_bloginfo( 'url' );

	    $title = apply_filters('widget_title', empty($instance['title']) ? 'Blogs Principais' : $instance['title']);
		$blogsIds 	= empty($instance['blogsIds']) ? '' : $instance['blogsIds'];

	    $queryString  = '&include_blog_ids=' . $blogsIds;
	    $queryString .= '&max=30';
	    $queryString .= '&type=active';	

	    print $before_widget;

		if( !empty( $instance[ 'title' ] ) )
		{
			print $before_head;
			print $before_title . "<a href='{$blog_url}/blogs' title='ver todos os blogs'> " .  $title ."</a>". $after_title;
			print $after_head;
		}
	?>
		<div id="principais-blogs">
			<div class="navigation">
			</div>

   			<?php print $before_body; ?>	

				<?php do_action( 'bp_before_blogs_loop' ); ?>

				<?php if ( bp_has_blogs( bp_ajax_querystring( 'blogs' ) . $queryString ) ) : ?>
			
				    <div id="blogs-dir-list" class="blogs dir-list carousel-blogs">

						<?php do_action( 'bp_before_directory_blogs_list' ); ?>

						<ul id="blogs-list" class="item-list slides" role="main">

							<?php while ( bp_blogs() ) : bp_the_blog(); ?>

								<li class="item">
									<div class="item-avatar">
										<a href="<?php bp_blog_permalink(); ?>"><?php bp_blog_avatar( 'type=full' ); ?></a>
									</div>

									<div class="item-caption">
										<div class="item-title"><a href="<?php bp_blog_permalink(); ?>"><?php bp_blog_name(); ?></a></div>
										<!-- <div class="item-meta"><span class="activity"><?php bp_blog_last_active( array( 'active_format' => false ) ); ?></span></div> -->

										<?php do_action( 'bp_directory_blogs_item' ); ?>
									

										<div class="action">

											<?php // do_action( 'bp_directory_blogs_actions' ); ?>
										
										</div>

										<div class="meta">

											<a href="<?php bp_blog_latest_post_permalink(); ?>" title="<?php print bp_get_blog_latest_post_title() ?>">
												<?php echo limit_chars( bp_get_blog_latest_post_title(), 90 ); ?>
											</a>
										
										</div>
										
									</div>

									<div class="clear"></div>
								</li>

							<?php endwhile; ?>

						</ul>

					</div>
				<?php endif; ?>

		    <?php print $after_body; ?>

		</div>

		<?php

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
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Título:</label></p>
            <p><input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if( !empty( $instance[ 'title' ] ) ) print $instance[ 'title' ]; ?>" /></p>

             <p><label for="<?php echo $this->get_field_id('blogsIds'); ?>">Blogs:</label></p>
             <p><input class="widefat" type="text" id="<?php echo $this->get_field_id('blogsIds'); ?>" name="<?php echo $this->get_field_name('blogsIds'); ?>" value="<?php if( !empty( $instance[ 'blogsIds' ] ) ) print $instance[ 'blogsIds' ]; ?>" />
       		<small>IDs dos blogs, separados por vírgulas.</small></p>
        <?php
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("widget_blogs_main");'));
