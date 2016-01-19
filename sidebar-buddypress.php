<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage cdigital2014
 * @since Cultura Digital 1.0
 */
?>

<div id="sidebar">
		
		<?php 

		// if bp_is_member() {

			if( !dynamic_sidebar( 'Buddypress' ) ) dynamic_sidebar( 'Buddypress' );

		// } else if bp_is_group() {

		// }
		
		?>
	 
</div>