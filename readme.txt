=== Plugin Name ===
Contributors: alexanmtz
Donate link: http://www.alexandremagno.net
Tags: agenda, events, schedule, meeting, shows
Tested up to: "trunk"
Requires at least: 2.9
Tested up to: 3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A complete events manager for wordpress using the post type api, completely flexible, customizable and using the great jQuery plugin [Full Calendar](http://arshaw.com/fullcalendar/ "Full Calendar website"), that means that you have a great events management with a rich interface for your blog and/or site users.

== Description ==

Once installed, it will be possible create a event in a section called "Agenda". You will see a page like your seeing any post. But with this plugin, you will save information about start date, end date and about hours that start and ends. I hope I can make a integration with facebook later!

Well, you can have a fully customizable template just adding a agenda.php file as the main template, and then just insert this markup to make it works:

<div id="wp-agenda-calendar"></div>

This is the plugin features and that makes different of other ones around:

* Making a event manager of a wordpress way, the right way, using post-type to have fully customization.
* A rich UI for the calendar
* Easy event manager, with all the post features, as featured image

== Installation ==

This section describes how to install the plugin and get it working.

Another way is access the github page and make a download: [Github page](http://github.com/alexanmtz/wp-agenda "Github wp-agenda site")

e.g.

1. Upload `wp-agenda` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Just go to agenda main page and start to create events!

Once the event is created, you can acessing http://yoursite/?agenda=show for see the full calendar of events, or even http://yoursite/?post_type=agenda for see the events lists.

== Screenshots ==

1. `/trunk/screenshot1.png`
2. `/trunk/screenshot2.png`
3. `/trunk/screenshot3.png`
4. `/trunk/screenshot4.png`
5. `/trunk/screenshot5.png`
6. `/trunk/screenshot6.png`
=======
e.g.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= What's the different from others great Agenda Plugins out there? =

Well, my motivation to write this plugin is to use the new post-type introduced at version 3.0. This way I could use the wordpress post system to handler events as posts, and this way be categorized and treated as posts. Another thing is that I was wishing some flexible with the layout, so you can use a agenda template in your theme and it will be loaded!.

== Changelog ==

= 1.0 =
* first release. Rewriting the old wp-agenda from funarte website to a new post-type