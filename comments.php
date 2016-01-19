<?php if( !comments_open() )  return false; ?>

<?php global $user_email; ?>

<div class="section section-comment">
	<div class="section-head">
		<h2 class="section-title">Comentários <span>(<?php comments_number( '0', '1', '%' ); ?>)</span></h2>
	</div>
	<div id="comments" class="section-body ui threaded comments">
		<?php if( have_comments() ) :?>
			<ul class="comments">
				<?php wp_list_comments( array( 'callback' => 'enhanced_comments' ) ); ?>
			</ul>

			<div class="clear"></div>
		<?php endif; ?>

		<?php if( function_exists( 'previous_comments_link' ) and function_exists( 'next_comments_link' ) ) : ?>
			<div class="section-foot">
				<div class="pagination alignright">
					<?php next_comments_link( '&lsaquo;' ); ?>
					<?php previous_comments_link( '&rsaquo;' ); ?>
				</div>

				<div class="clearfix"></div>
			</div>
		<?php endif; ?>

		<?php if ( comments_open() and post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<?php if( get_option( 'comment_registration' ) and !is_user_logged_in() ) : ?>
				<li class="comment">
					<div class="balloon content">
						<div class="comment-author author"><a href="<?php print wp_login_url( SITE_URL ); ?>" title="Login">Login</a></div>
						<div class="comment-entry entry">
							<p>Você precisa estar logado para fazer um comentário!</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</li>
			<?php else : ?>
				<form action="<?php print site_url( '/wp-comments-post.php' ); ?>" method="post" id="respond" class="comment ui reply form">
					<?php if( function_exists( 'comment_id_fields' ) ) comment_id_fields(); ?>
					<div class="balloon content field">
						<textarea name="comment" rows="1" class="memory" placeholder="Digite aqui o seu comentário"></textarea>
						<div class="ui buttons">
							<button class="ui button mini blue submit labeled icon"> <i class="icon edit"></i>Enviar</button>
							<?php cancel_comment_reply_link( 'Cancelar' ); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<?php do_action( 'comment_form', $post->ID ); ?>
					<div class="clear"></div>
				</form>
			<?php endif; ?>
		<?php else : ?>
			<li class="comment">
				<?php print get_avatar( null, '72' ); ?>
				<div class="balloon content">
					<div class="comment-author author"><a href="<?php print wp_login_url( SITE_URL ); ?>" title="Login">Login</a></div>
					<div class="comment-entry entry">
						<p>Comentários encerrados!</p>
					</div>
				</div>
				<div class="clearfix"></div>
			</li>
		<?php endif; ?>

	</div>
</div>
