=== AS Instabuilder Countdown Helper ===
Contributors: gMagicScott 
Tags: instabuilder, amazing system
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 0.2

Wraps Instabuilder's countdown shortcode so a date can be "injected" from $_GET or $POST

Useage:
`[as_countdown field="ndate"]`

Other fields:
- **style**: defaults to "dark", other options: "red", "light"
- **timezone**: defaults to 0. You may need this depending on you webserver's time
- **redirect**: defaults to null. Use a URL to redirect page when timer hits zero
- **date_format**: defaults to m/d/Y. See [PHP Date Docs](http://php.net/manual/en/function.date.php) for more formats.
- **date_offset**: defaults to false. See [PHP Date Offset Docs]() for valid formats.
- **neg_date_offset**: defaults to false. Make true to offset negative days since *date_offset* can only accept positive integers.

If there is an error, logged in admins will see the message "Invalid Date Format for Countdown" where the countdown should be. Others will see nothing.

If no date is passed in either the URL parameters or POST data, a 24-hour countdown will display.


== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.