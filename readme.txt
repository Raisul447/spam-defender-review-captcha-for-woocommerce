=== Spam Defender – Review Captcha for WooCommerce ===
Contributors: shagor447
Tags: spam, captcha, reviews, woocommerce, security
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires Plugins: woocommerce

Add captcha to WooCommerce product reviews. Prevent spam reviews and ensure only real customers can submit reviews.
== Description ==
= Spam Defender – Review Captcha for WooCommerce helps you reduce spam product reviews by adding a captcha verification before review submission. =

With this plugin, customers must solve a captcha before submitting a review, which ensures that only genuine users can leave feedback on your WooCommerce products.
**Features:**
* Adds captcha to WooCommerce product review forms.
* Blocks spam bots from auto-submitting fake reviews.
* Lightweight and easy to use.
* No coding knowledge required.
* Compatible with latest versions of WordPress and WooCommerce.
This plugin provides a simple but effective solution to keep your product reviews section clean and trustworthy.

== External services ==

This plugin uses **Google reCAPTCHA** to protect the WooCommerce product review submission form from spam and automated bots.

It connects to the Google reCAPTCHA service in two ways:
1. **Frontend Integration:** It loads the reCAPTCHA JavaScript API from `https://www.google.com/recaptcha/api.js` on the product page to display the captcha challenge.
2. **Server-Side Verification:** When a user submits a review, the plugin sends the reCAPTCHA response token to Google's verification endpoint (`https://www.google.com/recaptcha/api/siteverify`) along with the **Secret Key** and the user's **IP address** to confirm the validity of the captcha challenge. This data is sent only upon review submission.

* **Service:** Google reCAPTCHA
* **Purpose:** Spam and bot protection for WooCommerce product reviews.
* **Data Sent:**
    * **Reviewer's IP address** (Sent to Google for verification when a review is submitted).
    * **reCAPTCHA response token** (Sent to Google for verification when a review is submitted).
* **Terms of Service and Privacy Policy:**
    * Google Terms of Service: [https://policies.google.com/terms](https://policies.google.com/terms)
    * Google Privacy Policy: [https://policies.google.com/privacy](https://policies.google.com/privacy)

== Installation ==
1. Upload the `spam-defender-review-captcha-for-woocommerce` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the ‘Plugins’ menu in WordPress.
3. Navigate to **Dashboard > Settings > Woocommerce Review Captcha** and click to configure reCaptcha API setup.

== Frequently Asked Questions ==

= Does this work only with WooCommerce reviews? =  
Yes, this plugin specifically adds captcha to WooCommerce product review forms.

= Do I need to configure anything? =  
Yes, once activated, you’ll need to enter your reCAPTCHA API credentials to complete the setup.

= Is it compatible with other captcha plugins? =  
This plugin is specifically designed for WooCommerce product reviews. However, if you use another plugin for the same purpose, it may cause conflicts.

= Will it affect site performance? =  
No, the plugin is lightweight and optimized for speed.

== Screenshots ==
1. reCAPTCHA API credentials configure page.
2. Captcha displayed in WooCommerce product review form.
3. Error message shown if captcha is not solved.

== Changelog ==

= 1.0.2 =
* Tested with the latest WordPress release.
* Fixed minor bugs and performance issues.
* Security checks and improvements applied.

= 1.0.1 =
* Initial release.
* Added captcha to WooCommerce product review form.
* Prevents review submission without solving captcha.

= Update  Notice =
Version 1.0.2 has been released as a stable version.
