=== Plugin Name ===
Contributors: alexanmtz
Donate link: http://www.alexandremagno.net
Tags: agenda, events, schedule, meeting, shows
Tested up to: "trunk"
Requires at least: 2.9
Tested up to: 3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A complete events manager for wordpress using the post type api, completely flexible, customizable and using the great jQuery plugin Full Calendar (http://arshaw.com/fullcalendar/), that means that you have a great events management with a rich interface for your blog and/or site users.

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

Another way is access the github page and make a download: https://github.com/alexanmtz/wp-agenda

[WordPress](http://github.com/ "Github wp-agenda site")

e.g.

1. Upload `wp-agenda` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Just go to agenda main page and start to create events!

Once the event is created, you can acessing http://yoursite/?agenda=show for see the full calendar of events, or even http://yoursite/?post_type=agenda for see the events lists.

== Frequently Asked Questions ==

== Screenshots ==

1. `/trunk/screenshot1.png`
1. `/trunk/screenshot2.png`
1. `/trunk/screenshot3.png`
1. `/trunk/screenshot4.png`
1. `/trunk/screenshot5.png`
1. `/trunk/screenshot6.png`

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.
