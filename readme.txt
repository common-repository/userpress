=== Plugin Name ===
Contributors: booruguru, shastapete
Tags: wiki, collaborative, buddypress, bbpress, frontend, subscriptions, multisite
Requires at least: 3.7
Tested up to: 3.8.1
Stable tag: 1.2.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


UserPress is a collaborative media (wiki) platform built for WordPress.



== Description ==
UserPress allows you to turn your WordPress site into a powerful wiki platform.

This plugin includes a theme specifically designed for UserPress, but you can use virtually any WordPress theme you desire.

We infrequently check the WordPress support forums so if you need help or would like to offer feedback please visit our official website  http://www.userpress.org


== Installation ==

1. Upload `userpress.zip`via your wp-admin plugins manager.

2. Update your permalinks (via the wp-admin settings page) once the plugin is activated. (Make sure your permalinks use post-names/prettylinks in their URIs).

3. Done. Visit yourwebsite.com/wiki/frontpage/ in order to view your new wiki section.

Additional documentation can be found at http://www.userpress.org


== Screenshots ==

1. Wiki Page for logged-in user
2. Wiki Edit Screen 
3. Subscriptions Management (via UserPress + BuddyPress)

== Frequently Asked Questions ==

= How can I access my wiki home page? =

http://yourwebsite.com/wiki/frontpage/

Once you activate UserPress, a wiki page called "Frontpage" is automatically created. This will serve as the main page of your WordPress wiki (http://yourwebsite.com/wiki/frontpage/). 

Also, if you try to access "http://yourwebsite.com/wiki/" UserPress will automatically forward you to the frontpage.


= How can I post wiki articles? =

You can post wiki articles by visiting "http://yourwebsite.com/wiki/?action=create". (You can post wiki articles using wp-admin under the "Wiki" sidebar menu item.) 


== Changelog ==

= 1.2.8 =

* fixed "create new page" error

= 1.2.7 =

* fixed bpsubscriptions default letter-spacing
* changed usertheme header bottom-border from 2px to 1px
* added placeholder to create new wiki sub-page title field
* changed "leave a reply" to "post a reply" but only for UserTheme
* fixed featured image issue on "create new wiki" page
* added underline to h3 CSS
* h3 automatically formatted  if it is the first line in the content
* fixed page tree css glitch on 404 pages