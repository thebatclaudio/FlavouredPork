<?php 
// Template Name: Page without sidebar
get_header(); 
?>
    <?php if(have_posts()): ?>

        <?php while (have_posts()) : the_post(); ?>

        <div class="row">
            <article class="posts-container without-sidebar col-md-12">
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
                        <?php if(comments_open()): ?>
                            <?php comments_template(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>


<?php get_footer(); ?>