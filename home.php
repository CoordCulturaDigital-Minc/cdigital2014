<?php get_header(); ?>
			<div class="main container">
			<!-- <div id="main-content" class="container ui page column grid" > -->
				
				<div id="home-content" class="site-content" role="main">

					<?php  dynamic_sidebar('home-destaques'); ?>
			
					<div class="row">
						<?php dynamic_sidebar('home-center-column'); ?>
					</div>

					<div class="two column doubling ui grid">
						<div class="eleven wide column">
							<?php dynamic_sidebar('home-left-column'); ?>
						</div>
						<div class="five wide column">
							<?php get_sidebar(); ?>
						</div>						
					</div>
					
				</div>

			</div>

			<div id="divulgacao" class="main container ui column grid">
				<div class="row two column doubling ui grid">
					<div class="eight wide column">
						<div class="patrocinio">
							<h5>Patrocínio:</h5>
							<div class="petrobras">
								<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="96%" height="90" title=" ">
									<param name="movie" value="<?php print THEME_URL ?>/images/logo/700x90_banner_petro.swf" />
									<param name="quality" value="high" />
									<param name="wmode" value="transparent" />
									<embed src="<?php print THEME_URL ?>/images/logo/700x90_banner_petro.swf" quality="high" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="96%" height="90"></embed>
								</object>
							</div>
						</div>
					</div>
						
					<div class="eight wide column">	
						<div class="parceria">
							<h5>Parceria:</h5>	
							<a href="http://www.rnp.br/" title="Rede Nacional de Ensino e Pesquisa" class="rnp">RNP</a>
						</div>

						<div class="realizacao">
							<h5>Realização:</h5>	
							<a href="http://www.cultura.gov.br/leis" title="Lei de Incentivo à Cultura" class="rouanet">Lei de Incentivo à Cultura</a>
							<a href="http://www.cultura.gov.br/" title="Ministério da Cultura" class="minc">Ministério da Cultura</a>
							<a href="http://www.brasil.gov.br/" title="Brasil - país rico é país sem pobreza" class="governo-federal">Brasil</a>
						</div>
					</div>
				</div>
			</div>
<?php get_footer(); ?>
			