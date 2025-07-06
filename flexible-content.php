<?php
ob_start();
/**
 * Template Name: global
 */
get_template_part('parts/header');
?>

<section class="site-content" role="main">
    <?php if (have_rows('flexible_modules')) : echo '<section class="flexible-content">';
        while (have_rows('flexible_modules')) : the_row(); ?>
            <!-- ▸ hero section -->
            <?php if (get_row_layout() == 'site_introduction') : ?>
                <section class="page-intro flex-container mb-40">
                    <div class="section-wrap">
                        <h1 class="fs-80"><?php the_sub_field('heading'); ?></h1>
                    </div>
                </section>
                <!-- ▸ features -->
            <?php elseif (get_row_layout() == 'about_us') : ?>
                <section class="aboutus-page section-wrap">
                    <?php if (have_rows('about_us_repeater')) : ?>
                        <?php while (have_rows('about_us_repeater')) : the_row(); ?>
                            <div class="flex-container mb-40">
                                <?php
                                $image = get_sub_field('about_image');
                                if (!empty($image)) : ?>
                                    <img class="img" src="<?php echo esc_url($image['url']); ?>" alt="" />
                                <?php endif; ?>
                                <div class="container-two">
                                    <h1 class="mb-20"><?php the_sub_field('heading'); ?></h1>
                                    <p><?php the_sub_field('content'); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
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
                                    <div class="btn"><?php the_sub_field('cta'); ?></div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </section>
                <!-- ▸ contact us -->
            <?php elseif (get_row_layout() == 'contact_us') : ?>
                <?php
                // ✅ Mail handling block
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
                    $first_name = sanitize_text_field($_POST['first_name']);
                    $last_name  = sanitize_text_field($_POST['last_name']);
                    $email      = sanitize_email($_POST['email']);
                    $phone      = sanitize_text_field($_POST['phone']);
                    $subject    = sanitize_text_field($_POST['subject']);
                    $message    = sanitize_textarea_field($_POST['message']);

                    // Send mail to admin
                    $to = 'cakechessse@gmail.com';
                    $full_subject = "New Message from $first_name $last_name: $subject";
                    $headers = [
                        'Content-Type: text/plain; charset=UTF-8',
                        "From: $first_name <$email>"
                    ];
                    $body = "You have received a new message from your website:\n\n"
                        . "Name: $first_name $last_name\n"
                        . "Email: $email\n"
                        . "Phone: $phone\n"
                        . "Subject: $subject\n"
                        . "Message:\n$message";

                    $sent = wp_mail($to, $full_subject, $body, $headers);

                    // Send confirmation to sender
                    if ($sent) {
                        $confirm_subject = "We've received your message!";
                        $confirm_body = "Hi $first_name,\n\nThank you for contacting Maison Chronos. We’ll get back to you shortly.\n\nBest,\nMaison Chronos Team";
                        $confirm_headers = [
                            'Content-Type: text/plain; charset=UTF-8',
                            'From: Maison Chronos <cakechessse@gmail.com>'
                        ];
                        wp_mail($email, $confirm_subject, $confirm_body, $confirm_headers);

                        // ✅ Redirect to prevent resubmission
                        wp_redirect(add_query_arg('message', 'success', get_permalink()));
                        exit;
                    } else {
                        wp_redirect(add_query_arg('message', 'error', get_permalink()));
                        exit;
                    }
                }
                ?>

                <!-- ✅ Contact Form Section -->
                <section class="contact-usform mb-40">
                    <div class="flex-container">
                        <img class="contact-usform-img" src="<?php echo get_template_directory_uri(); ?>/assests/images/conatct-us.jpg" alt="Contact-us" loading="lazy" />

                        <form class="form-wrapper" action="" method="post" id="contactForm">
                            <h1 class="mb-20">Send us a message</h1>
                            <p class="mb-20">
                                Fusce at nisi eget dolor rhoncus facilisis. Mauris ante nisl, consectetur et luctus et, porta ut dolor.
                            </p>

                            <div class="input-grid">
                                <input type="text" name="first_name" placeholder="First Name *" required />
                                <input type="text" name="last_name" placeholder="Last Name *" required />
                                <input type="email" name="email" placeholder="Your Email *" required />
                                <input type="tel" name="phone" placeholder="Your Phone Number" />
                                <input type="text" name="subject" placeholder="Subject *" class="full" required />
                                <textarea name="message" placeholder="Message *" class="full" rows="6" required></textarea>
                            </div>

                            <button type="submit" class="btn">Send Message</button>
                        </form>
                    </div>
                </section>

                <!-- ✅ SweetAlert Trigger -->
                <?php if (isset($_GET['message']) && $_GET['message'] === 'success') : ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "✅ Message Sent!",
                                text: "Thanks for contacting us.",
                                icon: "success"
                            }).then(() => {
                                document.getElementById("contactForm").reset();
                                window.history.replaceState({}, document.title, window.location.pathname); // remove query string
                            });
                        });
                    </script>
                <?php elseif (isset($_GET['message']) && $_GET['message'] === 'error') : ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "❌ Failed!",
                                text: "Sorry, message could not be sent.",
                                icon: "error"
                            }).then(() => {
                                window.history.replaceState({}, document.title, window.location.pathname);
                            });
                        });
                    </script>
                <?php endif; ?>




            <?php elseif (get_row_layout() == 'geo_address') : ?>
                <section class="geo-address mb-40">
                    <div class="flex-container section-wrap">
                        <?php if (have_rows('icon_section')) : ?>
                            <?php while (have_rows('icon_section')) : the_row(); ?>
                                <div class="container-one">
                                    <div class="icon-container">
                                        <?php
                                        $image = get_sub_field('icon');
                                        if (!empty($image)) : ?>
                                            <img class="icon" src="<?php echo esc_url($image['url']); ?>" alt="icon" loading="lazy" />
                                        <?php endif; ?>
                                        <div class="container-two">
                                            <h3 class="mb-10"><?php the_sub_field('heading'); ?>​</h3>
                                            <p><?php the_sub_field('description'); ?></p>
                                            <p><?php the_sub_field('desc'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
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
<?php
get_template_part('parts/footer');
ob_end_flush(); // Send the output now
?>