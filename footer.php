	
		<footer id="footer">
			<div class="main container ui column grid ">
				<div class="two column doubling ui grid">
					 <div class="eleven wide column">
						<div class="sitemap">
					
							<?php if( function_exists( 'switch_to_blog' ) ) switch_to_blog( 1 ); ?>
								<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => '','menu_class' => 'menu-footer' ) ); ?>
							<?php if( function_exists( 'restore_current_blog' ) ) restore_current_blog(); ?>
						</div>
 					</div>	
 					<div class="three wide column">
						<div class="codigo">
							<h5>Código do site</h5>

							<p> Você pode ter acesso ao código acessando:</p>
							<a class="github" href="https://github.com/CoordCulturaDigital-Minc" title="Código do site">https://github.com/coordculturadigital-minc</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="copyright">
				<div class="container ui column page grid">
					<ul class="menu six wide column left">
						<li><a href="http://culturadigital.br/termos-de-uso/">Termos de uso</a></li>
						<li><a href="http://culturadigital.br/faqs/">FAQs</a></li>
						<li><a href="http://culturadigital.br/quem-faz-2/">Quem faz</a></li>
						<li><a href="http://culturadigital.br/desenvolvimento/">Blog de desenvolvimento</a></li>
					</ul>	
			        <p class="text six wide column center"><a href="http://www.cultura.gov.br/">Ministério da Cultura</a> e <a href="http://www.rnp.br/">RNP</a> - Alguns direitos reservados.</p>

			        <p class="links one wide column right" >
				        <a class="cc" href="http://creativecommons.org/licenses/by/3.0/br/" title="www.creativecommons.org">Creative Commons</a>
				        <a class="wp" href="http://www.wordpress.org/" title="www.wordpress.org">WordPress</a>
				    </p>
				</div>
			</div>
			<?php wp_footer(); ?>
		</footer>
	</div>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-59454395-1', 'auto');
	  ga('send', 'pageview');

	</script>
</body>
</html>