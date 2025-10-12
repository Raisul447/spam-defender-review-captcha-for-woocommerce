<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action('admin_menu', 'sdwc_register_settings_page');
function sdwc_register_settings_page() {
    add_options_page(
        esc_html__( 'WC Review Captcha Settings', 'spam-defender-review-captcha-for-woocommerce' ),
        esc_html__( 'WC Review Captcha', 'spam-defender-review-captcha-for-woocommerce' ),
        'manage_options',
        'sdwc-settings',
        'sdwc_settings_page_html'
    );
}

add_action('admin_init', 'sdwc_register_settings');
function sdwc_register_settings() {
    register_setting('sdwc_settings_group', 'sdwc_recaptcha_keys', array('sanitize_callback' => 'sdwc_sanitize_keys') );
}

function sdwc_sanitize_keys( $input ) {
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

function sdwc_settings_page_html() {
    $keys = get_option('sdwc_recaptcha_keys', array('site_key' => '', 'secret_key' => ''));
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('WC Review Captcha Settings', 'spam-defender-review-captcha-for-woocommerce'); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('sdwc_settings_group'); ?>
            <?php do_settings_sections('sdwc-settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Site Key', 'spam-defender-review-captcha-for-woocommerce'); ?></th>
                    <td><input type="text" name="sdwc_recaptcha_keys[site_key]" value="<?php echo esc_attr($keys['site_key']); ?>" size="50"/></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Secret Key', 'spam-defender-review-captcha-for-woocommerce'); ?></th>
                    <td><input type="text" name="sdwc_recaptcha_keys[secret_key]" value="<?php echo esc_attr($keys['secret_key']); ?>" size="50"/></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
