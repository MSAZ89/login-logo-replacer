<?php
/**
 * Plugin Name: Login Logo Replacer
 * Plugin URI: https://example.com
 * Description: Replace the WordPress login logo with a custom image from your media library
 * Version: 1.0.1
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: login-logo-replacer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Login_Logo_Replacer {
    
    private $option_name = 'llr_logo_image_id';
    private $url_option_name = 'llr_logo_url';
    private $target_option_name = 'llr_logo_target';
    
    public function __construct() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Enqueue admin scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Add settings link on plugins page
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
        
        // Replace login logo
        add_action('login_enqueue_scripts', array($this, 'custom_login_logo'));
        
        // Change logo URL
        add_filter('login_headerurl', array($this, 'custom_login_logo_url'));
        
        // Change logo title
        add_filter('login_headertext', array($this, 'custom_login_logo_title'));
    }
    
    /**
     * Add settings page to admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'Login Logo Replacer',
            'Login Logo',
            'manage_options',
            'login-logo-replacer',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Add settings link on plugins page
     */
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=login-logo-replacer') . '">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
    
    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('llr_settings_group', $this->option_name);
        register_setting('llr_settings_group', $this->url_option_name, array(
            'sanitize_callback' => 'esc_url_raw'
        ));
        register_setting('llr_settings_group', $this->target_option_name);
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'settings_page_login-logo-replacer') {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_script(
            'llr-admin-script',
            plugins_url('admin.js', __FILE__),
            array('jquery'),
            '1.0.1',
            true
        );
        wp_enqueue_style(
            'llr-admin-style',
            plugins_url('admin.css', __FILE__),
            array(),
            '1.0.1'
        );
    }
    
    /**
     * Settings page HTML
     */
    public function settings_page() {
        $image_id = get_option($this->option_name);
        $logo_url = get_option($this->url_option_name, home_url());
        $logo_target = get_option($this->target_option_name, '0');
        $image_url = '';
        
        if ($image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'medium');
        }
        ?>
        <div class="wrap">
            <h1>Login Logo Replacer Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('llr_settings_group'); ?>
                
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Login Logo Image</th>
                        <td>
                            <div class="llr-image-preview">
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; height: auto; display: block; margin-bottom: 10px;">
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="<?php echo esc_attr($this->option_name); ?>" id="llr_logo_image_id" value="<?php echo esc_attr($image_id); ?>">
                            <button type="button" class="button" id="llr_upload_image_button">
                                <?php echo $image_id ? 'Change Image' : 'Select Image'; ?>
                            </button>
                            <?php if ($image_id): ?>
                                <button type="button" class="button" id="llr_remove_image_button">Remove Image</button>
                            <?php endif; ?>
                            <p class="description">Select an image from your media library to replace the WordPress login logo. Recommended size: 320x320 pixels or smaller.</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="llr_logo_url">Logo Link URL</label></th>
                        <td>
                            <input type="url" 
                                   id="llr_logo_url"
                                   name="<?php echo esc_attr($this->url_option_name); ?>" 
                                   value="<?php echo esc_attr($logo_url); ?>" 
                                   class="regular-text" 
                                   placeholder="<?php echo esc_attr(home_url()); ?>">
                            <p class="description">Enter the URL where users should go when they click the login logo. Leave empty to use your homepage.</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Link Behavior</th>
                        <td>
                            <label for="llr_logo_target">
                                <input type="checkbox" 
                                       id="llr_logo_target"
                                       name="<?php echo esc_attr($this->target_option_name); ?>" 
                                       value="1" 
                                       <?php checked($logo_target, '1'); ?>>
                                Open link in new tab
                            </label>
                            <p class="description">Check this box to open the logo link in a new browser tab.</p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Replace login logo with custom image
     */
    public function custom_login_logo() {
        $image_id = get_option($this->option_name);
        
        if (!$image_id) {
            return;
        }
        
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        
        if (!$image_url) {
            return;
        }
        
        $image_meta = wp_get_attachment_metadata($image_id);
        $width = isset($image_meta['width']) ? $image_meta['width'] : 320;
        $height = isset($image_meta['height']) ? $image_meta['height'] : 84;
        
        // Calculate dimensions (max 320px width, maintain aspect ratio)
        $max_width = 320;
        if ($width > $max_width) {
            $ratio = $max_width / $width;
            $width = $max_width;
            $height = round($height * $ratio);
        }
        
        // Check if link should open in new tab
        $logo_target = get_option($this->target_option_name, '0');
        $target_attr = ($logo_target === '1') ? 'target="_blank" rel="noopener noreferrer"' : '';
        
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url('<?php echo esc_url($image_url); ?>');
                background-size: contain;
                background-position: center center;
                width: <?php echo $width; ?>px;
                height: <?php echo $height; ?>px;
                margin-bottom: 20px;
            }
        </style>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                var logoLink = document.querySelector('#login h1 a, .login h1 a');
                if (logoLink && '<?php echo $target_attr; ?>') {
                    logoLink.setAttribute('target', '_blank');
                    logoLink.setAttribute('rel', 'noopener noreferrer');
                }
            });
        </script>
        <?php
    }
    
    /**
     * Change login logo URL
     */
    public function custom_login_logo_url() {
        $custom_url = get_option($this->url_option_name);
        return $custom_url ? $custom_url : home_url();
    }
    
    /**
     * Change login logo title
     */
    public function custom_login_logo_title() {
        return get_bloginfo('name');
    }
}

// Initialize the plugin
new Login_Logo_Replacer();