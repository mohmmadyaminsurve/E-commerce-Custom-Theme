<?php get_template_part('parts/header'); ?>
<section class="section-wrap">
    <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
        <!-- <h1> this is page.php</h1> -->
    <?php endwhile; ?>
</section>
<?php get_template_part('parts/footer'); ?>