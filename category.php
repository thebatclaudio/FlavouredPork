<?php get_header(); ?>

	<h1 class="category-name"><?php single_cat_title(); ?></h1>

	<div class="row">
		<div class="posts-container col-md-8">

		<?php if(have_posts()): ?>
			<?php while (have_posts()) : the_post(); ?>
				<article class="post">
					<figure class="featured-image <?php if($odd) echo "odd"; ?>" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));?>')">
						<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));?>" alt="<?php the_title(); ?>" />
					</figure>
					<?php $cat = get_the_category(); ?>
					<?php if($cat): ?>
						<div class="category">
							<a href="<?php echo get_category_link($cat[0]->term_id); ?>" title="<?php echo $cat[0]->name;?>" class="category-link">
								<?php echo $cat[0]->name;?>
							</a>
						</div>
					<?php endif; ?>
					<div class="post-content">
						<div class="date">
							<time datetime="get_the_time('U')" class=""><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) .  __( ' ago', 'flv-prk' ); ?></time>
						</div>
						<h3 class="title"><?php the_title(); ?></h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="btn btn-continue-reading"><?php _e('Read', 'flv-prk'); ?></a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>



			<nav class="posts-pagination">
				<?php echo flv_prk_numeric_posts_nav(); ?>
			</nav>

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