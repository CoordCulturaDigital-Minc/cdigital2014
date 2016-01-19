<?php
/*
Function Name: Widget Atividades
Plugin URI: http://xemele.cultura.gov.br/
Version: 0.1
Author: Marcos Maia Lopes, atualizado por Cleber Santos
Updated 2014-09-08
Author URI: http://xemele.cultura.gov.br/
*/

class widget_activity extends WP_Widget
{	
	function widget_activity()
	{
		$widget_args = array('classname' => 'widget_activity', 'description' => __( 'Fluxo de atividades em todo site') );
		parent::WP_Widget('activity', __('Fluxo de atividades'), $widget_args);
	}

	function widget($args, $instance)
	{
		if( !function_exists('bp_is_active') )
			return false;
	    
	    extract($args);

	    $blog_url 		  = get_bloginfo( 'url' );
	    $title 			  = apply_filters('widget_title', empty($instance['title']) ? 'Atividades na rede' : $instance['title']);
	    $maxActivities 	  = empty($instance['maxActivities']) ? 10 : $instance['maxActivities'];
	    $activityFilterBy = empty($instance['activityFilterBy']) ? '' : $instance['activityFilterBy'];

	    // cria o filtro de actions, pega as chaves do array e cria uma string separando os valores por virgula	    
	    $query_string  = '&action=' . implode ("," , array_keys( $activityFilterBy ) );

	    // máximo de atividades
		$query_string .= '&max=' . $maxActivities; 

		// Mostrar essa widget apenas no perfil do usuário e na página inicial

		// se for a página do usuário
		if( bp_displayed_user_id() ) {

			// pega os amigos do usuário da página atual
			$friends = friends_get_friend_user_ids( bp_displayed_user_id() );

			if( !empty( $friends) ) {

				$friends_and_me = implode( ',', (array) $friends );
				$friends_and_me =  '&user_id=' . $friends_and_me;
				$query_string = $query_string . $friends_and_me;

			} else
				return false;
			
		// se não for a página inicial retorna falso. 
		} else if( !is_home() )
			return false; 
	

		print $before_widget;


		if( !empty( $instance[ 'title' ] ) )
		{
			print $before_head;
			print $before_title . "<a href='{$blog_url}/activity' title='ver mais atividades'> " .  $instance[ 'title' ] ."</a>". $after_title;
			print $after_head;
		}

		print $before_body;
	
		?>

			<?php do_action( 'bp_before_directory_activity' ); ?>

			<div id="buddypress" class="<?php echo (is_home() ) ? 'activity':''; ?>" role="main">

				<?php do_action( 'template_notices' ); ?>

				<?php do_action( 'bp_before_directory_activity_content' ); ?>

				<?php if ( is_user_logged_in() and is_home() ) : ?>

					<?php bp_get_template_part( 'activity/post-form' ); ?>

				<?php endif; ?>

				
				<?php do_action( 'bp_before_directory_activity_list' ); ?>

				<!-- loop -->

					<?php do_action( 'bp_before_activity_loop' ); ?>

					<?php //echo $query_string; ?>


					<?php  if ( bp_has_activities( bp_ajax_querystring( 'activity' ) . $query_string  ) ) :  ?>

						<ul id="activity-stream" class="activity-list item-list">

							<?php while ( bp_activities() ) : bp_the_activity(); ?>

								<?php bp_get_template_part( 'activity/entry' ); ?>

							<?php endwhile; ?>

							<?php if ( bp_activity_has_more_items() ) : ?>

								<li class="load-more">
									<a href="<?php bp_activity_load_more_link() ?>"><?php _e( 'Load More', 'buddypress' ); ?></a>
								</li>

							<?php endif; ?>

						</ul>

					<?php else : ?>

						<div id="message" class="info">
							<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
						</div>

					<?php endif; ?>
	

					<?php do_action( 'bp_after_activity_loop' ); ?>

				<!-- endloop -->

				<?php do_action( 'bp_after_directory_activity_list' ); ?>

				<?php do_action( 'bp_after_directory_activity_content' ); ?>

			</div>	
		
			<?php do_action( 'bp_after_directory_activity' ); ?>

		<?php 
		
		/*  aqui termina a parte do buddypress  */ 

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
		if( !function_exists('bp_is_active') )
			return false;
		
		$defaults = array(
			'title'	           => __( 'Activity Stream', 'buddypress' ),
			'maxActivities'    => 10,
			'activityFilterBy' => array('')
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = strip_tags( $instance['title'] );
		$activityFilterBy = (array) ( $instance['activityFilterBy'] );
		$maxActivities = esc_attr( $instance['maxActivities'] );

        ?>
            <p><label for="<?php print $this->get_field_id('title'); ?>">Título:</label></p>
            <p><input class="widefat" type="text" id="<?php print $this->get_field_id('title'); ?>" name="<?php print $this->get_field_name('title'); ?>" value="<?php print esc_attr( $title ); ?>"/></p>
	         
	        <p>
				<label for="<?php print $this->get_field_id('maxActivities'); ?>">Número máximo de posts:</label>
				<select id="<?php print $this->get_field_id('maxActivities'); ?>" name="<?php print $this->get_field_name('maxActivities'); ?>">
				    <?php for($i=0; $i <= 15; $i++) : ?>
				        <option <?php if($maxActivities == $i) print 'selected="selected"'; ?> value="<?php if($i == 0) print '1'; else print $i; ?>"><?php if($i == 0) print '1'; else print $i; ?></option>
				    <?php endfor; ?>
				</select>
        	</p>
	         
	         <p><label for="activityFilterBy"><?php _e( 'Show:', 'buddypress' ); ?></label></p>
	        
	         <p>
				<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[activity_update]" value="1" <?php checked( !empty( $activityFilterBy['activity_update'] ) ); ?>><?php _e( 'Updates', 'buddypress' ); ?><br>
				
				<?php if ( bp_is_active( 'blogs' ) ) : ?>

					<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[new_blog_post]" value="1" <?php checked( !empty( $activityFilterBy['new_blog_post']) ); ?>><?php _e( 'Posts', 'buddypress' ); ?><br>
					<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[new_blog_comment]" value="1" <?php checked( !empty( $activityFilterBy['new_blog_comment'] ) ); ?>><?php _e( 'Comments', 'buddypress' ); ?><br>
			
				<?php endif; ?>

				<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[bbp_topic_create]" value="1" <?php checked( !empty( $activityFilterBy['bbp_topic_create'] ) ); ?>><?php _e( 'Forum Topics', 'buddypress' ); ?><br>
				<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[bbp_reply_create]" value="1" <?php checked( !empty( $activityFilterBy['bbp_reply_create'] ) ); ?>><?php _e( 'Forum Replies', 'buddypress' ); ?><br>
					
				<?php if ( bp_is_active( 'groups' ) ) : ?>

					<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[created_group]" value="1" <?php checked( !empty( $activityFilterBy['created_group'] ) ); ?>><?php _e( 'New Groups', 'buddypress' ); ?><br>
					<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[joined_group]" value="1" <?php checked( !empty( $activityFilterBy['joined_group'] ) ); ?>><?php _e( 'Group Memberships', 'buddypress' ); ?><br>

				<?php endif; ?>

				<?php if ( bp_is_active( 'friends' ) ) : ?>

					<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[friendship_accepted,friendship_created]" value="1" <?php checked( !empty( $activityFilterBy['friendship_accepted']) ); ?>><?php _e( 'Friendships', 'buddypress' ); ?><br>

				<?php endif; ?>

				<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[new_member]" value="1" <?php checked( !empty( $activityFilterBy['new_member'] ) ); ?>><?php _e( 'New Members', 'buddypress' ); ?><br>
				<input type="checkbox" name="<?php print $this->get_field_name('activityFilterBy'); ?>[updated_profile]" value="1" <?php checked( !empty( $activityFilterBy['updated_profile'] ) ); ?>><?php _e( 'Profile Updates', 'buddypress' ); ?><br>

				<?php do_action( 'bp_activity_filter_options' ); ?>
			</p>
	
	        
        <?php
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("widget_activity");') );
