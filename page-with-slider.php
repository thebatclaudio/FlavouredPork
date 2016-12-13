<?php // Template Name: Page with top slider ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php bloginfo('name'); ?> - <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
</head> 


<body <?php body_class(); ?>>

  <header>
    <a href="<?php echo site_url(); ?>" title="<?php _e("Return to home"); ?>" class="return-to-home">
      <h1 class="site-title"><?php bloginfo('title');?></h1>
      <h2 class="site-description"><?php bloginfo('description'); ?></h2>
    </a>
  </header>

  <a id="menu-button">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </a>

  <nav class="menu-wrapper">
      <div class="icon-list">
        <?php
          $defaults = array(
            'theme_location'  => '',
            'menu'            => '',
            'container'       => '',
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => 'menu-ul',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '<span>',
            'link_after'      => '</span>',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
          );

          wp_nav_menu( $defaults );
        ?>
      </div>
  </nav>

  <?php flv_prk_top_slider_template(); ?>

    <div class="main-container container-fluid">
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
                        <?php if(comments_open()): ?>
                            <?php comments_template(); ?>
                        <?php endif; ?>
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