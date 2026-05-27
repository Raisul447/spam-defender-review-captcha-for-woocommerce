=== Spam Defender – Review Captcha for WooCommerce ===
Contributors: shagor447
Tags: spam, captcha, reviews, woocommerce, security
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires Plugins: woocommerce

Add captcha to WooCommerce product reviews. Prevent spam reviews and ensure only real customers can submit reviews.

== Description ==
= Spam Defender – Review Captcha for WooCommerce helps you reduce spam product reviews by adding a captcha verification before review submission. =

With this plugin, customers must solve a captcha before submitting a review, which ensures that only genuine users can leave feedback on your WooCommerce products.

**Features:**
* Support for both Google reCAPTCHA v2 and Cloudflare Turnstile.
* Adds captcha to WooCommerce product review forms.
* Blocks spam bots from auto-submitting fake reviews.
* Lightweight and easy to use.
* No coding knowledge required.
* Compatible with latest versions of WordPress and WooCommerce.

This plugin provides a simple but effective solution to keep your product reviews section clean and trustworthy.

== External services ==

This plugin uses external services to protect the WooCommerce product review submission form from spam and automated bots. Depending on your configuration, it connects to one of the following:

### Google reCAPTCHA
1. **Frontend Integration:** It loads the reCAPTCHA JavaScript API from `https://www.google.com/recaptcha/api.js` on the product page to display the captcha challenge.
2. **Server-Side Verification:** When a user submits a review, the plugin sends the reCAPTCHA response token to Google's verification endpoint (`https://www.google.com/recaptcha/api/siteverify`) along with the **Secret Key** and the user's **IP address** to confirm the validity of the captcha challenge.

* **Service:** Google reCAPTCHA
* **Purpose:** Spam and bot protection for WooCommerce product reviews.
* **Data Sent:** Reviewer's IP address and reCAPTCHA response token.
* **Terms of Service and Privacy Policy:**
    * Google Terms of Service: https://policies.google.com/terms
    * Google Privacy Policy: https://policies.google.com/privacy

### Cloudflare Turnstile
1. **Frontend Integration:** It loads the Turnstile JavaScript API from `https://challenges.cloudflare.com/turnstile/v0/api.js` on the product page to render the Turnstile widget.
2. **Server-Side Verification:** When a user submits a review, the plugin sends the Turnstile response token to Cloudflare's verification endpoint (`https://challenges.cloudflare.com/turnstile/v0/siteverify`) along with the **Secret Key** and the user's **IP address** to confirm the validity of the Turnstile challenge.

* **Service:** Cloudflare Turnstile
* **Purpose:** Privacy-friendly, non-intrusive spam and bot protection.
* **Data Sent:** Reviewer's IP address and Turnstile response token.
* **Terms of Service and Privacy Policy:**
    * Cloudflare Privacy Policy: https://www.cloudflare.com/privacypolicy/
    * Cloudflare Website Terms: https://www.cloudflare.com/website-terms/

== Installation ==
1. Upload the `spam-defender-review-captcha-for-woocommerce` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the ‘Plugins’ menu in WordPress.
3. Navigate to **Dashboard > Settings > Woocommerce Review Captcha** to configure Google reCAPTCHA or Cloudflare Turnstile API setup.

== Frequently Asked Questions ==

= Does this work only with WooCommerce reviews? =  
Yes, this plugin specifically adds captcha to WooCommerce product review forms.

= Do I need to configure anything? =  
Yes, once activated, you’ll need to select your captcha provider and enter your API credentials (Site Key and Secret Key) to complete the setup.

= Is it compatible with other captcha plugins? =  
This plugin is specifically designed for WooCommerce product reviews. However, if you use another plugin for the same purpose, it may cause conflicts.

= Will it affect site performance? =  
No, the plugin is lightweight and optimized for speed.

== Screenshots ==
1. Admin dashboard page with captcha provider options.
2. Google reCAPTCHA displayed in WooCommerce product review form.
3. Cloudflare Turnstile displayed in WooCommerce product review form.
4. Error message shown if captcha is not solved.

== Changelog ==

= 1.2.0 =
* Added support for Cloudflare Turnstile as a privacy-friendly, non-intrusive alternative to Google reCAPTCHA.
* Redesigned the admin settings dashboard with a premium, responsive layout, interactive cards, status indicators, and detailed setup guides.
* Fully tested and supported with the latest WordPress 7.0 release.

= 1.0.2 =
* Tested with the latest WordPress release.
* Fixed minor bugs and performance issues.
* Security checks and improvements applied.

= 1.0.1 =
* Initial release.
* Added captcha to WooCommerce product review form.
* Prevents review submission without solving captcha.

== Upgrade Notice ==
Version 1.2.0 has been released as a stable version with Cloudflare Turnstile support and a redesigned admin interface.
