<div id="sidebar">
	<?php
		if( is_home() ) {
			print '<!-- Sidebar: Home -->';
			if( !dynamic_sidebar( 'home-right-column' ) ) dynamic_sidebar( 'home-right-column' );

		} elseif( is_bbpress() ) {

			print '<!-- Sidebar: Fóruns -->';
			if( !dynamic_sidebar( 'Foruns' ) ) dynamic_sidebar( 'Foruns' );
		}
		elseif( is_singular() )
		{
			print '<!-- Sidebar: Posts -->';
			if( !dynamic_sidebar( 'Posts' ) ) dynamic_sidebar( 'Posts' );
		}
		else
		{
			print '<!-- Sidebar: Index -->';
			dynamic_sidebar( 'Index' );
		}

	?>
	<div class="tabs">
		<?php dynamic_sidebar('tabs-sidebar'); ?>
    </div>	

	 
</div>