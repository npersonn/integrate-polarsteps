=== Polarsteps Integration ===
Contributors: npersonn
Tags: travel, polarsteps
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 4.8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress Plugin to integrate Travel Data from Polarsteps within a widget.

== Description ==

[Polarsteps.com](http://polarsteps.com/ "Polarsteps.com") offers a great way of log your travel experiences. The app does record GPS Locations "Steps". The user can add images and texts for them. However, for multiple reasons a lot of travellers are having wordpress travel blogs up and running. If they still want to use Polarsteps and show the data on their wordpress instance, this plugin offers basic integration between both worlds.

While being on my round the world trip, I was looking into several options how to back home from my journey. In the end I thought a combination of a traditional blogging platform used to write posts and an app like Polarsteps offers most flexibility for me while travelling. If me or my girlfriend wants to write an article we can do so and if it's just. about letting know everyone where I was, I could use polarsteps. Still, for the audience it is important to have all in one place.

This plugin does a first approach in caching the steps on it's side and giving to the users a brief information where and when a last location was set. Please note the plugin itself is not yet in a stable version.

As I'm not part of the company behind polarsteps and just developed the plugin for personal purposes, I reached out for them, in order to check, if they might support the plugin officially. Mainly due to business and UX reasons, they responded they could not officially support my approach. This means the APIs on their side could change from one day to another. In this case the plugin would stop getting new steps from your polarsteps profile.

If you like this approach or want to support in the development [https://github.com/npersonn/integrate-polarsteps](https://github.com/npersonn/integrate-polarsteps "https://github.com/npersonn/integrate-polarsteps")

== Installation ==

1. Register an account for Polarsteps (if not already done)
1. Install the plugin. Upload a zip-archive or upload `polarsteps-integration` directory to the `/wp-content/plugins/`
directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Obtain User (and Trip Id) from Polarsteps.com and add it to the plugins settings (see FAQs)
1. If WP-Cron is not activated. install & actviate Cronjob Plugin e.g. `Cronjob Scheduler`
1. Schedule the action `polarsteps_update_steps` whenever needed e.g. hourly
1. Add the widget on your page to see the last location ("Step") on your page

== Missing Functionality due to current state of Development ==
* Auto obtain User
* Support multiple trips by Trip Id
* Show all cached steps in the wordpress options and allow CRUD.

== Frequently Asked Questions ==

= How to get a User Id from Polarsteps? =

Inspect on your browser all the calls made, when open your trip on the polarsteps website. You find a XHR-call in this
scheme: `https://www.polarsteps.com/api/users/123456`. `123456` is your User Id.

= How to get a Trip Id from Polarsteps? =

Currently the plugin only supports having profiles with one trip. For now enter "0" here.


== Screenshots ==

* Nothing here yet.

== Changelog ==

= 0.3.0 =
* Using Wp-Cron to Schedule Updates
* Added pot-File for I18n

= 0.2.0 =
* Added Deeplink for Recent Location Widget
* Extended Database Schema for deeplink generation

= 0.1.1 =
* Updated Descriptions
* Added Plugin Icons

= 0.1.0 =
* Initial Commit providing the base. Caching Steps on the Wordpress Db and showing them as a widget.


== Upgrade Notice ==

* Just a first approach. Nothing here yet.
