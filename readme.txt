=== Plugin Name ===
Contributors: Roamfox
Donate link: http://roamfox.com/
Tags: options,theme,template
Requires at least: 2.0.2
Tested up to: 2.71
Stable tag: trunk

This plugin is mainly for themes developers to save the themes data via a xml file.

== Description ==

This plugin is mainly for themes developers to save the themes data via a xml file.

Or If you are a normal user know a little about the wordpress theme,and can code a little,this plugin will actually help you!

Why roamfox extra options:
 1.use xml to save the data and add no extra date to your database. It is clean and green.
 2.define any date you want with no restrict in template even if you have no access to the user database
 
I strongly recommand that you integrate this plugin into your themes.

== Installation ==

This section describes how to install the plugin and get it working.


1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3.
Useage:(if you are still can not understant pls open the attached screenshot,may be help. or visit our site to get a help)

roamfox_fetch_option_content($option_name) $option_name is the value of the first column of the row

example: roamfox_fetch_option_content('twitter') returns 'roamfox'


roamfox_fetch_single_option($option_name)  $option_name is the value of the first column in a row ,returns the data of row

example: 
	$roamfox_option =  roamfox_fetch_single_option('twitter')
	
	$roamfox_option is like this
	
	$roamfox_option['name']='twitter';
	$roamfox_option['content']='roamfox';
	$roamfox_option['description']='this is my twitter account'


roamfox_fetch_options() returns all the options data of your xml as a array
	
	$roamfox_options =  roamfox_fetch_options()
	
	$roamfox_options is like this
	$roamfox_option[0]['name']='twitter';
	$roamfox_option[0]['content']='roamfox';
	$roamfox_option[0]['description']='this is my twitter account'
	
	$roamfox_option[1]['name']='options_name';
	$roamfox_option[1]['content']='option_content';
	$roamfox_option[1]['description']='option_description';


== Frequently Asked Questions ==
faq

= A question that someone might have =
question some have

= What about foo bar? =
foo bar.

== Screenshots ==

screenshots desp

== Arbitrary section ==

I have not fill 

== A brief Markdown Example ==

brief