<?php get_template_part('parts/header'); ?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>
    <!--Site Content-->
    <section class="site-content" role="main">
        <div class="section-wrap">
            <article class="site-content-primary">
                <?php the_content(); ?>
            </article>
        </div>
    </section>
<?php endwhile; ?>
<?php get_template_part('parts/footer'); ?>