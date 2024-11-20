# FHDCU Dynamic Counter Update

A dynamic counter plugin that increments by a random value every minute and saves it in the database for display anywhere on your site.

## Description

**FHDCU Dynamic Counter Update** is a simple yet powerful WordPress plugin designed to dynamically display a counter that updates itself every minute. The counter value is incremented by a random number (between 8 and 9) and saved to the database. You can easily display the counter anywhere on your site using a shortcode, and manually manage its value via an intuitive settings page in the WordPress admin.

### Key Features:
- **Dynamic Updates**: The counter automatically increases by a random value every minute.
- **Easy Integration**: Use the `[fhdcu_dynamic_counter]` shortcode to display the counter on any page or post.
- **Manual Reset**: Set or reset the counter value via the admin settings page.
- **Customizable Cron Job**: Runs on a lightweight, custom one-minute cron schedule.
- **Frontend Styling**: Includes default CSS and JavaScript for seamless integration.

## Installation 

1. Upload the `fhdcu-dynamic-counter-update` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress Plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add the `[fhdcu_dynamic_counter]` shortcode to any page or post where you want to display the counter.
4. Access **Counter Settings** from the WordPress admin menu to manually update or reset the counter value.

## Frequently Asked Questions

How do I display the counter?
Use the `[fhdcu_dynamic_counter]` shortcode in any page or post editor.

Can I customize the starting value of the counter? 
Yes, you can manually set a custom value from the **Counter Settings** page in the WordPress admin.

What happens when I deactivate the plugin?
The scheduled event that increments the counter is automatically cleared, and the counter will stop updating until the plugin is reactivated.

Can I style the counter? 
Yes, the plugin includes default CSS and JavaScript for styling, which can be overridden by adding custom styles in your theme or plugin.

### Changelog 

1.0
* Initial release:
  - Automatic counter increment every minute.
  - Admin settings page for manual counter management.
  - Shortcode `[fhdcu_dynamic_counter]` for displaying the counter.
  - Customizable cron schedule for lightweight performance.

### Usage 

To display the counter, simply add the following shortcode to a page or post:  
`[fhdcu_dynamic_counter]`  

The counter will dynamically update its value every minute.

### License

This plugin is licensed under the GPL v3 or later. For more information, visit the official license page:  
https://www.gnu.org/licenses/gpl-3.0.html
