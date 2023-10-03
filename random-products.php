<?php
/*
Plugin Name: Random Products Plugin
Description: Plugin to display random products.
Version: 1.0
*/

// Connecting the main plugin files
require_once(plugin_dir_path(__FILE__) . 'admin-page.php');

// shortcode [random_products]
function random_products_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'count' => get_option('random_products_count', 5),
            // Default number of products to display
        ),
        $atts,
        'random_products'
    );

    // Query WooCommerce for random products
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => intval($atts['count']),
        'orderby' => 'rand',
    );

    $products = new WP_Query($args);

    // Output random products
    ob_start();
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
    }
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('random_products', 'random_products_shortcode');

// added link to settings on the plugins page
function random_products_plugin_action_links($links)
{
    $settings_link = '<a href="options-general.php?page=random_products_settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'random_products_plugin_action_links');