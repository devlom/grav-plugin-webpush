# Web Push Notifications Plugin

![Web Push Notifications](readme.png)


The **Web Push Notifications** Plugin is for [Grav CMS](http://github.com/getgrav/grav) based on [OneSignal](http://onesignal.com) service. Web push notifications are messages that come from a website. You get them on your desktop or device even when the website is not open in your browser. It is a new marketing channel to re engage your site visitors without knowing their email or other contact details. All major browsers support Web Push. Android devices may also receive Web Push notifications, in addition to notifications from apps.

## Some of OneSignal features
* 15 Minute Setup
* Real Time Tracking
* Incredibly Scalable
* A/B Test Messages
* Segmentation Targeting
* Automatic Delivery
* Supports Chrome, Firefox, Safari, Microsoft Edge, Opera, Yandex, Samsung Browser, UC Browser, Interner Explorter and all Android browsers.

## Why should you use Web Push Notifications – what are the advantages?
* WEB-SCALE REACH - Chrome, Firefox, and Safari combined have a market share of 75%+, meaning the reach of web push notifications is nearly a billion users.
* NO NEED FOR ANDROID APP - Web push notifications work exactly like the native mobile push on Android, so you don’t have to create a mobile app to send native push notifications.
* ACCESS TO USERS WHO ARE NOT ON YOUR WEBSITE - Using web push notifications, you can reach out to those users who are not on your website.
* RE-ENGAGEMENT WITHOUT CONTACT DETAILS - Web push notifications don’t need a user’s email or other contact details.
* GREATER OPT-IN RATE - It's easier for users to sign up for Web Push than email, which results in higher opt-ins than email.
* LOWER UNSUBSCRIBE / OPT-OUT RATES - Studies have shown that less than 10% of the subscribers who opted for notifications from a site unsubscribed in a year.
* BETTER DELIVERY - Emails sometimes fail to deliver or get marked as spam, while notifications have more prompt and assured delivery.
* HIGHER CONVERSION RATES - Studies have shown that web push notifications have 30 times higher conversion when compared with email.
* STAY TOP OF MIND - Sending notifications even when the users are not on your website helps you stay top of mind with users, especially if they've previously engaged (such as adding content to a cart on your site).

## Installation

Installing the Web Push Notifications plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install webpush

This will install the Web Push Notifications plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/webpush`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `webpush`. You can find these files on [GitHub](https://github.com/hexplor/grav-plugin-webpush) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/webpush
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

## Configuration
Before configuring this plugin, you should copy the `user/plugins/webpush/webpush.yaml` to `user/config/plugins/webpush.yaml` and only edit that copy.

Firstly you will need to register your app / website with Twitters developer site. (https://dev.twitter.com) you will then get your consumer key, consumer secret, access token and your access token secret. You then need to add them to your config file.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
twitter_id: devlomthemes #twitter screen name, owner in Access Token settings
tweets_to_display: 5, # Number of tweets you would like to display.
ignore_replies : true # Ignore replies from the timeline. 
include_rts: true # Include retweets. 
consumerkey: XXX #Consumer Key (API Key)
consumersecret: XXX #Consumer Secret (API Secret)
accesstoken: XXX #Access Token
accesstokensecret: XXX #Access Token Secret
built_in_css: true 
fontawesome: true
```

Note that if you use the admin plugin, a file with your configuration, and named webpush.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

Usage
========================
Use webpush/templates/partials/webpush.html.twig template with built in styling or build your own theme. 

Notes
========================

Twitter feeds may contain UTF-8 characters. I have found that running PHP’s utf_decode method on tweets didn’t have the expected result, so my recommendation is to instead set the charset of your HTML page to UTF-8. Really we should all be doing this anyway. (http://www.w3.org/International/O-charset)


Credits
========================

webpush-php-o-auth by andrewbiggart
https://github.com/andrewbiggart/webpush-php-o-auth

Orginally using Pixel Acres script (http://f6design.com/journal/2010/10/07/display-recent-twitter-tweets-using-php/). But since Twitter has retired API v1.0, the script no longer worked because it didn't include authentication. I have now modified the script to include authentication using API v1.1.

The hashtag/username parsing in andrewbiggart example is from Get Twitter Tweets (http://snipplr.com/view/16221/get-twitter-tweets/) by gripnrip (http://snipplr.com/users/gripnrip/).

andrewbiggart RSS parsing is based on replies in the forum discussion "embedding twitter tweets" on the Boagworld website. (http://boagworld.com/forum/comments.php?DiscussionID=4639)

Authentication with Twitter uses twitteroauth. (https://github.com/abraham/twitteroauth)

## To Do

- [ ] Add Grav Caching

License
========================

The MIT License (MIT)

Copyright (c) 2013 Andrew Biggart

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

