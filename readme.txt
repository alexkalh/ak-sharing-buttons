=== AK Sharing Buttons ===
Tags: facebook, google, twitter, linkedin, pinterest, share, share buttons, share links
Requires at least: 3.9
Tested up to: 4.2.2
Stable tag: 1.0.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Contributors: Alex Kalh

http://colourstheme.com/forums/forum/wordpress/plugin/ak-sharing-buttons/

== Description ==

Ajax load and append a list of sharing button to single-post, static-page. Ex: facebook, twitter, pinterst, google-plus, linkedin.

After event window.load, your website send an ajax request, and get back a list of socials link. And append it to the end of "the_content".

This plugin only working with is_singular().

== Installation ==

Upload and install AK Sharing Buttons in the same way you'd install any other plugin.

== Screenshots ==

1. Sharing buttons with single post, page
2. Sharing buttons with bbPress forums, topic

== Documentation ==

[Documentation](http://colourstheme.com/forums/forum/wordpress/plugin/ak-sharing-buttons/) is available on ColoursTheme.

== Changelog ==

= 1.0.1 (2015.06.18) =
+ remove: constant "AKSB_SECURITY_KEY"
+ edit function "add_security_key": replace AKSB_SECURITY_KEY by string "aksb_load_sharing_buttons"
+ add conditional: the sharing button only display if "post_content" is not null.

= 1.0.0 (2015.06.16) =
Release the first version!
