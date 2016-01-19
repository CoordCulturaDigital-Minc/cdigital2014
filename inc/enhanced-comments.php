<?php
/**
 * Copyright (c) 2012 Marcelo Mesquita
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
 * Function Name: Enhanced Comments
 * Function URI: http://marcelomesquita.com/
 * Description: List the comments with replies
 * Author: Marcelo Mesquita
 * Author URI: http://marcelomesquita.com/
 * Version: 0.1
 */

function enhanced_comments( $comment, $args, $depth )
{
	$GLOBALS[ 'comment' ] = $comment;

	?>
		<li id="comment-<?php comment_ID(); ?>" class="comment">
			<?php if( 'pingback' == $comment->comment_type or 'trackback' == $comment->comment_type ) : ?>
				<?php print get_avatar( null, '72' ); ?>
			<?php else : ?>
				<?php print get_avatar( $comment, '72' ); ?>
			<?php endif; ?>
			<div class="balloon content">
				<?php if( $depth > 1 ) : ?><div class="reply-tip"></div><?php endif; ?>
				<div class="comment-author author"><?php comment_author_link(); ?></div>
				<div class="comment-date metadata"><span class="date"><?php comment_time( get_option( 'date_format' ) ); ?></span></div>
				<div class="comment-entry entry text">
					<?php if( '0' == $comment->comment_approved ) : ?>
						<p class="comment-wait">Seu comentário está aguardando moderação!</p>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
				<div class="actions">
					<?php comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ); ?>
					<?php edit_comment_link('Editar'); ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</li>
	<?php
}

?>
