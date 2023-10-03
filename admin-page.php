<?php

// Plugin settings page in the Settings menu
function random_products_plugin_menu()
{
    add_options_page(
        'Random Products Plugin Settings',
        'Random Products',
        'manage_options',
        'random_products_settings',
        'random_products_admin_page'
    );
}
add_action('admin_menu', 'random_products_plugin_menu');

// Registering plugin settings
function random_products_plugin_settings()
{
    register_setting('random_products_options', 'random_products_count', 'intval');
    add_settings_section('random_products_main', 'Random Products Settings', 'random_products_settings_section_callback', 'random_products_settings');
    add_settings_field('random_products_count', 'Number of products to display', 'random_products_count_field_callback', 'random_products_settings', 'random_products_main');
}
add_action('admin_init', 'random_products_plugin_settings');

// Callback functions for settings
function random_products_settings_section_callback()
{
    echo 'Adjust the settings for Random Products Plugin.';
}

function random_products_count_field_callback()
{
    $count = get_option('random_products_count', 5);
    echo '<input type="number" id="random_products_count" name="random_products_count" value="' . esc_attr($count) . '" min="1">';
}

// Callback functions for the plugin settings page
function random_products_admin_page()
{
    ?>
    <div class="wrap">
        <h2>Random Products Plugin Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('random_products_options'); ?>
            <?php do_settings_sections('random_products_settings'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function random_products_plugin_action_links($links)
{
    $settings_link = '<a href="options-general.php?page=random_products_settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'random_products_plugin_action_links');