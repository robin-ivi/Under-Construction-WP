<?php
/*
Plugin Name: Under Construction Page
Description: Display an "Under Construction" page to visitors while you work on your site.
Version: 1.0
Author: Your Name
*/

// Function to display the under construction page content
function under_construction_page_content() {
    // You can customize the HTML content of your under construction page here
    $message = get_option('ucp_message', 'Under Construction');
    $color = get_option('ucp_color', '#000000');
    $font_size = get_option('ucp_font_size', '24px');
    $timer_end_date = get_option('ucp_timer_end_date', '');

    echo '<div style="text-align: center; margin-top: 100px; color: ' . $color . '; font-size: ' . $font_size . ';">
            <h1>' . $message . '</h1>';
    
    if (!empty($timer_end_date)) {
        echo '<p>Site will be live again on ' . date('F j, Y', strtotime($timer_end_date)) . '</p>';
    }

    echo '</div>';
}

// Function to check if the user is logged in and display the under construction page accordingly
function display_under_construction_page() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        // Display under construction page content
        under_construction_page_content();
        // Prevent any further execution of WordPress
        die();
    }
}

// Hook the display_under_construction_page function to the template_redirect action
add_action('template_redirect', 'display_under_construction_page');

// Function to add settings page
function ucp_settings_page() {
    add_options_page('Under Construction Page Settings', 'Under Construction', 'manage_options', 'ucp_settings', 'ucp_settings_page_content');
}
add_action('admin_menu', 'ucp_settings_page');

// Function to display settings page content
function ucp_settings_page_content() {
    ?>
    <div class="wrap">
        <h2>Under Construction Page Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('ucp_settings_group'); ?>
            <?php do_settings_sections('ucp_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Under Construction Message</th>
                    <td><input type="text" name="ucp_message" value="<?php echo esc_attr(get_option('ucp_message', 'Under Construction')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Text Color</th>
                    <td><input type="color" name="ucp_color" value="<?php echo esc_attr(get_option('ucp_color', '#000000')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Font Size</th>
                    <td><input type="text" name="ucp_font_size" value="<?php echo esc_attr(get_option('ucp_font_size', '24px')); ?>" /> px</td>
                </tr>
                <tr valign="top">
                    <th scope="row">Countdown Timer End Date</th>
                    <td><input type="date" name="ucp_timer_end_date" value="<?php echo esc_attr(get_option('ucp_timer_end_date')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Function to register settings
function ucp_register_settings() {
    register_setting('ucp_settings_group', 'ucp_message');
    register_setting('ucp_settings_group', 'ucp_color');
    register_setting('ucp_settings_group', 'ucp_font_size');
    register_setting('ucp_settings_group', 'ucp_timer_end_date');
}
add_action('admin_init', 'ucp_register_settings');
