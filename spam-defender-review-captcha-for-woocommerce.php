<?php
/*
Plugin Name: Spam Defender – Review Captcha for WooCommerce
Plugin URI: https://raisul.dev/projects/spam-defender-secure-google-recaptcha-for-woocommerce-reviews
Description: Adds Google reCAPTCHA to WooCommerce product reviews to prevent spam. Provides admin settings for reCAPTCHA Site Key and Secret Key.
Version: 1.0.1
Author: Raisul Islam Shagor
Author URI: https://raisul.dev
Requires at least: 4.8
Tested up to: 6.8
Requires PHP: 7.0
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Contributors: shagor447
Text Domain: spam-defender-review-captcha-for-woocommerce
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class SDWC_Review_Captcha {

    private $option_name = 'sdwc_recaptcha_keys';

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'settings_link' ) );

        // Frontend hooks
        add_action( 'comment_form_after_fields', array( $this, 'add_recaptcha_field' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'add_recaptcha_field' ) );
        add_filter( 'preprocess_comment', array( $this, 'verify_recaptcha_server_side' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        if ( ! is_admin() ) {
            wp_register_script( 'sdwc-recaptcha-api', 'https://www.google.com/recaptcha/api.js', array(), '1.0.0', true );
            wp_enqueue_script( 'sdwc-recaptcha-api' );

            $inline_js = "(function(){document.addEventListener('DOMContentLoaded', function(){var form = document.getElementById('commentform'); if (!form) return; form.addEventListener('submit', function(e){ var resp = ''; if (typeof grecaptcha !== 'undefined' && grecaptcha.getResponse) { resp = grecaptcha.getResponse(); } if (!resp || resp.length === 0) { e.preventDefault(); var box = document.getElementById('wc-recaptcha-error-inline'); if (box) { var msg = box.querySelector('.wc-recaptcha-msg'); if (msg) { msg.textContent = ' Please verify that you are not a robot.'; } box.style.display = 'block'; box.scrollIntoView({behavior:\'smooth\', block:\'center\'}); } return false; } }, false); });})();";
            wp_add_inline_script( 'sdwc-recaptcha-api', $inline_js );
        }
    }
    
    public function get_keys() {
        $keys = get_option( $this->option_name, array(
            'site_key'   => '',
            'secret_key' => '',
        ) );
        return $keys;
    }

    public function add_settings_page() {
        add_options_page(
            esc_html__( 'Woocommerce Review Captcha', 'spam-defender-review-captcha-for-woocommerce' ),
            esc_html__( 'Woocommerce Review Captcha', 'spam-defender-review-captcha-for-woocommerce' ),
            'manage_options',
            'sdwc-settings',
            array( $this, 'settings_page_html' )
        );
    }

    public function register_settings() {
        register_setting('sdwc_settings_group', $this->option_name, array('sanitize_callback' => array($this, 'sanitize_keys')) );
        add_settings_section( 'sdwc_section', '', null, 'sdwc-settings' );
        add_settings_field( 'site_key', esc_html__( 'Site Key', 'spam-defender-review-captcha-for-woocommerce' ), array( $this, 'site_key_field_html' ), 'sdwc-settings', 'sdwc_section' );
        add_settings_field( 'secret_key', esc_html__( 'Secret Key', 'spam-defender-review-captcha-for-woocommerce' ), array( $this, 'secret_key_field_html' ), 'sdwc-settings', 'sdwc_section' );
    }

    public function sanitize_keys( $input ) {
        $output = array( 'site_key' => '', 'secret_key' => '' );
        if ( is_array( $input ) ) {
            if ( isset( $input['site_key'] ) ) {
                $output['site_key'] = sanitize_text_field( $input['site_key'] );
            }
            if ( isset( $input['secret_key'] ) ) {
                $output['secret_key'] = sanitize_text_field( $input['secret_key'] );
            }
        }
        return $output;
    }

    public function site_key_field_html() {
        $keys = $this->get_keys();
        printf(
            '<input type="text" name="%s[site_key]" value="%s" class="regular-text"/>',
            esc_attr( $this->option_name ),
            esc_attr( $keys['site_key'] )
        );
    }

    public function secret_key_field_html() {
        $keys = $this->get_keys();
        printf(
            '<input type="text" name="%s[secret_key]" value="%s" class="regular-text"/>',
            esc_attr( $this->option_name ),
            esc_attr( $keys['secret_key'] )
        );
    }

    public function settings_page_html() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__( 'Spam Defender – WooCommerce Review Captcha', 'spam-defender-review-captcha-for-woocommerce' ); ?></h1>
            <p style="font-size:14px; color:#555; margin-bottom:20px;">
                Protect your WooCommerce Review Tab and checkout with Google reCAPTCHA to help prevent spam and abuse.
            </p>
            <div style="background:#f9f9f9; border-left:4px solid #0073aa; padding:10px 20px; margin-bottom:20px;">
                <strong>Instructions to set up reCAPTCHA:</strong>
                <ul style="margin-top:5px;">
                    <li>Get your reCAPTCHA keys from: <a href="https://www.google.com/recaptcha/admin/create" target="_blank">https://www.google.com/recaptcha/admin/create</a></li>
                    <li>Currently reCAPTCHA v2 ("challenge") is the only version supported.</li>
                    <li>When creating your API key, enable the "Challenge v2" option.</li>
                    <li>Copy your <strong>Site key</strong> and <strong>Secret key</strong> and paste them here, then click on the <strong>Save Changes</strong> button.</li>
                </ul>
            </div>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'sdwc_settings_group' );
                do_settings_sections( 'sdwc-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function settings_link( $links ) {
        $settings_link = '<a href="options-general.php?page=sdwc-settings">' . esc_html__( 'Settings', 'spam-defender-review-captcha-for-woocommerce' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public function add_recaptcha_field() {
        $keys = $this->get_keys();
        if ( empty( $keys['site_key'] ) ) {
            return;
        }
        ?>
        <div id="wc-recaptcha-wrap" style="margin-bottom:10px;">
            <div id="wc-recaptcha-error-inline" class="woocommerce-error" style="display:none;margin-bottom:10px;">
                <span style="color:#b93b3b;">
                    <span class="dashicons dashicons-info-outline"></span>
                    <span class="wc-recaptcha-msg"></span>
                </span>
            </div>
            <div class="g-recaptcha" data-sitekey="<?php echo esc_attr( $keys['site_key'] ); ?>"></div>
            <?php wp_nonce_field( 'sdwc_verify_recaptcha', 'sdwc_recaptcha_nonce' ); ?>
        </div>
        <?php
    }

    public function verify_recaptcha_server_side( $commentdata ) {
        $keys = $this->get_keys();
        if ( empty( $keys['secret_key'] ) ) {
            return $commentdata; // skip if no secret key
        }
    
        // Check nonce
        if ( ! isset( $_POST['sdwc_recaptcha_nonce'] ) || 
             ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sdwc_recaptcha_nonce'] ) ), 'sdwc_verify_recaptcha' ) ) {
            $this->redirect_with_error( __( 'Security check failed. Please reload the page and try again.', 'spam-defender-review-captcha-for-woocommerce' ) );
        }
    
        // Check response
        if ( empty( $_POST['g-recaptcha-response'] ) ) {
            $this->redirect_with_error( __( 'Please complete the reCAPTCHA before submitting your review.', 'spam-defender-review-captcha-for-woocommerce' ) );
        }
    
        // Verify with Google
        $recap_response = sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) );
        $remote = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret'   => $keys['secret_key'],
                'response' => $recap_response,
                'remoteip' => isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
            ),
            'timeout' => 10,
        ) );
    
        $body   = wp_remote_retrieve_body( $remote );
        $result = json_decode( $body );
    
        if ( empty( $result ) || empty( $result->success ) || $result->success !== true ) {
            $this->redirect_with_error( __( 'reCAPTCHA verification failed. Please try again.', 'spam-defender-review-captcha-for-woocommerce' ) );
        }
    
        return $commentdata;
    }
    
    //Redirect back to the product page with error + nonce, force reviews tab open
    private function redirect_with_error( $message ) {
        $redirect = wp_get_referer() ? wp_get_referer() : home_url();
    
        // Add error + nonce
        $redirect = add_query_arg( array(
            'review_error'   => rawurlencode( $message ),
            '_review_nonce'  => wp_create_nonce( 'review_error_nonce' ),
        ), $redirect );
    
        // Force reviews tab open
        $redirect .= '#reviews';
    
        wp_safe_redirect( $redirect );
        exit;
    }
   
}
    add_action( 'comment_form_before', function() {
        if ( isset( $_GET['review_error'], $_GET['_review_nonce'] ) ) {
            $nonce = sanitize_text_field( wp_unslash( $_GET['_review_nonce'] ) );
    
            if ( wp_verify_nonce( $nonce, 'review_error_nonce' ) ) {
                $error_msg = sanitize_text_field( wp_unslash( $_GET['review_error'] ) );
    
                if ( ! empty( $error_msg ) ) {
                    echo '<p class="woocommerce-error" style="color:red; margin:10px 0;">' . esc_html( $error_msg ) . '</p>';
                }
            }
        }
    });

new SDWC_Review_Captcha();
