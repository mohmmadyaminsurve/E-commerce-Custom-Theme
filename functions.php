<?php
// Register navigation menu
register_nav_menus(
    array('primary-menu' => 'Primary Navigation')
);
// Add a custom class to <li> elements in nav menu
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);
function add_additional_class_on_li($classes, $item, $args)
{
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
// Add classes to <a> link elements: nav-link and nav-active if current
add_filter('nav_menu_link_attributes', 'maison_nav_link_classes', 10, 3);
function maison_nav_link_classes($atts, $item, $args)
{
    $link_classes = 'nav-link';

    if (in_array('current-menu-item', $item->classes, true) || in_array('current-menu-ancestor', $item->classes, true)) {
        $link_classes .= ' nav-active';
    }

    $atts['class'] = isset($atts['class']) ? $atts['class'] . ' ' . $link_classes : $link_classes;
    return $atts;
}
// Enqueue styles and scripts
function maison_chronos_co_enqueue_styles()
{
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'maison_chronos_co_enqueue_styles');
// Enable theme support features
function maison_chronos_co_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'maison_chronos_co_setup');
// Load custom templates for WooCommerce
if (class_exists('WooCommerce')) {
    add_filter('template_include', 'custom_woocommerce_template_include', 12);
}
function custom_woocommerce_template_include($template)
{
    if (is_shop()) {
        $shop_template = locate_template('woocommerce/archive-product.php');
        if ($shop_template) return $shop_template;
    } elseif (is_product()) {
        $single_product_template = locate_template('woocommerce/single-product.php');
        if ($single_product_template) return $single_product_template;
    } elseif (is_product_category()) {
        $category_template = locate_template('woocommerce/archive-product-category.php');
        if ($category_template) return $category_template;
    }
    return $template;
}
// WooCommerce cart icon with count
function custom_woocommerce_cart_icon()
{
    $cart_url = wc_get_cart_url();
    $cart_count = WC()->cart->get_cart_contents_count();
    return '
    <a href="' . esc_url($cart_url) . '" class="cart">
        <img alt="fun-img" src="' . get_template_directory_uri() . '/assests/images/cart.svg" / loading="lazy">
        <span class="wc-block-mini-cart__badge">' . esc_html($cart_count) . '</span>
    </a>';
}
add_shortcode('custom_cart_icon', 'custom_woocommerce_cart_icon');
// Custom empty cart template
add_filter('template_include', 'custom_empty_cart_template', 99);
function custom_empty_cart_template($template)
{
    if (is_cart() && WC()->cart->is_empty()) {
        $new_template = locate_template('woocommerce/cart/cart-empty.php');
        if (!empty($new_template)) return $new_template;
    }
    return $template;
}
// Remove default empty cart message
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Global Options',
        'menu_title' => 'Global Options',
        'menu_slug'  => 'global-options',
        'capability' => 'edit_posts',
        'redirect'   => false
    ]);
}
add_action('template_redirect', 'redirect_order_pay_to_custom_thank_you');
function redirect_order_pay_to_custom_thank_you()
{
    if (is_wc_endpoint_url('order-pay') && isset($_GET['key'])) {
        $order_id = get_query_var('order-pay');
        $order    = wc_get_order($order_id);

        if ($order && $order->get_order_key() === $_GET['key'] && $order->is_paid()) {
            // Order is paid, redirect to custom thank you page
            $redirect_url = site_url('/thank-you/?order_id=' . $order_id . '&key=' . $order->get_order_key());
            wp_safe_redirect($redirect_url);
            exit;
        }
    }
}
function defer_parsing_of_js($url)
{
    if (is_user_logged_in()) return $url;
    if (strpos($url, '.js') !== false && strpos($url, 'jquery.js') === false) {
        return str_replace(' src', ' defer src', $url);
    }
    return $url;
}
add_filter('script_loader_tag', 'defer_parsing_of_js', 11, 1);
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
function defer_jquery_script($tag, $handle)
{
    if (!is_admin() && $handle === 'jquery') {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'defer_jquery_script', 10, 2);
add_action('wp_enqueue_scripts', function () {
    if (
        !is_woocommerce() &&
        !is_cart() &&
        !is_checkout() &&
        !is_account_page()
    ) {
        // List of possible Font Awesome handles
        $font_awesome_handles = ['font-awesome', 'all', 'fontawesome', 'fa'];

        foreach ($font_awesome_handles as $handle) {
            if (wp_style_is($handle, 'enqueued')) {
                wp_dequeue_style($handle);
                wp_deregister_style($handle);
            }
        }

        // XootiX login plugin fonts
        wp_dequeue_style('xoo-el-fonts');
        wp_deregister_style('xoo-el-fonts');
    }
}, 100);
