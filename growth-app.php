<?php
/*
Plugin Name: Growth CRO AI
Plugin URI: https://growthapp.io
Description: Your AI-Powered CRO Assistant That Does All Conversion Works For You.
Version: 1.0
Author: Growth App
Author URI: https://growthapp.io
License: GPLv2 or later
*/

/**
 * Function to add Growth App Tracking Settings menu page.
 *
 * @return void
 */
function growth_app_tracking_menu() 
{
    add_menu_page( 
        __('Growth App Tracking Settings', 'growth-app'),
        'GrowthApp AI', 
        'manage_options', 
        'growth-app-tracking-settings', 
        'growth_app_tracking_settings_page',
        'dashicons-media-document',
        16
    );
}

add_action( 'admin_menu', 'growth_app_tracking_menu' );

/**
 * Registers and defines the settings for Growth App Tracking plugin.
 *
 * @return void
 */
function growth_app_tracking_settings() 
{
    register_setting( 'growth-app-tracking-settings-group', 'growth_app_project_id' );
    register_setting( 'growth-app-tracking-settings-group', 'growth_app_api_key' );
}

add_action( 'admin_init', 'growth_app_tracking_settings' );

/**
 *  Function to display the plugin settings page content.
 *
 * @return void
 */
function growth_app_tracking_settings_page() 
{
    ?>
        <div class="wrap">
            <h2>GrowthApp CRO AI Tracking Settings</h2>
            <form method="post" action="options.php">
                <?php settings_fields('growth-app-tracking-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Project ID</th>
                        <td><input type="text" name="growth_app_project_id" placeholder="growth app project id" value="<?php echo esc_attr( get_option('growth_app_project_id') ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">API Key</th>
                        <td><input type="text" name="growth_app_api_key" placeholder="API keys" value="<?php echo esc_attr( get_option('growth_app_api_key') ); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php
}

/**
 * Injects the tracking script into the header if project ID and API key are set.
 *
 * @return void
 */
function growth_app_tracking_script() 
{
    $project_id = get_option( 'growth_app_project_id' );
    $api_key = get_option( 'growth_app_api_key' );

    if ($project_id && $api_key) {
        echo '<script>';
        echo 'var script = document.createElement("script");' . "\n";
        echo 'projectID = "' . esc_js($project_id) . '";' . "\n";
        echo 'apiKey = "' . esc_js($api_key) . '";' . "\n";
        echo 'script.src = "https://cdn.jsdelivr.net/gh/JoshuaXekhai/TrackingScript-main/tracker-v1.js";' . "\n";
        echo 'document.head.appendChild(script);' . "\n";
        echo '</script>' . "\n";
    }
}

add_action( 'wp_head', 'growth_app_tracking_script' );

