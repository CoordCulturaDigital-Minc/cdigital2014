<?php
/*
Function Name: Widget Destaque
Plugin URI: http://xemele.cultura.gov.br/
Version: 0.1
Author: Marcos Maia Lopes, atualizado por Cleber Santos
Author URI: http://xemele.cultura.gov.br/
*/

class widget_hightlights extends WP_Widget
{	
	function __construct()
	{
		$widget_args = array('classname' => 'widget_destaque', 'description' => __( 'Destaques da página inicial') );
		parent::__construct('destaque', __('Destaques'), $widget_args);
	}

	function widget($args, $instance)
	{

		// $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$show_posts     = empty($instance['showposts']) ? 5 : $instance['showposts'];
		$category       = empty($instance['category']) ? '' : $instance['category'];
		$limit_title 	= empty($instance['limit_title']) ? 100 : $instance['limit_title'];
		$limit_excerpt  = empty($instance['limit_excerpt']) ? 120 : $instance['limit_excerpt'];
		$i = 0;

		// load posts
		if( class_exists( 'HL_Query' ) ) :
			$query = new HL_Query( "showposts={$show_posts}&headline_category={$instance[ 'category' ]}" );

			if( $query->have_posts()) : 

				print $args[ 'before_widget' ];
				?>
		      	
		        <div id="highlights" class="two column doubling ui grid">

			        <?php
					
					while($query->have_posts()) : $query->the_post();
					
						$i++;

						print ( $i == 1 || $i == 3) ? "<div class='a two column row'>" : ""; 
						print ( $i == 4 ) ? "<div class='two column ui vertically divided grid'>" : ""; 
						print "<div class='column column-$i'>";

						?>


			        	<div id="post-<?php print get_the_ID(); ?>" class="<?php print strlen( get_the_excerpt()) <= 1  ? 'not-excerpt' : 'true-excerpt';  ?>">
							
							<div class="pic">
								<a href="<?php print get_permalink(); ?>" title="<?php print get_the_title(); ?>"><?php the_post_thumbnail( "headline" ); ?>
							</div>

							<div class="headline">
								<p class="post-meta"><?php print get_the_category_list( ', ' ); ?></p>
								<div class="post-title"><a href="<?php print get_permalink(); ?>" title="<?php print get_the_title(); ?>"><?php print limit_chars(get_the_title(), $limit_title ); ?></a></div>
								<div class="post-excerpt"><?php print limit_chars(get_the_excerpt(), $limit_excerpt ); ?></div>
							</div>

						</div>

			        	<?php

				        print "</div>";
						print ( $i == 2 ) ? "</div>" : "";
						print ( $i == 5 ) ? "</div></div>" : ""; 

					endwhile; 

				 print "</div>";

				 print $args[ 'after_widget' ];
			endif;
		endif;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		if( $instance != $new_instance )
			$instance = $new_instance;
		
		return $instance;
	}

	function form($instance)
	{
		global $wpdb;

	    $title =  empty( $instance['title'] ) ? '' : esc_attr( $instance['title'] );

		$showposts      =  empty( $instance['showposts']) ? 5 : esc_attr( $instance['showposts'] );
		$category       =  empty( $instance['category']) ? '' : esc_attr( $instance['category'] );
		$limit_title 	=  empty( $instance['limit_title']) ? 100 : absint( $instance['limit_title'] );
		$limit_excerpt  =  empty( $instance['limit_excerpt']) ? 120 : absint( $instance['limit_excerpt'] );
	?>
			<p>
				<label for="<?php print $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?>:</label>
				<input type="text" id="<?php print $this->get_field_id( 'title' ); ?>" name="<?php print $this->get_field_name( 'title' ); ?>" maxlength="26" value="<?php print $title; ?>" class="widefat" />
			</p>

			<p>
				<label for="<?php print $this->get_field_id( 'category' ); ?>"><?php _e( 'Category' ); ?>:</label>
				<?php $categories = $wpdb->get_results( "SELECT t.slug, tt.term_taxonomy_id, tt.term_id FROM {$wpdb->terms} as t INNER JOIN {$wpdb->term_taxonomy} as tt ON (t.term_id = tt.term_id) WHERE tt.taxonomy = 'headline_category'" ); ?>
				<select id="<?php print $this->get_field_id( 'category' ); ?>" name="<?php print $this->get_field_name( 'category' ); ?>" class="widefat">
				<?php foreach( $categories as $category ) : ?>
					<option value="<?php print $category->term_id; ?>" <?php if( !empty( $instance[ 'category' ] ) == $category->term_taxonomy_id ) print 'selected="selected"'; ?>><?php print $category->slug; ?></option>
				<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php print $this->get_field_id( 'showposts' ); ?>"><?php _e( 'Showposts' ); ?>:</label><br />
				<input type="text" id="<?php print $this->get_field_id( 'showposts' ); ?>" name="<?php print $this->get_field_name( 'showposts' ); ?>" size="2" maxlength="2" value="<?php print $showposts; ?>" />
			</p>

			<p>
				<label for="<?php print $this->get_field_id( 'limit_title' ); ?>"><?php _e( 'Tamanho max. do Título' ); ?>:</label><br />
				<input type="text" id="<?php print $this->get_field_id( 'limit_title' ); ?>" name="<?php print $this->get_field_name( 'limit_title' ); ?>" size="3" maxlength="3" value="<?php print $limit_title; ?>" />
			</p>

			<p>
				<label for="<?php print $this->get_field_id( 'limit_excerpt' ); ?>"><?php _e( 'Tamanho max. do sutiã' ); ?>:</label><br />
				<input type="text" id="<?php print $this->get_field_id( 'limit_excerpt' ); ?>" name="<?php print $this->get_field_name( 'limit_excerpt' ); ?>" size="3" maxlength="3" value="<?php print $limit_excerpt; ?>" />
			</p>

			
        <?php
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("widget_hightlights");'));
