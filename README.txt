=== Polarsteps Integration ===
Contributors: npersonn
Tags: travel, polarsteps, travel blog, travelmap,
Requires at least: 3.0.1
Tested up to: 5.0.1
Requires PHP: 7.0
Stable tag: 4.9.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress Plugin to integrate Travel Data from Polarsteps within a widget.

== Description ==

[Polarsteps.com](http://polarsteps.com/ "Polarsteps.com") offers a great way of logging your travel experiences. The app does record GPS Locations "Steps". The user can add images and texts for them. However, for multiple reasons, a lot of travelers are having WordPress travel blogs up and running. If they still want to use Polarsteps and show their last location in their WordPress instance, this plugin offers basic integration between both worlds.

While being on my round the world trip, I was looking into several options how to communicate back home from my journey. In the end, I thought a combination of a traditional blogging platform used to write posts and an app like Polarsteps offers the most flexibility for me while traveling. If my girlfriend or I want to write an article what happened in the last days (for multiple locations) we can do so. If it's just about letting everyone know where I was, I use polarsteps travel tracker. Still, for the audience it is important to have all in one place - and have a single point of knowledge.

This plugin does the first approach to caching the "Steps" on WordPress-side and giving to the users a brief information within a widget where and when the last location within polarsteps was set.

See the Github-Repo here: [https://github.com/npersonn/integrate-polarsteps](https://github.com/npersonn/integrate-polarsteps "https://github.com/npersonn/integrate-polarsteps")

== Disclaimer ==

As I'm not part of the company behind Polarsteps and just developed the plugin for personal purposes, I reached out to them, in order to check, if they might support the plugin officially. Mainly due to business and UX reasons, they responded they could not officially support my approach. This means the APIs on their side could change from one day to another. In this case, the plugin would stop getting new steps from your Polarsteps profile.

== Installation ==

1. Register an account for Polarsteps (if not already done)
1. Install the plugin. Upload a zip-archive or upload `polarsteps-integration` directory to the `/wp-content/plugins/`
directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Obtain Username (and if needed Trip Id) from Polarsteps.com and add it to the plugin's settings (see FAQs)
1. Create Trip (with at least one Step) on Polarsteps.com and make sure it is public
1. If WP-Cron is not activated. Install & activate Cronjob Plugin e.g. `Cronjob Scheduler`
1. Schedule the action `polarsteps_update_steps` whenever needed e.g. hourly
1. Add the widget to your page to see the last location ("Step") on your page

== Frequently Asked Questions ==

= How to get my Username from Polarsteps? =

You registered with a unique Username on Polarsteps. This Username is used in the Polarsteps Settings.

= How to get a Trip Id from Polarsteps? =

Currently, the plugin only supports having profiles with one trip. For now enter "0" here.

= I don't see a Recent Location in the Widget =

Check the Settings (Settings > Polarsteps Settings), if the username is correctly set.
If the username is correct, on save the data is fetched. Afterwards, last step is shown in a notice.

= My Widget "Recent Location" is not updating =

Make sure that either WP-cron is activated or a Cronjob plugin is successfully triggering the action `polarsteps_update_steps`. 
Furthermore, the polarsteps account needs to have public trips. If the user exists but no trip nor steps, naturally the plugin cannot show your recent location.

= I want to customize my Widget =
Feel free to edit the CSS-classes `polarsteps_widget`, `polarsteps_location_name_href`, `polarsteps_start_time` and `polarsteps_country_flag` to your needs.

== Screenshots ==

1. Homepage Example - Show your last step in a widget

== Changelog ==

= 0.4.0 =
* Use cUrl for API-Calls
* Add scalar Typehints

= 0.3.5 =
* Bugfix: Adapt Connector due to breaking change on `users` endpoint
* Use api.polarsteps.com instead of www.polarsteps.com

= 0.3.4 =
* Usability: Validating, if a Username exists on Settings Change
* Bugfix: If a User exists, but does not have a public trip an error is logged.

= 0.3.3 =
* Usablity: Updating & showing the recent location in the options, after a username is changed

= 0.3.2 =
* Fixing issue on Admin-page, not showing the correct polarsteps_username

= 0.3.1 =
* Fixing issue of incomplete data-sets from API. Added Update-Query for missing location names

= 0.3.0 =
* Updated Settings. Instead of a UserId, only the username is now needed
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

* From Version 0.4.0 the plugin needs cUrl and it's PHP-extension installed.
