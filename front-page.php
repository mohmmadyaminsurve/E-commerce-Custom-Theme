<?php

/**
 * Template Name: Home
 */
get_template_part('parts/header');
?>
<section class="site-content" role="main">
    <?php if (have_rows('flexible_modules')) : echo '<section class="homepage-content">';
        while (have_rows('flexible_modules')) : the_row(); ?>
            <!-- ▸ hero section -->
            <?php if (get_row_layout() == 'hero_section') : ?>
                <section class="hero-section">
                    <div class="section-wrap">
                        <div class="my-slider">
                            <?php if (have_rows('hero_section')) : ?>
                                <?php while (have_rows('hero_section')) : the_row(); ?>
                                    <div class="flex-container">
                                        <div class="container-one">
                                            <h1 class="heading white mb-30"><?php the_sub_field('heading'); ?></h1>
                                            <p class="desc white mb-40">
                                                <?php the_sub_field('content'); ?>
                                            </p>
                                            <?php
                                            $link = get_sub_field('cta');
                                            if ($link) :
                                                $link_url = $link['url'];
                                                $link_title = $link['title'];
                                                $link_target = $link['target'] ? $link['target'] : '_blank';
                                            ?>
                                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>">
                                                    <div class="btn">
                                                        <?php the_sub_field('cta_text'); ?>
                                                    </div>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="container-two">
                                            <?php
                                            $image = get_sub_field('hero_image');
                                            if (!empty($image)) : ?>
                                                <img class="hero-img" src="<?php echo esc_url($image['url']); ?>" alt="hero-image" loading="lazy" fetchpriority="high" />
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <!-- ▸ features -->
            <?php elseif (get_row_layout() == 'product_overview') : ?>
                <section id="features">
                    <div class="section-wrap">
                        <div class="flex-container">
                            <?php if (have_rows('multiple_features')) : ?>
                                <?php while (have_rows('multiple_features')) : the_row(); ?>
                                    <div class="container-one white">
                                        <?php
                                        $image = get_sub_field('feature_image');
                                        if (!empty($image)) : ?>
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="icon" loading="lazy" />
                                        <?php endif; ?>
                                        <h4><?php the_sub_field('heading'); ?></h4>
                                        <p><?php the_sub_field('content'); ?></p>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <!-- ▸ product card -->
            <?php elseif (get_row_layout() == 'products') : ?>
                <section id="products" class="section-wrap">
                    <h1 class="mb-40 center"><?php the_sub_field('heading'); ?></h1>
                    <div class="flex-container">
                        <?php if (have_rows('products')) : ?>
                            <?php while (have_rows('products')) : the_row(); ?>
                                <div class="product-card">
                                    <div class="product-bg">
                                        <?php
                                        $image = get_sub_field('product_image');
                                        if (!empty($image)) : ?>
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="product" loading="lazy" />
                                        <?php endif; ?>
                                    </div>
                                    <h5><?php the_sub_field('product_name'); ?></h5>
                                    <p class="price"><?php the_sub_field('price'); ?></p>
                                    <div class="flex-container star-container">
                                        <img class="fill-star" src="<?php echo get_template_directory_uri(); ?>/assests/images/star.svg" alt="star" loading="lazy" />
                                        <img class="fill-star" src="<?php echo get_template_directory_uri(); ?>/assests/images/star.svg" alt="star" loading="lazy" />
                                        <img class="fill-star" src="<?php echo get_template_directory_uri(); ?>/assests/images/star.svg" alt="star" loading="lazy" />
                                        <img class="fill-star" src="<?php echo get_template_directory_uri(); ?>/assests/images/star.svg" alt="star" loading="lazy" />
                                        <img class="star" src="<?php echo get_template_directory_uri(); ?>/assests/images/star.svg" alt="star" loading="lazy" />
                                    </div>
                                    <p class="category"><?php the_sub_field('product_category'); ?></p>
                                    <?php
                                    $link = get_sub_field('product_url');
                                    if ($link) :
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_blank';
                                    ?>
                                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>">
                                            <div class="btn">
                                                <?php the_sub_field('cta'); ?>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </section>
                <!-- ▸ Full width with paralax -->
            <?php elseif (get_row_layout() == 'full_width_section') : ?>
                <section id="cta" class="mb-40">
                    <div class="container-one" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assests/images/full-width-image.webp');">
                        <div class="section-wrap">
                            <div class="cta-container white">
                                <h1><?php the_sub_field('heading'); ?></h1>
                                <p>
                                    <?php the_sub_field('content'); ?>
                                </p>
                                <?php
                                $link = get_sub_field('cta_url');
                                if ($link) :
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_blank';
                                ?>
                                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>">
                                        <div class="btn">
                                            <?php the_sub_field('cta'); ?>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- ▸ Latest News Section (dynamic) -->
            <?php elseif (get_row_layout() == 'blogs') : ?>
                <section id="blogs" class="mb-40">
                    <div class="section-wrap">
                        <h1 class="center mb-40"><?php the_sub_field('heading'); ?></h1>

                        <div class="flex-container">
                            <?php
                            // WP Query to fetch latest 3 blog posts
                            $latest_posts = new WP_Query(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                            ));

                            if ($latest_posts->have_posts()) :
                                while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>

                                    <div class="blog-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img class="blog-img" src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                        <?php endif; ?>

                                        <div class="content">
                                            <p class="category">
                                                <?php
                                                $category = get_the_category();
                                                if ($category) {
                                                    echo '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '" rel="category tag">' . esc_html($category[0]->name) . '</a>';
                                                }
                                                ?>
                                            </p>

                                            <h5 class="heading">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h5>

                                            <p class="desc">
                                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                            </p>

                                            <p class="date bold"><?php echo get_the_date('F j, Y'); ?></p>
                                        </div>
                                    </div>

                                <?php endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <p>No recent blog posts found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

            <?php elseif (get_row_layout() == 'newsletter') : ?>
                <section id="newsletter">
                    <div class="section-wrap">
                        <div class="flex-container">
                            <div class="newstext white">
                                <h4><?php the_sub_field('heading'); ?></h4>
                                <p><?php the_sub_field('content'); ?></p>
                            </div>
                            <div class="form">
                                <input type="text" placeholder="Your email address" />
                                <button class="normal white">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endwhile;
        echo '</section>'; ?>
    <?php endif; ?>
</section>
<?php get_template_part('parts/footer'); ?>