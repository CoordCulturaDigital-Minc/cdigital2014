<?php

/**
 * Copyright (c) 2012 Ministério da Cultura
 *
 * Written by Marcelo Mesquita <stallefish@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 * Public License can be found at http://www.gnu.org/copyleft/gpl.html
 *
 * Plugin Name: Destaques Order
 * Plugin URI: http://cultura.gov.br/audiovisual/
 * Description: Allow to insert a alternative date just for presentation.
 * Author: Marcelo Mesquita <stallefish@gmail.com>
 * Version: 0.3
 * Author URI: http://faracy.com.br/
 *
 */

class Slide_Order
{
	// ATRIBUTES /////////////////////////////////////////////////////////////////////////////////////
	var $dir = '';
	var $url = '';

	// METHODS ///////////////////////////////////////////////////////////////////////////////////////
	/**
	 * create a metabox
	 *
	 * @name    metabox
	 * @author  Marcelo Mesquita <stallefish@gmail.com>
	 * @since   2012-12-16
	 * @updated 2012-12-16
	 * @return  void
	 */
	function metabox()
	{
		add_meta_box( 'destaque-order', 'Mostra Destaque principal', array( &$this, 'metabox_content' ), 'post', 'side' );
	}

	/**
	 * show the metabox content
	 *
	 * @name    metabox_content
	 * @author  Marcelo Mesquita <stallefish@gmail.com>
	 * @since   2012-12-16
	 * @updated 2012-12-16
	 * @return  void
	 */
	function metabox_content( $post )
	{
		global $wpdb;

		$blog_id = get_current_blog_id();

		if( function_exists( 'switch_to_blog' ) ) switch_to_blog( PORTAL );

		$slides = array();

		// recuperar os dados do banco
		$slides = get_option( 'slides' );

		if( !is_array( $slides ) )
			$slides = array();

		?>
		<input type="hidden" name="slide-order-nonce" id="slide-order-nonce" value="<?php print wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

		<p>
			<label for="slide-order">Ordem:</label>
			<select name="slide-order" id="slide-order">
				<option value="0">escolha a posição</option>
				<?php for( $a = 1; $a <= 10; $a++ ) : ?>
					<option value="<?php print $a; ?>" <?php if( $post->ID == $slides[ $a ][ 'post_id' ] and $blog_id == $slides[ $a ][ 'blog_id' ] ) print 'selected="selected"'; ?>>
						<?php print $a; ?> <?php if( !empty( $slides[ $a ][ 'post_title' ] ) ) print " - {$slides[ $a ][ 'post_title' ]}"; ?>
					</option>
				<?php endfor; ?>
			</select>
			<small>Selecione apenas se o post tiver imagem destacada</small>
		</p>

		<?php

		if( function_exists( 'restore_current_blog' ) ) restore_current_blog();
	}

	/**
	 * save metabox options
	 *
	 * @name    metabox_save
	 * @author  Marcelo Mesquita <stallefish@gmail.com>
	 * @since   2011-12-16
	 * @updated 2012-06-05
	 * @return  bool
	 */
	function metabox_save( $post_id )
	{
		// verificar autorização
		if( !wp_verify_nonce( $_POST[ 'slide-order-nonce' ], plugin_basename( __FILE__ ) ) ) return $post_id;

		// validar dados
		$order      = ( int ) $_POST[ 'slide-order' ];
		$slides     = array();
		$new_slides = array();

		$blog_id    = get_current_blog_id();
		$post_id    = $post_id;
		$post_title = get_the_title( $post_id );

		if( !$real_post_id = wp_is_post_revision( $post_id ) )
			$real_post_id = $post_id;

		if( function_exists( 'switch_to_blog' ) ) switch_to_blog( PORTAL );

		// recuperar os dados do banco
		$slides = get_option( 'slides', $slides );

		foreach( $slides as $key => $slide )
		{
			if( $real_post_id != $slide[ 'post_id' ] or $blog_id != $slide[ 'blog_id' ] )
				$new_slides[ $key ] = $slide;
		}

		if( $order )
			$new_slides[ $order ] = array( 'blog_id' => $blog_id, 'post_id' => $real_post_id, 'post_title' => $post_title );

		ksort( $new_slides );

		// salvar os dados no banco
		update_option( 'slides', $new_slides );

		if( function_exists( 'restore_current_blog' ) ) restore_current_blog();

		return true;
	}

	// CONSTRUCTOR ///////////////////////////////////////////////////////////////////////////////////
	/**
	 * Description
	 *
	 * @author  Marcelo Mesquita <stallefish@gmail.com>
	 * @since   2012-12-16
	 * @updated 2012-12-16
	 * @return  void
	 */
	function __construct()
	{
		// define plugin url
		$this->url = WP_PLUGIN_URL . '/' . $this->slug;

		// define plugin dir
		$this->dir = WP_PLUGIN_DIR . '/' . $this->slug;

		// load languages
		load_plugin_textdomain( 'programation-date', $this->path . 'lang' );

		// adicionando o formulário na tela de edição de posts
		add_action( 'do_meta_boxes', array( &$this, 'metabox' ) );

		// salvar os dados do formulário quando os posts forem salvos
		add_action( 'save_post', array( &$this, 'metabox_save' ) );
	}

	// DESTRUCTOR ////////////////////////////////////////////////////////////////////////////////////

}

$Slide_Order = new Slide_Order();

?>