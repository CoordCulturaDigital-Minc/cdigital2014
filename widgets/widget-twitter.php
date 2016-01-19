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
 * Plugin Name: Widget Twitter Feed
 * Plugin URI: http://culturadigital.br/
 * Description: Allow the creation of a custom loop.
 * Author: Cleber Santos
 * Version: 2014.10.27
 * Author URI: http://culturadigital.br
 */

class Widget_Twitter_Feed extends WP_Widget
{
	// ATRIBUTES /////////////////////////////////////////////////////////////////////////////////////
	var $path = '';

	// METHODS ///////////////////////////////////////////////////////////////////////////////////////

    function parseTweet($text) {
        $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); 
        $text = preg_replace('#@([a-z0-9_]+)#i', '<a  target="_blank" href="http://twitter.com/$1">@$1</a>', $text); 
        $text = preg_replace('# \#([a-z0-9_-]+)#i', ' <a target="_blank" href="http://twitter.com/search?q=%23$1">#$1</a>', $text); 
        $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); 
        
        return $text;
    }

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
	
		print $args[ 'before_widget' ];

		if( !empty( $instance[ 'title' ] ) )
		{
			print $args[ 'before_head' ];

			print "<a href='https://twitter.com/search/?q=%40culturadigital.br%2BOR%2B%40culturadigitalbr&result_type=recent&count=10' title='click para acessar o twitter'>" 
			. $args[ 'before_title' ] 
			. $instance[ 'title' ] 
			. $args[ 'after_title' ] 
			. "<span>#culturadigitalbr</span>"
			. "</a>";
			
			print $args[ 'after_head' ];
		}

		print $args[ 'before_body' ];

		if( !$response = get_site_transient( 'cdbr_last_tweets' ) ) {
		
			$settings = array(
			    'oauth_access_token' => "2743424347-0VnSV3Jv3IH3wTW7TOZ496L2FTHDgVeYWPHmaBQ",
			    'oauth_access_token_secret' => "R9BCHE0YBAXMhSZhE7GpoAReT6hHm66vStCaveAE2m6cv",
			    'consumer_key' => "rYTeixrRafIZzsDdGxBdgexSn",
			    'consumer_secret' => "hwXnpI1Ccltti0Ez1C0FSPBQFxWJd6XRS6mUjKnGQNsZpHOCUq"
			);		

			$url = 'https://api.twitter.com/1.1/search/tweets.json';
			$getfield = '?q=%40culturadigital.br%2BOR%2B%40culturadigitalbr&result_type=recent&count=10';
			$requestMethod = 'GET';

            include_once $this->path . "../inc/TwitterAPIExchange.php";

			$twitter = new TwitterAPIExchange($settings);
			$response = $twitter->setGetfield($getfield)
	                    ->buildOauth($url, $requestMethod)
	                    ->performRequest();

			if( !empty( $response ) ) set_site_transient( 'cdbr_last_tweets', $response, 3600 ); 
		 }

		 ?>

		<?php if( isset( $response ) ) : ?>
           
			<?php $tweets = json_decode( $response ); ?>

			<?php if( empty( $tweets->error ) ) : ?>
				<div class="last-tweets">

					<div class="twitter-tip"></div>

					<ul class="tweets">
                   		<?php foreach( $tweets->statuses as $tweet) : ?>
			
                            <li class="tweet">
                                <div class="header">
                                    <a class="permalink" href="https://twitter.com/<?php echo $tweet->user->screen_name;?>/status/<?php echo $tweet->id_str; ?>">
                                    	<time class="dt-updated" datetime="" title="Horário da publicação: <?php echo $tweet->created_at; ?>"><?php print human_time_diff( strtotime( $tweet->created_at ) ); ?></time>
                                    </a>
                                    <div class="h-card p-author">
                                        <a class="u-url profile" href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>" title="<?php echo $tweet->user->description; ?>">
                                            <img class="avatar" alt="" src="<?php echo $tweet->user->profile_image_url; ?>">
                                            <span class="p-name"><?php echo $tweet->user->name; ?></span>
                                      		<span class="p-nickname">@<b><?php echo $tweet->user->screen_name;?></b></span>
                                        </a>
                                    </div>

                                </div>

                                <div class="e-entry-content">
                                    <p class="e-entry-title">
                                        <?php echo $this->parseTweet( $tweet->text ); ?>
                                    </p>
                                    <?php  if ( isset(  $tweet->entities->media ) ) : ?>
                                        <div class="inline-media" data-scribe="component:media_forward">
                                            <a class="photo-link  box-0" target="_blank" href="<?php echo $tweet->entities->media[0]->expanded_url; ?>" data-scribe="element:photo">
                                             <img class="autosized-media" alt="Ver imagem no Twitter" title="Ver imagem no Twitter" data-width="595" data-height="298" src="<?php print $tweet->entities->media[0]->media_url; ?>" width="290" height="145">
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="footer" data-scribe="component:footer">
                                    <ul class="tweet-actions" role="menu" aria-label="Ações do Tweet" data-scribe="component:actions">
                                        <li><a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $tweet->id_str; ?>" class="reply-action web-intent" title="Responder" data-scribe="element:reply"><i class="ic-reply ic-mask"></i><b>Responder</b></a></li>
                                        <li><a href="https://twitter.com/intent/retweet?tweet_id=<?php echo $tweet->id_str; ?>" class="retweet-action web-intent" title="Retweetar" data-scribe="element:retweet"><i class="ic-retweet ic-mask"></i><b>Retweetar</b></a></li>
                                        <li><a href="https://twitter.com/intent/favorite?tweet_id=<?php echo $tweet->id_str; ?>" class="favorite-action web-intent" title="Favorito" data-scribe="element:favorite"><i class="ic-fav ic-mask"></i><b>Favorito</b></a></li>
                                    </ul>
                                </div>
                            </li>
                            
						<?php endforeach; ?>
    
					</ul>
				</div>
			<?php endif; ?>

		<?php endif; 
 
		print $args[ 'after_body' ];

		print $args[ 'after_widget' ];
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

		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Título:</label></p>
            <p><input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php  print $title; ?>" /></p>


		<?php
	}

	// CONSTRUCTOR ///////////////////////////////////////////////////////////////////////////////////
	/**
	 * @name    Widget_Twitter_Feed
	 * @author  Cleber Santos <oclebersantos@gmail.com>
	 * @since   2014-10-27
	 * @updated 2014-10-27
	 * @return  void
	 */
	function Widget_Twitter_Feed()
	{
		// define plugin path
		$this->path = dirname( __FILE__ ) . '/';

		// register widget
		$this->WP_Widget( 'twitter_feed', 'Widget Twitter Feed', array( 'classname' => 'widget_twitter_feed', 'description' => 'Feed do twitter' ), array( 'width' => 400 ) );
	}

	// DESTRUCTOR ////////////////////////////////////////////////////////////////////////////////////

}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "Widget_Twitter_Feed" );' ) );

?>