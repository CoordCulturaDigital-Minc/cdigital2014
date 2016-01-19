<?php get_header(); ?>


<div id="body" class="main container">
<!-- <div id="body" class="container ui column page grid"> -->
	<div id="content" class="site-content">

		<section class="section section-search">
			<div class="section-head">
				<h1 class="section-title">Resultados para &quot;<?php the_search_query(); ?>&quot;</h1>
			</div>

			<div class="section-body">
				<div id="cse">
					<div class="load ui center aligned segment">
						<p> Carregando ... </p>
						<i class="loading icon"></i>
					</div>
				</div>
			</div>
		</section>

	</div>

</div>

<?php get_footer(); ?>