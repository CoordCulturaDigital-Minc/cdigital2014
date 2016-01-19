<?php
/**
 * Copyright (c) 2014 Cleber Santos
 *
 * Written by Cleber Santos <ocleberantos@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 * Public License can be found at http://www.gnu.org/copyleft/gpl.html
 *
 * Plugin Name: CDbr: Link Registrar na Rede
 * Plugin URI: http://culturadigital.br/
 * Description: Cria um link para registrar na rede
 * Author: Cleber Santos
 * Version: 2014.09.08
 * Author URI: http://culturadigital.br/desenvolvimento/
 */

class widget_link_register extends WP_Widget
{	
	function widget_link_register()
	{
		$widget_args = array('classname' => 'widget_link_register', 'description' => __( 'Register') );
		parent::WP_Widget('link_register', __('Register'), $widget_args);
	}

	function widget($args, $instance)
	{
		extract($args);
		global $user_ID;
		
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

	    if(empty($user_ID)) :
			
			echo $before_widget;
		
			if( !empty( $title ) )
			{
			  echo $before_title . $title .$after_title;        
			}

			?>
			<a href="<?php bloginfo('url' ); ?>/registrar-na-rede/"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/bg/participe-cadastre-se.png" border="0" alt="Cadastre-se e participe!" class="participe" align="middle" width="99%"/></a> 
			<?php

			echo $after_widget;

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
	    $title = esc_attr( $instance['title'] );
	?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Título:</label>
				<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" maxlength="26" value="<?php echo $title; ?>" class="widefat" />
			</p>
        <?php
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("widget_link_register");'));
