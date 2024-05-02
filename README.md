<b>This plugin is still under development</b><br>

# BanSpam plugin for Mantisbt

Version 1.00
Copyright 2024 Cas Nuy

## Description

The BanSpam plugin tries to block spammers:
- Ensuring issues/notes can only be raised in one(1) language
- Offering the option to block ip (ranges)

Blacklists can be uploaded in bulk using csv file.

## Requirements

Mantis 2.x

## Installation

Copy the BanSpam directory into the plugins folder of your installation.<br>
After copying to your webserver:<br>
- Start Mantis as administrator<br>
- Select manage<br>
- Select manage Plugins<br>
- Select Install behind BanSpam 1.00<br>
- Click on the plugin name for further configuration (se below)<br>

In case you want to check already during login<br>
Please add a line to login.php. just after<br>
$t_user_id = auth_get_user_id_from_login_name( $f_username );<br>
Line to insert:<br>
$continue = event_signal( 'EVENT_LOGIN_CHECK' );<br>

In case you want to check already during signup<br>
Please add a line to signup.php. just after<br>
$f_captcha = mb_strtolower( trim( $f_captcha ) );<br>
Line to insert:<br>
$continue = event_signal( 'EVENT_SIGNUP_CHECK' );

## Configuration options

- Set language to use for issues/notes (supported en-de-fr-es)
- Set fallback language in case of ambiguous result (?? means abort, otherwise set to language defined above)
- What is the minimum number of characters to activate language check?
- Do you wat to check during logon yes/no?
- Do you want to check during signup?
- What is the contact e-mail (if any)?

## License

Released under the [GPL v3 license](http://opensource.org/licenses/GPL-3.0).

## Todo

Allow for multiple languages.

## Support

Please visit https://github.com/mantisbt-plugins/BanSpam

## Changes

Version 1.00	02-05-2024	Initial release<br>
