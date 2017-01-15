<?php get_header(); ?>

	<?php if(have_posts()): ?>

		<?php while (have_posts()) : the_post(); ?>

		<div class="row">
			<article class="posts-container col-md-8">
				<div class="post single">
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
							<time datetime="get_the_time('U')"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></time>
						</div>
						<h1 class="title"><?php the_title(); ?></h1>
						<p><?php the_content(); ?></p>
					</div>

					<div class="comments">
						<?php comments_template(); ?>
					</div>
				</div>

				<nav class="posts-navigation-container">
				<?php if(get_adjacent_post(false,'',true)): ?>
					<a href="<?php echo get_permalink(get_adjacent_post(false,'',true)); ?>" title="<?php echo get_the_title(get_adjacent_post(false,'',true)->ID); ?>" class="posts-navigation previous-post">
						<i class="fa fa-chevron-left"></i>
					</a>
				<?php endif; ?>

				<?php if(get_adjacent_post(false,'',false)): ?>
					<a href="<?php echo get_permalink(get_adjacent_post(false,'',false)); ?>" title="<?php echo get_the_title(get_adjacent_post(false,'',false)->ID); ?>" class="posts-navigation next-post">
						<i class="fa fa-chevron-right"></i>
					</a>
				<?php endif; ?>
				</nav>
			</article>

			<div class="sidebar-container col-md-4">
				<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
					<ul class="main-sidebar">
						<?php dynamic_sidebar( "main-sidebar" ); ?>
					</ul>
				<?php endif;?>
			</div>
		</div>
		<?php endwhile; ?>
	<?php endif; ?>


<?php get_footer(); ?>