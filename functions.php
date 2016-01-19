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
	function register_theme_sidebar( $name )
	{
		register_sidebar( array(
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
		register_theme_sidebar('home-destaques');
		register_theme_sidebar('home-left-column');
		register_theme_sidebar('home-right-column');
		register_theme_sidebar('home-center-column');

		register_theme_sidebar( 'Posts' );		
		register_theme_sidebar('Index');
		register_theme_sidebar('Foruns');
		register_theme_sidebar('Buddypress');

		register_theme_sidebar('tabs-sidebar');

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
		}
	
		/* Renumber the array keys to account for missing items */
		$activities_new = array_values( $activities->activities );
		$activities->activities = $activities_new;
	
		return $activities;
    }
    // add_action('bp_has_activities','my_custom_activities', 10, 2 );
	
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
	 include( TEMPLATEPATH . '/widgets/widget-destaques.php'); // para funcionar tem que ativar o plugin minc_headlines	
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

	// trash

	// ajustes na barra de admin

	// function ajustes_wp_bar( $wp_admin_bar ) {
	// 	$wp_admin_bar->remove_node( 'wp-logo' );
	// 	$node_my_account = $wp_admin_bar->get_node( 'my-account' );
	// }
	// add_action( 'admin_bar_menu', 'ajustes_wp_bar', 30 );
	
	// // my_register_sidebar
	// function my_register_sidebar($name)
	// {
	// 	register_sidebar(
	// 		array(
	// 			'name'			=> $name,
	// 			'before_widget' => '<div id="%1$s" class="widget %2$s">',
	// 			'after_widget'	=> '</div>',
	// 			'before_title'	=> '<h2 class="widgettitle">',
	// 			'after_title'	=> '</h2>'
	// 		)
	// 	);
	// }
	
