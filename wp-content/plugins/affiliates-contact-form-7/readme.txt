=== Affiliates Contact Form 7 Integration ===
Contributors: itthinx
Donate link: https://www.itthinx.com/shop/
Tags: affiliate, affiliates, affiliate marketing, referral, growth marketing, ads, advertising, marketing, affiliate plugin, affiliate tool, cf7, contact form, Contact Form 7, CRM, e-commerce, earn money, integration, lead, lead tracking, leads, marketing, money, partner, links, referrer, team, teams, track, transaction
Requires at least: 5.6
Tested up to: 6.0
Requires PHP: 5.6.0
Stable tag: 5.3.0
License: GPLv3

Affiliates plugin integration for Contact Form 7. Collect form data & track submissions. Lead tracking, sales, support ...

== Description ==

This plugin integrates with [Affiliates](https://wordpress.org/plugins/affiliates/), [Affiliates Pro](https://www.itthinx.com/shop/affiliates-pro/) and [Affiliates Enterprise](https://www.itthinx.com/shop/affiliates-enterprise/) with [Contact Form 7](https://wordpress.org/plugins/contact-form-7).


**Data storage & referrals**

This integration stores data from submitted forms and tracks form submissions to the referring affiliate.

Submissions through one or more forms handled by Contact Form 7 can generate referrals. This integration can generate referrals for all forms, restrict it to selected forms or exclude certain forms.


**Form data**

All submitted form data is stored and can be viewed on the administrative back end along with each referral. All or parts of submitted form data can be provided in notification emails to affiliates. Form data can also be displayed on the front through referral stats. This allows to display selected pieces of information for example to affiliates or sales team members.
Flexible referral amounts and currencies

Contact Form 7 forms can generate referrals with fixed amounts, rate-based amounts or based on custom methods. Forms can provide fixed referral amount or base amounts for rate calculations. Multi-currency systems are supported by Affiliates Pro and forms can provide different currencies in each submission.


**Notifications**

Basic notifications are supported by default with the free [Affiliates](https://wordpress.org/plugins/affiliates/) plugin but these do not support tokens.

Advanced notifications require the premium versions [Affiliates Pro](https://www.itthinx.com/shop/affiliates-pro/) or [Affiliates Enterprise](https://www.itthinx.com/shop/affiliates-enterprise/).
- Upon each form submission, this integration can send notification emails to the site admin as well as to the referring affiliate.
- Affiliate notification emails for affiliates are customizable and can include information provided in submitted forms.


**Application Suggestions**


*Lead tracking*

Sales leads who submit a form managed through Affiliates Pro for Contact Form 7 can be tracked down to the referring affiliate, so that commissions for offline or online sales can be credited to the affiliate. If desired, commissions that are determined upon form submission will appear as referral amounts along with each referral.


*Teams*

Sales and support teams can use Affiliates Pro for Contact Form 7 to delegate sales and support requests to the right team members. Create an affiliate account for each team member and use affiliate links to direct requests to each.


**Requirements**

- [Contact Form 7](https://wordpress.org/plugins/contact-form-7)
- [Affiliates](https://wordpress.org/extend/plugins/affiliates), [Affiliates Pro](https://www.itthinx.com/shop/affiliates-pro/) or [Affiliates Enterprise](https://www.itthinx.com/shop/affiliates-enterprise/)
- [Affiliates Contact Form 7 Integration](https://wordpress.org/plugins/affiliates-contact-form-7) (this plugin)

Install these, set up your forms, set up your own affiliate program and start gathering new leads!

**Documentation**

- Documentation page for Affiliates [Affiliates Contact Form 7 Integration](https://docs.itthinx.com/document/affiliates/setup/settings/integrations/contact-form-7/)
- Documentation page for Affiliates Pro [Affiliates Contact Form 7 Integration](https://docs.itthinx.com/document/affiliates-pro/setup/settings/integrations/contact-form-7/)
- Documentation page for Affiliates Enterprise [Affiliates Contact Form 7 Integration](https://docs.itthinx.com/document/affiliates-enterprise/setup/settings/integrations/contact-form-7/)

**Feedback**

__Feedback__ is welcome!
If you need help, have problems, want to leave feedback or want to provide constructive criticism, you can leave a comment here at the [plugin page](https://www.itthinx.com/plugins/affiliates-contact-form-7).

Please try to solve problems there before you rate this plugin or say it doesn't work. There goes a _lot_ of work into providing you with free quality plugins! Please appreciate that and help with your feedback. Thanks!

You are welcome to follow [@itthinx](https://twitter.com/itthinx) for updates on this and related plugins.

== Installation ==

1. Install and activate the [Contact Form 7](https://wordpress.org/plugins/contact-form-7) plugin, set up your forms.
2. Install and activate the [Affiliates](https://wordpress.org/plugins/affiliates) plugin. Use the default settings or configure it to your needs.
3. Install and activate the [Affiliates Contact Form 7 Integration](https://www.itthinx.com/plugins/affiliates-contact-form-7) plugin.
4. A new *Contact Form 7* menu item will appear under the *Affiliates* menu in WordPress. Follow the intructions to set up the integration there.

Note that you can install the plugins from your WordPress installation directly: use the *Add new* option found in the *Plugins* menu.
You can also upload and extract them in your site's `/wp-content/plugins/` directory or use the *Upload* option.

If you upgrade from *Affiliates* to *Affiliates Pro* or *Affiliates Enterprise*, the default referral rate should be set automatically under *Affiliates > Settings*.
Although this is done automatically, it is adviced to double-check that the settings have been adjusted correctly. 

== Frequently Asked Questions ==

= What features does this integration provide and where can I set it up? =

The plugin adds a new menu item *Affiliates > Contact Form 7* where details on the supported features and setup instructions are provided.

= How can I set the amount that affiliates earn on each sale? =

If you are using [Affiliates](https://wordpress.org/plugins/affiliates), go to *Affiliates > Contact Form 7* and set the rate and amount options there.

If you are using [Affiliates Pro](https://www.itthinx.com/shop/affiliates-pro/) or [Affiliates Enterprise](https://www.itthinx.com/shop/affiliates-enterprise/), also check the rate settings under *Affiliates > Settings*.

Example: If you want to give an affiliate 10% of each net total sales amount, set the rate to *0.1*.

== Screenshots ==

See also:

- Documentation page for Affiliates [Affiliates Contact Form 7 Integration](https://docs.itthinx.com/document/affiliates/setup/settings/integrations/contact-form-7/)
- Documentation page for Affiliates Pro [Affiliates Contact Form 7 Integration](https://docs.itthinx.com/document/affiliates-pro/setup/settings/integrations/contact-form-7/)
- Documentation page for Affiliates Enterprise [Affiliates Contact Form 7 Integration](https://docs.itthinx.com/document/affiliates-enterprise/setup/settings/integrations/contact-form-7/)

1. Settings
2. More settings
3. Referral recorded for a contact form submission
4. Referral recorded for a form with fixed amount
5. Referral recorded for a form that provides a base amount used to calculate the referral amount
6. Example form with a hidden fixed amount
7. Example form with a base-amount field

== Changelog ==

See [changelog.txt](https://github.com/itthinx/affiliates-contact-form-7/blob/master/changelog.txt).

== Upgrade Notice ==

This version is compatible with the latest versions of WordPress, Affiliates, Affiliates Pro and Affiliates Enterprise.
Support for formula-based rates requires Affiliates Pro 4.x or Affiliates Enterprise 4.x.
