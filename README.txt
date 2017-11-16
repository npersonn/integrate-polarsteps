=== Polarsteps Integration ===
Contributors: npersonn
Tags: travel, polarsteps
Requires at least: 3.0.1
Tested up to: 4.8
Stable tag: 4.8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress Plugin to integrate Travel Data from Polarsteps within a widget.

== Description ==

[Polarsteps.com](http://polarsteps.com/ "Polarsteps.com") offers a great way of log your travel experiences.
The app does record GPS Locations "Steps" and the user can add images and texts for them. However, for multiple reasons
a lot of travellers are having wordpress blogs existing while travelling.
If they still want to use Polarsteps and show the data on their wordpress instance, this plugin offers basic integration
between both worlds.

While being on my round the world trip, I was looking into several options how to back home from my journey. In the end
I thought a combination of a traditional blogging platform used to write posts and an app like Polarsteps offers most
flexibility for me while travelling. If me or my girlfriend wants to write an article we can do so and if it's just
about letting know everyone where I was, I could use polarsteps. Still, for the audience it is important to have all in
one place.

This plugin does a first approach in caching the steps on it's side and giving to the users a brief information where
and when a last location was set. Please note the plugin itself is not yet in a stable version.

I needed this this plugin to get work on my own blog. As I'm not part of the company behind polarsteps, I reached out
for them, in order to check, if they might support the plugin officially. Mainly due to business and UX reasons, they
responded they could not officially support my approach. This means the APIs on their side could change from one day to
another. In this case the plugin would stop getting new steps from your polarsteps profile.

== Installation ==

1. Register an account for Polarsteps (if not already done)
1. Install the plugin. Upload a zip-archive or upload `polarsteps-integration` directory to the `/wp-content/plugins/`
directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Obtain User (and Trip Id) from Polarsteps.com and add it to the plugins settings (see FAQs)
1. Install & Actviate Cronjob Plugin e.g. `Cronjob Scheduler`
1. Schedule the action `polarsteps_update_steps` whenever needed e.g. hourly
1. Add the widget on your page to see the last location ("Step") on your page

== Missing Functionality due to current state of Development ==
* Auto obtain User
* Support multiple trips by Trip Id
* Show all cached steps in the wordpress options and allow CRUD.
* Add Uninstall functionality (drop plugin table)

== Frequently Asked Questions ==

= How to get a User Id from Polarsteps? =

Inspect on your browser all the calls made, when open your trip on the polarsteps website. You find a XHR-call in this
scheme: `https://www.polarsteps.com/api/users/123456`. `123456` is your User Id.

= How to get a Trip Id from Polarsteps? =

Currently the plugin only supports having profiles with one trip. For now enter "0" here.


== Screenshots ==

* Nothing here yet.

== Changelog ==

= 0.1.0 =
* Initial Commit providing the base. Caching Steps on the Wordpress Db and showing them as a widget.


== Upgrade Notice ==

* Just a first approach. Nothing here yet.
