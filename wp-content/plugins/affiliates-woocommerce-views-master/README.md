# Affiliates WooCommerce Views #

Views toolbox for the Affiliates WooCommerce integrations.

## Description ##

Views toolbox for the Affiliates WooCommerce integrations.

This plugin requires:

- Affiliates, Affiliates Pro or Affiliates Enterprise
- WooCommerce

This currently provides the `[affiliates_woocommerce_orders]` shortcode which
is used to show order details for an affiliate's referrals.

Recommended usage: Use it along with the stats shortcode provided by
Affiliates Pro (and Enterprise):

>Your referrals overview:
>`[affiliates_affiliate_stats /]`
>
>Related orders:
>`[affiliates_woocommerce_orders]`

The date fields provided by the `[affiliates_affiliate_stats /]` shortcode
affect what is displayed with the `[affiliates_woocommerce_orders]` shortcode,
so that an affiliate can see a summary of referral results and the details of
the corresponding orders.  

The `[affiliates_woocommerce_orders]` shortcode supports the following
attributes:

- status - defaults to "accepted"
- from - from date
- until - until date
- for - show data for the current "day", "week" or "month", not provided by default
- order_by - "date" (default" or "amount"
- order - "ASC" or "DESC" for ascending or descending order
- limit - to limit the number of results displayed, no limit is used by default
- auto_limit - to limit the number of results displayed when no from or until dates are given, "20" by default
- show_limit - a message shown before results stating "Showing up to %d orders.", %d is a placeholder for the limit used

## Installation ##

1. Upload or extract the `affiliates-woocommerce-views` folder to your site's `/wp-content/plugins/` directory. You can also use the *Add new* option found in the *Plugins* menu in WordPress.  
2. Enable the plugin from the *Plugins* menu in WordPress.

## Frequently Asked Questions ##

= Why would I want this? =

Currently you would want it to show order information to affiliates.

## Screenshots ##

None available. Try it out.

## Changelog ##

= 1.0.0 =
* Provides the [affiliates_woocommerce_orders] shortcode.

## Upgrade Notice ##

= 1.0.0 =
* Initial release.
