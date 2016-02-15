<?php

	define( 'SITE_URL',        get_bloginfo( 'url' ) );
	define( 'SITE_TITLE',      get_bloginfo( 'name' ) );
	define( 'RSS_URL',         get_bloginfo( 'rss2_url' ) );
	define( 'THEME_URL',       get_bloginfo( 'template_directory' ) );

	// theme options
	$theme_options = get_option( 'theme_options' );	

	// thumbnails
	add_theme_support( 'post-thumbnails' );

	// images sizes
	add_image_size( 'headline', 200, 200, true );
	add_image_size( 'sidebar', 280, 126, true );

	/**
	 * Enqueue scripts and styles for the front end.
	 *
	 * @since Cultura Digital 1.0
	 */
	function culturadigital_scripts() {
		
		// styles
		wp_enqueue_style( 'open-sans-style', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700', array(), 1.0 );
		
		wp_enqueue_style( 'semantic-style', get_template_directory_uri() . '/semantic/css/semantic.min.css', array(), 1.0 );

		if( is_search() ) 
			wp_enqueue_style( 'google-custom-search', get_template_directory_uri() . '/css/google-custom-search.css', array(), false, 'screen' );

		wp_enqueue_style( 'buddypress-custom-style', get_template_directory_uri() . '/css/buddypress_custom.css', array(), 1.0 );
		
		wp_enqueue_style( 'culturadigital-style', get_template_directory_uri() . '/css/style.css', array(), 1.0 );


		// scripts
		wp_enqueue_script('jquery');

		wp_enqueue_script('jquery-ui-tabs');

		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), 2.2);

		wp_enqueue_script( 'semantic-script', get_template_directory_uri() . '/semantic/js/semantic.min.js', array(), 1.0 );
		
		if( is_search() ) {
			wp_enqueue_script( 'google-jsapi', 'http://www.google.com.br/jsapi', array() );
	
			wp_enqueue_script( 'google-custom-search',  get_template_directory_uri() . '/js/google-custom-search.js', array( 'google-jsapi' ) );
		}

		wp_enqueue_script( 'culturadigital-script', get_template_directory_uri() . '/js/script.js', array(), 1.0 );
	}
	add_action( 'wp_enqueue_scripts', 'culturadigital_scripts' );


	/**
	 * Configurações para o tema
	 *
	 * @param void
	 * @return mixed
	 */
	function culturadigital_setup() {
		//theme support
		
		add_theme_support( 'menus' );
		add_theme_support ('BuddyPress'); 

		//registra os menus
		register_nav_menus( array(
			'primary'    => 'Topo',
			'secondary'  => 'Header',
			'footer' 	 => 'Rodapé',
			'buddypress' => 'Buddypress',
		) );

		//desabilita a barra
		add_filter('show_admin_bar', '__return_false');

		remove_action('wp_footer','bp_core_admin_bar',8);
		remove_action('admin_footer','bp_core_admin_bar',8);

		// remove_action('bp_get_blog_signup_allowed', 'register-section',8);
		remove_action( 'bp_init', 'bp_get_blog_signup_allowed' );
		
		if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) )
		define( 'BP_AVATAR_THUMB_WIDTH', 80 );
		 
		if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
		define( 'BP_AVATAR_THUMB_HEIGHT', 80 ); 
		 
		if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
		define( 'BP_AVATAR_FULL_WIDTH', 100); 
		 
		if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
		define( 'BP_AVATAR_FULL_HEIGHT', 100 );

	}
	add_action( 'after_setup_theme', 'culturadigital_setup', 99 );

	/**
	 * Adiciona campos no perfil do usuário
	 *
	 * @param void
	 * @return string
	 */
	function display_user_color_pref() {


		$bp_profissao = xprofile_get_field_data( 'profissão' );
		$bp_cidade	  = xprofile_get_field_data( 'cidade' );
		$bp_estado	  = xprofile_get_field_data( 'estado' );

	    echo '<p class="field-data">' . $bp_profissao . '</p>';
		echo '<p class="field-data">' . $bp_cidade . ' - ' . $bp_estado . '</p>';
	    
	}
	add_action( 'bp_before_member_header_meta', 'display_user_color_pref' );

	// Tirar uma atividade e colocar um resumo da biografia.

	/**
	 * Adiciona campos no perfil do usuário
	 *
	 * @param void
	 * @return string
	 */
	function cdbr_user_latest_update( $latest_update ) {

		// $bp_profissao = xprofile_get_field_data( 'biografia' );

		return false;;
	}
	add_filter('bp_get_activity_latest_update','cdbr_user_latest_update');

	

	// evitando registro pelo wp-login
	function register_block_redirect() {
	    if ( preg_match('/(action=register)/', $_SERVER['REQUEST_URI'] ) )
	        wp_redirect(get_bloginfo('url'));
	}
	add_filter('init','register_block_redirect');

	/**
	 * Redirect user after successful login.
	 *
	 * @param string $redirect_to URL to redirect to.
	 * @param string $request URL the user is coming from.
	 * @param object $user Logged user's data.
	 * @return string
	 */
	function oci_login_redirect( $redirect_to, $request, $user)
	{
		global $bp;
		
		// $new_redirect_to = $bp->root_domain . '/' . BP_MEMBERS_SLUG . '/' . $user->user_login . '/activity/friends/';

		// if( isset( $request ) )
			// return $request;
		// else if( isset( $redirect_to ) )
			// return $redirect_to;
		// else 
			return $redirect_to;
		
	}
	//add_filter('login_redirect', 'oci_login_redirect', 10, 3);


	/**
	 * Sidebar structure
	 *
	 * @param string 
	 * @return void
	 */
	function register_theme_sidebar( $id, $name )
	{
		register_sidebar( array(
			'id'          => $id,
			'name'          => $name,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_head'   => '<div class="widget-head">',
			'after_head'    => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			'before_body'   => '<div class="widget-body">',
			'after_body'    => '</div>',
			'before_foot'   => '<div class="widget-foot">',
			'after_foot'    => '</div>',
		) );
	}

	/**
	 * Register sidebars
	 *
	 * @param void
	 * @return void
	 */
	if(function_exists('register_sidebar'))
	{	
		register_theme_sidebar('sidebar-1','home-destaques');
		register_theme_sidebar('sidebar-2','home-left-column');
		register_theme_sidebar('sidebar-3','home-right-column');
		register_theme_sidebar('sidebar-4','home-center-column');

		register_theme_sidebar('sidebar-5','Posts');		
		register_theme_sidebar('sidebar-6','Index');
		register_theme_sidebar('sidebar-7','Foruns');
		register_theme_sidebar('sidebar-8','Buddypress');

		register_theme_sidebar('sidebar-9','tabs-sidebar');

	}

	function bp_search_form_type( $options ) {
		
		$newOption['posts'] = __( 'All', 'buddypress' );
		
		$options =  $newOption + $options;

		return $options;
	}
	add_filter('bp_search_form_type_select_options','bp_search_form_type');


	// Carrega as sugestões de menções nas páginas dos fóruns e na home, além do fluxo de atividades
	function custom_bbpress_maybe_load_mentions_scripts( $retval = false ) {
		if ( function_exists( 'bbpress' ) && is_bbpress() ) {
			$retval = true;
		}

		if ( is_home() ) {
			$retval = true;
		}
	 
		return $retval;
	}
	add_filter( 'bp_activity_maybe_load_mentions_scripts', 'custom_bbpress_maybe_load_mentions_scripts' );

	// Filtra as atividades em todo site
	function my_custom_activities ($a, $activities)
	{
		// var_dump($activities);
		foreach ( $activities->activities as $key => $activity ) 
		{
			//new_member is the type name (component is 'profile')
			if ( $activity->type == 'new_member' )
			{
				unset( $activities->activities[$key] );
			
				$activities->activity_count = $activities->activity_count - 1;
				$activities->total_activity_count = $activities->total_activity_count - 1;
				$activities->pag_num = $activities->pag_num - 1;
			}
			elseif( $activity->type == 'created_group' )
			{
				unset( $activities->activities[$key] );
			
				$activities->activity_count = $activities->activity_count - 1;
				$activities->total_activity_count = $activities->total_activity_count - 1;
				$activities->pag_num = $activities->pag_num - 1;
			}
			elseif( $activity->type == 'joined_group' )
			{
				unset( $activities->activities[$key] );
			
				$activities->activity_count = $activities->activity_count - 1;
				$activities->total_activity_count = $activities->total_activity_count - 1;
				$activities->pag_num = $activities->pag_num - 1;
			}
			elseif( $activity->type == 'friendship_accepted' || $activity->type == 'friendship_created' )
			{
				unset( $activities->activities[$key] );
			
				if( $activity->type == 'friendship_accepted' && $activity->type == 'friendship_created' )
				{
					$activities->activity_count = $activities->activity_count - 2;
					$activities->total_activity_count = $activities->total_activity_count - 2;
					$activities->pag_num = $activities->pag_num - 2;
				}
				else
				{
					$activities->activity_count = $activities->activity_count - 1;
					$activities->total_activity_count = $activities->total_activity_count - 1;
					$activities->pag_num = $activities->pag_num - 1;
				}
			}
			elseif( $activity->type == 'updated_profile' )
			{
				unset( $activities->activities[$key] );
			
				$activities->activity_count = $activities->activity_count - 1;
				$activities->total_activity_count = $activities->total_activity_count - 1;
				$activities->pag_num = $activities->pag_num - 1;
			}
			elseif( $activity->type == 'new_blog' )
			{
				unset( $activities->activities[$key] );
			
				$activities->activity_count = $activities->activity_count - 1;
				$activities->total_activity_count = $activities->total_activity_count - 1;
				$activities->pag_num = $activities->pag_num - 1;
			}
			elseif( $activity->type == 'new_avatar' )
			{
				unset( $activities->activities[$key] );
			
				$activities->activity_count = $activities->activity_count - 1;
				$activities->total_activity_count = $activities->total_activity_count - 1;
				$activities->pag_num = $activities->pag_num - 1;
			}
			
		}
	
		/* Renumber the array keys to account for missing items */
		$activities_new = array_values( $activities->activities );
		$activities->activities = $activities_new;
	
		return $activities;
    }
    add_action('bp_has_activities','my_custom_activities', 9, 2 );


    function get_tag_html( $xml ) {
		$tag = preg_quote($tag);

		$regex = '|<[^>]+>(.*)</[^>]+>|U';

		preg_match_all($regex,
		           $xml,
		           $matches,
		           PREG_PATTERN_ORDER);

		return $matches[0];
	}

	function get_img_html( $xml ) {
		$tag = preg_quote($tag);

		$regex = "/(<img\s[^>]*?src\s*=\s*['\"][^'\"]*?['\"][^>]*?>)/";

		preg_match_all($regex,
		           $xml,
		           $matches,
		           PREG_SET_ORDER);

		return $matches[0];
	}

    function cdbr_get_activity_action_callback( $action, $activity ) {

    	if( $activity->type == 'new_blog_post' ) {

	    	$links = get_tag_html($activity->action ); 
	    	$action = '<span class="activity-blog">' . $links[2] . '</span>';
	    	$action .= '<span class="activity-title">' . $links[1] . '</span>';
	  		$action .= '<span class="activity-author">' . $links[0] . '</span>'; 
	    }

	    return $action;
    }
    add_filter('bp_get_activity_action_pre_meta','cdbr_get_activity_action_callback',10,2);



	function cdbr_get_activity_content_body_callback(  $content, $activity ) {
		
		if( $activity->type == 'new_blog_post' ) {

			$imgs =  get_img_html($content);

			if( isset($imgs[0] ) ) {
				$new_content = '<span class="thumbnail">'.$imgs[0].'</span>';
			
				$new_content .= '<p>'. strip_tags($content,'<a><br>') . '</p>';

				$content = $new_content;
			}
		}

		return $content;
	}
	add_filter('bp_get_activity_content_body','cdbr_get_activity_content_body_callback',10,2);
	
	/**
	* Filtro para mostrar no menu "meus sites" apenas os blogs que o usuário é administrador.
	*
	*/

	function cdbr_get_blogs_of_user( $blogs, $user_id , $all) {
		
		global $wpdb;

		$user_id = (int) $user_id;

		// Logged out users can't have blogs
		if ( empty( $user_id ) )
			return array();

		$keys = get_user_meta( $user_id );
		if ( empty( $keys ) )
			return array();

		if ( ! is_multisite() ) {
			$blog_id = get_current_blog_id();
			$blogs = array( $blog_id => new stdClass );
			$blogs[ $blog_id ]->userblog_id = $blog_id;
			$blogs[ $blog_id ]->blogname = get_option('blogname');
			$blogs[ $blog_id ]->domain = '';
			$blogs[ $blog_id ]->path = '';
			$blogs[ $blog_id ]->site_id = 1;
			$blogs[ $blog_id ]->siteurl = get_option('siteurl');
			$blogs[ $blog_id ]->archived = 0;
			$blogs[ $blog_id ]->spam = 0;
			$blogs[ $blog_id ]->deleted = 0;
			return $blogs;
		}

		$blogs = array();
		// var_dump($keys);
		if ( isset( $keys[ $wpdb->base_prefix . 'capabilities' ] ) && defined( 'MULTISITE' ) ) {
			$blog = get_blog_details( 1 );
			if ( $blog && isset( $blog->domain ) && ( $all || ( ! $blog->archived && ! $blog->spam && ! $blog->deleted ) ) ) {
				$blogs[ 1 ] = (object) array(
					'userblog_id' => 1,
					'blogname'    => $blog->blogname,
					'domain'      => $blog->domain,
					'path'        => $blog->path,
					'site_id'     => $blog->site_id,
					'siteurl'     => $blog->siteurl,
					'archived'    => $blog->archived,
					'mature'      => $blog->mature,
					'spam'        => $blog->spam,
					'deleted'     => $blog->deleted,
				);
			}
			unset( $keys[ $wpdb->base_prefix . 'capabilities' ] );
		}

		// $keys = array_keys( $keys ); 
		
		foreach ( $keys as $key => $value ) {

			if ( 'capabilities' !== substr( $key, -12 ) )
				continue;
			if ( $wpdb->base_prefix && 0 !== strpos( $key, $wpdb->base_prefix ) )
				continue;
			if( strpos( implode(':',$value), 'administrator') == false )
				continue;
			$blog_id = str_replace( array( $wpdb->base_prefix, '_capabilities' ), '', $key );
			if ( ! is_numeric( $blog_id ) )
				continue;

			$blog_id = (int) $blog_id;
			$blog = get_blog_details( $blog_id );
			if ( $blog && isset( $blog->domain ) && ( $all || ( ! $blog->archived && ! $blog->spam && ! $blog->deleted ) ) ) {
				$blogs[ $blog_id ] = (object) array(
					'userblog_id' => $blog_id,
					'blogname'    => $blog->blogname,
					'domain'      => $blog->domain,
					'path'        => $blog->path,
					'site_id'     => $blog->site_id,
					'siteurl'     => $blog->siteurl,
					'archived'    => $blog->archived,
					'mature'      => $blog->mature,
					'spam'        => $blog->spam,
					'deleted'     => $blog->deleted,
				);
			}
		}

		return $blogs;

	}
	add_filter( 'get_blogs_of_user', 'cdbr_get_blogs_of_user', 10, 3 );



	/**
	 * 
	 *
	 * @param void
	 * @return void
	 */
	include( TEMPLATEPATH . '/inc/custom-theme.php' );
	include( TEMPLATEPATH . '/inc/limit-chars.php' );
	include( TEMPLATEPATH . '/inc/the-thumb.php');
	include( TEMPLATEPATH . '/inc/enhanced-comments.php' );

	// widgets
	 // include( TEMPLATEPATH . '/widgets/widget-destaques.php'); // para funcionar tem que ativar o plugin minc_headlines	TODO: talvez seja o caso desativar.
	 include( TEMPLATEPATH . '/widgets/widget-atividades.php');
	 include( TEMPLATEPATH . '/widgets/widget-blogs-principais.php');
	 include( TEMPLATEPATH . '/widgets/widget-custom-loop.php');
	 include( TEMPLATEPATH . '/widgets/widget-related-posts.php');
	 include( TEMPLATEPATH . '/widgets/widget-link-register.php');
	 include( TEMPLATEPATH . '/widgets/widget-global-tags.php');
	 include( TEMPLATEPATH . '/widgets/widget-twitter.php');


	// include( TEMPLATEPATH . '/widgets/widget-comentarios.php');
	// include( TEMPLATEPATH . '/widgets/widget-blogadas.php');
	// include( TEMPLATEPATH . '/widgets/widget-blogs.php');
	// include( TEMPLATEPATH . '/widgets/widget_login.php');
	// include( TEMPLATEPATH . '/widgets/widget_map.php');
