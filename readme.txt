=== Plugin Name ===
Contributors: BeyondPrograms
Donate link: http://beprosoftware.com/
Tags: listings, google map,poi, map, map markers, map icons, wp maps, buddypress, multisite, directory, video, images, gallery, shop finder, business locations, shop locator,  geocoding, front end, submission, upload, Classifieds, Job Search, documents, Real Estate, Geotag,
Requires at least: 3.0.1
Tested up to: 3.7.1
Stable tag: 2.0.61
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Searchable listings (gallery, directory, maps, etc) on any page or post. Now buddypress & multisite compatable.

== Description ==
BePro Listings allows you to list anything incluing, images, documents, and videos. Shortcodes & widgets help you to search and showcase this information in various formats including multiple listing templates and google maps. With better control over wordpress core features and lots of addons, this is the perfect foundation for your listings site. 

Visit the plugin page for examples and details http://www.beprosoftware.com/products/bepro-listings/

= Popular Uses =

This plugin is best utilized by those looking to implement listing type features into their own custom design. Setup core wordpress featues, as well as new aspects like, # of uploads, default search distance, and page details. With the new buddypress option, you can allow your members to control their own submissions (add/edit/delete). Look at some of the ways people are using the plugin:

* Store Finder - List your stores including, location and contact details 
* Directory - Employee, Business, Classifieds, Job Search, Fleet Tracking, Job Board, or any other type of listings site
* Products & Services - List them yourself or allow members to list products and/or services
* Informational - Tourism, points of interest, and other details best shown via map
* User Contributions - Using the submission form shortcode, let users contribute blog posts for you to review and publish
* Image website - Artists are using the new features to show just images in listing results.
* Video Listings - You can setup the plugin to feature videos only (uploaded and/or linked)
* Document Gallery - Showcase multiple file types and have them show up in listings
* Real Estate - Perfect way to showcase, buildings, apartments, hotels, and other locations
* Geotag - Add location information to, documents, images, videos, etc. 

= KEY FEATURES =
We are constantly developing new features for this plugin. The hope is to continue providing options for a) retrieving b) displaying and c) engaging your members with the Information like ($Cost, @Contact, &deg;Lat/Lon) 

* Buddypress - (New for 1.2.0) Allow your users to manage their submissions from their profile.
* Custom posts - Listings are seperate to your other posts in the admin and front end.
* Listing Categories - Custom Taxonomies with the ability to add images and list them.
* Listings - Two templates come with the base plugin and they can be extended.
* Google Maps api v3.5 - Great for showing listings via a map with no need for API keys.
* Submission Form - Give users a quick way to submit a listing without being logged in.
* Validations - User Form Submissions are validated using jQuery.
* Search Features - Allow users to search by name, location, or various filterable options.
* Wordpress Integration - Admin/features are familiar and integrate with your existing theme.
* Hooks & Filters - Developers will love the documentation & ability to easily extend features.
* Shortcodes & Widgets - Several ways to feature the information and engage your visitor.
* Admin Options - Control the ability for users to intereact with features and information.
* Multisite - Now multisite compatible, expand the use of this plugin throughout your network.

= ADD ONS =

Since version 2.0.0, you can now expand on the features of BePro Listings. We have added tons of wordpress hooks and filters to the system. We have also improved how our templates are implemented. This provides lots of new ways to customize your listings experinece. Current available add-ons include:

* Tags - This was definitely an achilles heel for this plugin. Now you and your members can tag your listings and allow users to search them via the tag widget
* Contact - Add a contact form to your listing pages. This provides the option to have all emails go to one address or the address for the person who created the listing
* Gallery - Update the stock wordpress gallery with this lightbox option and better design
* Video - Improve on the Gallery plugin with the ability to add and feature videos in your listings from, youtube, vimeo and uploaded documents (mp4, mpeg, avi, wmv, webm, etc)
* Documents - Allow users to add and manage document listings on your website from the front end (zip, doc, pdf, odt, csv, etc)
* Icons - Tons of google map icons from the "Map Icons Collection" by Nicolas Mollet

= SHORTCODES =

* Dynamic Map - Setup a map anywhere showing the last listings on your site e.g. [generate_map]
* Basic Search - Allow users to search listings e.g. [search_form]
* Filter Search - Allow users to do a more in depth search including, cost, date, etc e.g. [filter_form]
* Listings - Show listings with optional paging e.g. [display_listings]
* Add Listing Form - Give your users the ability to create listings. You can set a default user id for the listing or force registration. e.g. [create_listing_form]

= TROUBLE SHOOTING =

* 404 Error - If Listing pages produce a 404 error, try resetting your permalink settings in the admin. Simply re-save your current settings so that they are reset for all urls. The option is under your settings menu.

= TRANSLATIONS =

Currently, this plugin supports, English, French, and Spanish.


== Installation ==

* Download the plugin files to your plugin directory and activate.

* Consider altering the options located under the newly created admin menu for BePro Listings

* Use shortcodes and/or widgets for user interaction

* Re-save your current permalink settings

* Install any available add-ons

== Frequently Asked Questions ==

= Does this work with posts and pages? =

Yes, it works anywhere shortcodes are accepted

= Do shortcodes and widets work together? =

Yes, if they are on the page where a form submission is received, they will react to the submission

= How can I customize the layout? =

You should alter the /css/bepro_listings.css file as needed

= Can I add Markers to the Map? =

Markers are generated by posts which match a search criteria. To have a marker on the map, you must have created a post. 

= What is the Map showing by default? =

The latest X listings added to the system

= How to make markers react on click instead of hover? =

[generate_map pop_up=1]

= Why is the map not reacting to the listings table page change? =

[generate_map paging=1]

= Does the map have its own paging display? =

Not currently. Do you think that would be a good feature?

= Is there support? =

Yes, our development team created the plugin and continue to offer support via support@beprosoftware.com 

= I need more features, is there more? =

Yes, there add-ons available for this plugin. Check our website beprosoftware.com/shop

= Can this work with buddypress? =

Since 1.2.0. Version 2.0.60 added integration with activity feeds

= Does your user submission form implement custom profile fields? =

No, not currently. Is this a feature you are interested in?

= What if i dont want to link to the created listing page? =

Simply set the post to private in the admin.

= Are there ways to extend the features? =

Yes, there are lots of hooks/filters and templates (listings/page)

== Screenshots ==

1. Listings example
2. Search and filter Listings
3. Listing page with addons
4. Buddypress Profile listing Manager
5. Manage Listings
6. Configure Listing Options


== Changelog ==

= 1.0.1 (Monday, Oct 1st 2012) = * Stable with Several fixes

= 1.0.2 (Monday, Oct 1st 2012) = * Stable with fixes

= 1.1.0 (Sunday, Oct 7st 2012) = * global settings for cost/contact/geo & num images

= 1.1.1 (Friday, Oct 12th 2012) = * css changes, widget fix, more info

= 1.2.0 (Sunday, Oct 14th 2012) = * buddypress and some hooks

= 1.2.1 (Sunday, Oct 21st 2012) = * conflick error and css fixes

= 1.2.2 (Tuesday, Oct 30st 2012) = * user create featured image

= 1.2.21 (Wednesday, Jan 16st 2012) = * error checks

= 1.2.3 (Thursday, April 11th 2013) = * wordpress 3.5 and multisite compatible

= 1.2.32 (Monday, April 22nd 2013) = * fix issue when uploading images

= 1.2.33 (Saturday, May 4th 2013) = * fix issue regarding the retrieval of lat/lon

= 1.2.34 (Tuesday, May 28th 2013) = * fix issue regarding country when clicking listing map links

= 1.2.35 (Sunday, Jul 28th 2013) = * fix text domain languages and map markers

= 2.0.0 (Sunday, Dec 1st 2013) = * Major fix improving compatability and features

= 2.0.2 (Monday, Dec 2nd 2013) = * Minor tweaks to new 2.0.0 release

= 2.0.3 (Tuesday, Dec 3rd 2013) = * Dynamically load listings templates in line with 2.0.0 standards

= 2.0.54 (Friday, Dec 6th 2013) = * Major fixes to submission form, document handling, and error messages

= 2.0.57 (Friday, Dec 6th 2013) = * Improve map and new options for front end form

= 2.0.60 (Thursday, Dec 12th 2013) = * Add listing activity to buddypress feed

== Upgrade Notice ==

None