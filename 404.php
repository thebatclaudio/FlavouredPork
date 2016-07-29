<?php get_header(); ?>


		<div class="row">
			<div class="posts-container col-md-8">
				<div class="post single">
				
				<h1 class="title-404">404</h1>
				<h2 class="not-found">Mi dispiace, ma non sono riuscito a trovare ciò che cercavi</h2>
				<h3 class="not-found">Prova a spegnere e riaccendere il tuo computer</h3>
				
				</div>
			</div>
			
						<div class="sidebar-container col-md-4">
				<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
					<ul class="main-sidebar">
						<?php dynamic_sidebar( "main-sidebar" ); ?>
					</ul>
				<?php endif;?>
			</div>
		</div>


<?php get_footer(); ?>