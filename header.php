<?php 
/**
 * The Header for our theme
 *
 *
 * @package WordPress
 * @subpackage cdigital2014
 * @since Cultura Digital 2.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">

	<title><?php wp_title( '|', true, 'right' );?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?php print THEME_URL; ?>/images/favicon.ico">

	<?php wp_head(); ?>

	<?php if( is_user_logged_in() ) $current_user = wp_get_current_user(); ?>
</head>
<body <?php body_class(); ?> >

	<div id="site" class="<?php echo is_user_logged_in()  ? 'logged-in' : 'loginout';?>" >

		<?php if( function_exists( 'switch_to_blog' ) ) switch_to_blog( 1 ); ?>
		
			<header id="header">

				<nav class="nav-top ui transparent main menu">

					<div class="main container">
							
						<div class="header item"><?php bloginfo( 'description' ); ?></div>

						<?php if ( is_user_logged_in() ) : ?>
							
							<ul class="menu-topo menu hover">
								<li class="item"><a href="<?php echo admin_url(); ?>">Painel</a></li>

								<?php if( function_exists('bp_is_active') )  : ?>
									<li class="item">
										<a class="ab-item" tabindex="-1" href="<?php echo SITE_URL; ?>/membros/<?php echo $current_user->user_nicename; ?>/activity/friends/">Meu Perfil</a>		
									</li>


									<?php $blogs = bp_blogs_get_blogs_for_user( bp_loggedin_user_id(), false );  ?>
									<?php if( ( is_array( $blogs['blogs'] ) && (int) $blogs['count'] ) ) : ?> 
										
										<?php bp_adminbar_blogs_menu() ; ?>

									<?php else : ?>
										<li class="item create-blog">
											<a class="ab-item" tabindex="-1" href="<?php echo SITE_URL; ?>/blogs/create">Criar um blog</a>		
										</li>									
									<?php endif ?>


									<?php if ( bp_is_active( 'notifications' ) ) : ?>
										<?php echo( $notification_count = bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ) ) ? bp_notifications_buddybar_menu() : '';  ?>
								    <?php endif;  ?>

								<?php endif; ?>

							    <li class="item"><a href="<?php echo wp_logout_url( $_SERVER['REQUEST_URI'] ); ?>">Sair</a></li>
							</ul>

						<?php else : ?>

							<ul class="menu-topo">
								<li class="item"><a href="<?php echo get_bloginfo( 'url' ); ?>/registrar-na-rede">Registrar</a></li>
								<li class="item login"><a href="#">Login</a></li>
				        	</ul>

							<div id="loginform" class="ui form segment">
								<form action="<?php print wp_login_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
									<div class="field">
										<label>Nome do usuário</label>
										<div class="ui left labeled icon input">
											<input type="text" id="user_login" name="log" placeholder="Nome de usuário">
											<i class="user icon"></i>
											<div class="ui corner label">
												<i class="icon asterisk"></i>
											</div>
										</div>
									</div>
									<div class="field">
										<label>Password</label>
										<div class="ui left labeled icon input">
											<input type="password" id="user_pass" name="pwd">
											<i class="lock icon"></i>
											<div class="ui corner label">
												<i class="icon asterisk"></i>
											</div>
										</div>
									</div>
									<a class="ui item" href="<?php print wp_lostpassword_url(); ?>" title="Esqueci minha senha">Esqueci minha senha</a>
								 	<button class="ui blue small submit button" type="submit" name="wp-submit" id="wp-submit" value="Login">Entrar</button>
								</form>
								<br>
						
							</div>
				        <?php endif; ?>	


						<?php if( function_exists('bp_is_active') )  : ?>
							<div class="search">

						     	<form action="<?php print bp_search_form_action(); ?>" method="post" id="search-form">
									<input type="text" id="search-terms" name="search-terms" placeholder="Buscar..." value="<?php print get_search_query(); ?>" />
									<?php print bp_search_form_type_select();  ?>
									<button type="submit" name="search-submit" id="search-submit"><span class="icon"></span></button>

									<?php wp_nonce_field( 'bp_search_form' );  ?>
								</form>
						    </div>					
						
						<?php endif; ?>
				    </div>

				</nav>

				
				<nav class="nav-main navbar-cdbr">

					<div class="main container ui grid">

						<div class="nav logo navbar-left">
					        <strong><a href="<?php echo get_bloginfo( 'url' ); ?>" title="Cultura Digital">Cultura Digital</a></strong>
					    </div>

					    <div class="bt-sidebar-left ui icon button launch left">
						  <i class="reorder icon"></i>
						</div>
						<?php if( function_exists('bp_is_active') )  : ?>
							<div class="bt-sidebar-right">
								<?php 
									if ( is_user_logged_in() ) {
										echo get_avatar( $current_user->user_email, 40 ); 
										echo ( $notification_count = bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ) ) ? '<span class="notifications">'.$notification_count . '</span>':'';
									}else {
										echo '<span class="bt-menu launch icon button right"></span>';
									}
								 ?>
							</div>
						<?php endif; ?>

						<div id="navigation" role="navigation">
							<?php wp_nav_menu( array('theme_location' => 'secondary', 'menu_class' => 'ui menu inverted right hover', 'container_class' => 'menu-header') ); ?>
						</div>

					</div>

				</nav>

			</header>
	
			<div id="sidebar-mobile-left" class="sidebar-mobile ui large vertical inverted overlay icon sidebar menu" >
			    <a class="hide item">
			      <i class="close icon"></i> Fechar Menu
			    </a>
			    <div class="menu">
				    <div class="item">
				      <form action="<?php bloginfo( 'url' ); ?>" class="ui mini icon input">
						  <input type="text" id="search" name="s" placeholder="Buscar..." value="<?php print get_search_query(); ?>">
			          </form>
				    </div>
				</div>
				<h3>Cultura Digital</h3>
				<?php wp_nav_menu( array('theme_location' => 'secondary', 'menu_class' => 'menu', 'container_class' => 'menu-lateral-esquerda') ); ?>

				<?php if ( is_user_logged_in() ) : ?>
					<h3>Administração</h3>		
					<ul class="menu">
						<li class="dashboard item"><a href="<?php echo admin_url(); ?>">Painel</a></li>

						<?php if( function_exists('bp_is_active') )  : ?>

							<?php bp_adminbar_blogs_menu(); ?>

							<?php if ( bp_is_active( 'notifications' ) ) : ?>
								<?php  echo( $notification_count = bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ) ) ? bp_notifications_buddybar_menu() : '';  ?>
						    <?php endif;  ?>

						    <li class="item bp-logout-nav"><a href="<?php echo wp_logout_url( $_SERVER['REQUEST_URI'] ); ?>">Sair</a></li>

						<?php endif; ?>
					</ul>

				<?php endif; ?>
	
			    
			</div>

			<div id="sidebar-mobile-right" class="sidebar-mobile ui large vertical inverted overlay icon sidebar menu right">
				<a class="hide item">
			      <i class="close icon"></i> Fechar Menu
			    </a>

				<div class="wrapper-menu">
					<?php if ( is_user_logged_in() ) : ?>
							<ul class="user">
								<li>
									<a class="ab-item" tabindex="-1" href="<?php echo SITE_URL; ?>/membros/<?php echo $current_user->user_nicename; ?>/activity/friends/">
										<?php  echo get_avatar( $current_user->user_email, 64 ); ?>
										<span class="display-name"><?php echo $current_user->display_name; ?></span>
										<span class="username">@<?php echo $current_user->user_nicename;  ?></span>
									</a>		
								</li>
							</ul>
							<?php if( function_exists('bp_is_active') )  : ?>
								<?php if ( bp_is_active( 'notifications' ) ) : ?>
									<ul id="menu-notifications" class="menu ">
									  <?php bp_notifications_buddybar_menu();  ?>
							      	</ul>
							    <?php endif;  ?>
							<?php endif; ?>
							
							<?php wp_nav_menu( array('theme_location' => 'buddypress', 'menu_class' => 'menu', 'menu_id' => 'menu-buddypress', 'container_class' => '') ); ?>
					
					<?php else: ?>

						<ul class="user menu-login">
							<li class="item"><a href="<?php echo wp_login_url( $_SERVER['REQUEST_URI'] ); ?>" title="Login">Login</a></li>
							<li class="item"><a href="<?php echo SITE_URL; ?>/registrar-na-rede">Registrar</a></li>
			        	</ul>
			        <?php endif; ?>
		      	</div>

		    </div>

		<?php if( function_exists( 'restore_current_blog' ) ) restore_current_blog(); ?>