<?php

/**
 * Copyright (c) 2014 Cleber Santos
 *
 * Written by Cleber Santos <oclebersantos@gmail.com>
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
 * Plugin Name: Widget Global Tags
 * Plugin URI: http://culturadigital.br/
 * Description: Allow the creation of a custom loop.
 * Author: Cleber Santos
 * Version: 2014.10.27
 * Author URI: http://culturadigital.br
 */

class Widget_Global_Tags extends WP_Widget
{
	// ATRIBUTES /////////////////////////////////////////////////////////////////////////////////////
	var $path = '';

	// METHODS ///////////////////////////////////////////////////////////////////////////////////////
	/**
	 * load widget
	 *
	 * @name    widget
	 * @author  Cleber Santos <oclebersantos@gmail.com>
	 * @since   2014-10-27
	 * @updated 2014-10-27
	 * @param   array $args - widget structure
	 * @param   array $instance - widget data
	 * @return  void
	 */
	function widget( $args, $instance )
	{
		global $wpdb, $post;

		$blog_id = !empty( $instance[ 'blog' ] ) ? $instance[ 'blog' ] : 1;

		if( function_exists( 'switch_to_blog' ) ) switch_to_blog( $blog_id );

			// pega o link do blog
			$blog_url = get_bloginfo( 'url' );

			print $args[ 'before_widget' ];

			if( !empty( $instance[ 'title' ] ) )
			{
				print $args[ 'before_head' ];

				print "<a href='{$blog_url}' title='click para ver todas as tags'>" 
				. $args[ 'before_title' ] 
				. $instance[ 'title' ] 
				. $args[ 'after_title' ] 
				. "</a>";

				print $args[ 'after_head' ];
			}

			print $args[ 'before_body' ];

		 	if ( function_exists( 'wp_tag_cloud' ) ) {

		 		$tags = wp_tag_cloud('format=array&smallest=8&largest=25');

		 		// remove /blog/ do link
		        foreach( $tags as $tag ) {
		        	$tag = str_replace( '/blog/', '/', $tag );

		        	echo $tag;
		        }
		 	}
				
			print $args[ 'after_body' ];

			print $args[ 'after_widget' ];

		if( function_exists( 'restore_current_blog' ) ) restore_current_blog();
	}

	/**
	 * update data
	 *
	 * @name    update
	 * @author  Cleber Santos <oclebersantos@gmail.com>
	 * @since   2014-10-27
	 * @updated 2014-10-27
	 * @param   array $new_instance - new values
	 * @param   array $old_instance - old values
	 * @return  array
	 */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		if( $instance != $new_instance )
		{
			$instance = $new_instance;
		}
		return $instance;
	}

	/**
	 * widget options form
	 *
	 * @name    form
	 * @author  Cleber Santos <oclebersantos@gmail.com>
	 * @since   2014-10-27
	 * @updated 2014-10-27
	 * @param   array $instance - widget data
	 * @return  void
	 */
	function form( $instance )
	{
		$title  = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$blog   = !empty( $instance[ 'blog' ] ) ? $instance[ 'blog' ] : '';

		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Título:</label></p>
            <p><input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php  print $title; ?>" /></p>

             <p><label for="<?php echo $this->get_field_id('blog'); ?>">Blog:</label></p>
             <p><input class="widefat" type="text" id="<?php echo $this->get_field_id('blog'); ?>" name="<?php echo $this->get_field_name('blog'); ?>" size="5" maxlength="5" value="<?php print $blog; ?>" />
       		<small>ID do blog com as tags</small></p>

		<?php
	}

	// CONSTRUCTOR ///////////////////////////////////////////////////////////////////////////////////
	/**
	 * @name    Widget_Global_Tags
	 * @author  Cleber Santos <oclebersantos@gmail.com>
	 * @since   2014-10-27
	 * @updated 2014-10-27
	 * @return  void
	 */
	function __construct()
	{
		// define plugin path
		$this->path = dirname( __FILE__ ) . '/';

		// register widget
		$this->WP_Widget( 'global_tags', 'Widget Global Tags', array( 'classname' => 'widget_global_tags', 'description' => 'Pega as tags de um determinado blog da rede' ), array( 'width' => 400 ) );
	}

	// DESTRUCTOR ////////////////////////////////////////////////////////////////////////////////////

}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "Widget_Global_Tags" );' ) );

?>
