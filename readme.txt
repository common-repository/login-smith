=== Login Smith tokenized logins ===
Contributors: Gregor Schilling
Tags: login, tokens, file login, url login, link login
Requires at least:  4.9.8
Tested up to:  4.9.8
Stable tag:  4.9.8
License: GPLv2 or later

== Description ==

This is the beta version of Electronics Key Smith (EKS) Word press plugin demonstrating basic principles for EKSs login and authentication software suite based on tokenized logins. You can use it to generate token logins and use these logins to login to your wordpress account. Find the generator and an overview of your token logins at Login Smith, when you are logged in. When generating a login you will be given a link or an html file. The link allows you to login to your account. The file allows you to login by opening the html file. A first glimpse into what additional features the suite holds is presented by the passcode, which can be set to increase login security. Find out more about it on our website or get in touch with us.

http://ekeysmith.com/wordpressroot/authentication-login/

Usage:
When logged in goto LoginSmith. Create a login pass. Copy the displayed url somewhere save or save the file. Logout. Login using the file or the link.
 

Major features in Login include:

* LoginSmith site to generate logins with an overview of existing logins


== Installation ==

Upload the Loginsmith plugin to your blog, Activate it. Now you can generate logins at LoginSmith

1, 2, 3: You're done!

== Changelog ==

= 0.0.3 =
* Info added when user gets link
* Error messanges added when wrong input format is given
* Bug fix, options were only presented to the admin
* Bug fix, plugin should now work for all users

= 0.0.2 =
* Date December 18 (first revision)
* sends out an email, when too many warnigns are triggered
* fixed multible issues with the code

= 0.0.1 =
*Release Date - 14 December 2018*

* Upload the Loginsmith plugin to your blog, Activate it. Now you can generate logins at Settings->LoginSmith
* Tested for Wordpress 4.9.8
Bugs:
* The warning counter is not reset when logging in
* Deactivation hook does not work. After deactivation the table won't be deleted, which was found to be useful.

