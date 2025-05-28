<?php
/**
 * Plugin Name: WP Login Page Customizer
 * Description: Customize the logo and background image for wp-admin via Settings.
 * Version: 1.0.0
 * Author: Shahzad Shahab
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-login-page-customizer
 */

if (!defined('ABSPATH')) exit;

// Add settings menu
function calb_add_settings_page() {
    add_options_page(
        'Login Branding',
        'Login Branding',
        'manage_options',
        'custom-admin-login-branding',
        'calb_render_settings_page'
    );
}
add_action('admin_menu', 'calb_add_settings_page');

// Register settings
function calb_register_settings() {
    register_setting('calb_settings_group', 'calb_login_logo');
    register_setting('calb_settings_group', 'calb_login_bg');
}
add_action('admin_init', 'calb_register_settings');

// Enqueue media uploader
function calb_enqueue_media_uploader($hook) {
    if ($hook === 'settings_page_custom-admin-login-branding') {
        wp_enqueue_media();
        wp_enqueue_script('calb-admin-js', plugin_dir_url(__FILE__) . 'js/admin.js', ['jquery'], '1.0', true);
    }
}
add_action('admin_enqueue_scripts', 'calb_enqueue_media_uploader');

// Settings page HTML
function calb_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Custom Admin Login Branding</h1>
        <form method="post" action="options.php">
            <?php settings_fields('calb_settings_group'); ?>
            <?php do_settings_sections('calb_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Login Logo URL</th>
                    <td>
                        <input type="text" name="calb_login_logo" id="calb_login_logo" value="<?php echo esc_attr(get_option('calb_login_logo')); ?>" style="width:60%;" />
                        <input type="button" class="button" id="upload_logo_button" value="Select Logo" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Login Background URL</th>
                    <td>
                        <input type="text" name="calb_login_bg" id="calb_login_bg" value="<?php echo esc_attr(get_option('calb_login_bg')); ?>" style="width:60%;" />
                        <input type="button" class="button" id="upload_bg_button" value="Select Background" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Customize wp-login logo and background
function calb_custom_login_styles() {
    $logo_url = esc_url(get_option('calb_login_logo'));
    $bg_url = esc_url(get_option('calb_login_bg'));
    ?>
    <style>
        <?php if ($logo_url): ?>
        .login h1 a {
            background-image: url('<?php echo $logo_url; ?>');
            background-size: contain;
            width: 100%;
        }
        <?php endif; ?>
        <?php if ($bg_url): ?>
        body.login {
            background-image: url('<?php echo $bg_url; ?>');
            background-size: cover;
            background-position: center;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'calb_custom_login_styles');
