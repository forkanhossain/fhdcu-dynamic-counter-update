<?php 
/*
 * Plugin Name:       FHDCU Dynamic Counter Update
 * Plugin URI:        https://github.com/forkanhossain/fhdcu-dynamic-counter-update
 * Description:       A counter that increments by a random amount (8-9) per minute and saves it in the database.
 * Version:           1.0
 * Requires at least: 5.6
 * Tested up to:      6.7
 * Requires PHP:      7.2
 * Author:            Forkan Hossain
 * Author URI:        https://github.com/forkanhossain
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       fhdcu-dynamic-counter-update
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Activation: Initialize counter and timestamp
function fhdcu_counter_activate() {
    if (get_option('fhdcu_counter_value') === false) {
        update_option('fhdcu_counter_value', 905369);
    }
    if (!wp_next_scheduled('fhdcu_minute_increment')) {
        wp_schedule_event(time(), 'every_minute', 'fhdcu_minute_increment');
    }
}
register_activation_hook(__FILE__, 'fhdcu_counter_activate');

// Deactivation: Clear scheduled event
function fhdcu_counter_deactivate() {
    $timestamp = wp_next_scheduled('fhdcu_minute_increment');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'fhdcu_minute_increment');
    }
}
register_deactivation_hook(__FILE__, 'fhdcu_counter_deactivate');

// Register a custom cron interval for one minute
function fhdcu_custom_cron_intervals($schedules) {
    $schedules['every_minute'] = array(
        'interval' => 60,
        'display'  => __('Every Minute', 'fhdcu-dynamic-counter-update')
    );
    return $schedules;
}
add_filter('cron_schedules', 'fhdcu_custom_cron_intervals');

// Increment counter value every minute
function fhdcu_minute_increment() {
    $current_value = get_option('fhdcu_counter_value', 905369);
    $increment_amount = wp_rand(8, 9);
    update_option('fhdcu_counter_value', $current_value + $increment_amount);
}
add_action('fhdcu_minute_increment', 'fhdcu_minute_increment');

// Shortcode to display the counter and conditionally enqueue scripts/styles
function fhdcu_counter_display() {
    // Enqueue JavaScript and CSS only if shortcode is present
    wp_enqueue_script('fhdcu-counter-js', plugin_dir_url(__FILE__) . 'js/fhdcu-counter.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('fhdcu-counter-style', plugin_dir_url(__FILE__) . 'css/fhdcu-style.css', array(), '1.0.0');

    // Get current counter value
    $current_value = get_option('fhdcu_counter_value', 905369);

    // Output counter HTML
    $output = "<div id='fhdcu-counter'><p class='fhdcu-transactions-counter' data-count='{$current_value}'>1</p></div>";
    
    return $output;
}
add_shortcode('fhdcu_dynamic_counter', 'fhdcu_counter_display');

// Admin menu for manual counter reset
function fhdcu_counter_menu() {
    add_menu_page(
        'FHDCU Counter Settings',
        'Counter Settings',
        'manage_options',
        'fhdcu-counter',
        'fhdcu_counter_settings_page',
        'dashicons-plus-alt',
        25
    );
}
add_action('admin_menu', 'fhdcu_counter_menu');

// Settings page content
function fhdcu_counter_settings_page() {
    if (isset($_POST['set_fhdcu_counter_value']) && check_admin_referer('fhdcu_counter_nonce')) {
        $new_value = isset($_POST['fhdcu_counter_value']) ? sanitize_text_field(wp_unslash($_POST['fhdcu_counter_value'])) : null;
        if (is_numeric($new_value)) {
            update_option('fhdcu_counter_value', intval($new_value));
            echo "<div class='updated'><p>" . esc_html__('Counter value updated!', 'fhdcu-dynamic-counter-update') . "</p></div>";
        } else {
            echo "<div class='error'><p>" . esc_html__('Please enter a valid number.', 'fhdcu-dynamic-counter-update') . "</p></div>";
        }
    }

    $current_value = get_option('fhdcu_counter_value', 905369);
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Counter Settings', 'fhdcu-dynamic-counter-update'); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field('fhdcu_counter_nonce'); ?>
            <label for="fhdcu_counter_value"><?php esc_html_e('Set Counter Value:', 'fhdcu-dynamic-counter-update'); ?></label>
            <input type="number" name="fhdcu_counter_value" value="<?php echo esc_attr($current_value); ?>" />
            <input type="submit" name="set_fhdcu_counter_value" value="<?php esc_attr_e('Set Counter', 'fhdcu-dynamic-counter-update'); ?>" class="button button-primary" />
        </form>
        <p><?php esc_html_e('Add this shortcode [fhdcu_dynamic_counter] where you want to show the counter', 'fhdcu-dynamic-counter-update'); ?></p>
    </div>
    <?php
}
