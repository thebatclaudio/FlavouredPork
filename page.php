<?php get_header(); ?>

<?php get_footer(); ?>


<?php get_header(); ?>

    <?php if(have_posts()): ?>

        <?php while (have_posts()) : the_post(); ?>

        <div class="row">
            <article class="posts-container col-md-8">
                <div class="post single page">
                    <?php if(get_post_thumbnail_id(get_the_ID())): ?>
                    <figure class="featured-image <?php if($odd) echo "odd"; ?>" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));?>')">
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));?>" alt="<?php the_title(); ?>" />
                    </figure>
                    <?php endif; ?>
                    <div class="post-content">
                        <h1 class="title"><?php the_title(); ?></h1>
                        <p><?php the_content(); ?></p>
                    </div>

                    <div class="comments">
                        <?php comments_template(); ?>
                    </div>
                </div>
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