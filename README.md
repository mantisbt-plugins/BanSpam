
# BanSpam plugin for Mantisbt

Version 1.20
Copyright 2024 Cas Nuy

## Description

The BanSpam plugin tries to block spammers:
- Ensuring issues/notes can only be raised in one(1) language
- Offering the option to block ip (ranges)
- Quarantining of newe issues/notes
- Issues/notes can, during language check, automatically allowed based upon a set number of issues/notes in the DB.<br>
- Blacklists can be uploaded in bulk using csv file.<br>

## Requirements

Mantis 2.x

## Installation

Copy the BanSpam directory into the plugins folder of your installation.<br>
After copying to your webserver:<br>
- Start Mantis as administrator<br>
- Select manage<br>
- Select manage Plugins<br>
- Select Install behind BanSpam 1.10<br>
- Click on the plugin name for further configuration (see below)<br>

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

## Documentation

In the 'doc' directory, you find a Word document describing this plugin.

## Configuration options

- Set language to use for issues/notes (supported en-de-fr-es)
- Set fallback language in case of ambiguous result (?? means abort, otherwise set to language defined above)
- What is the minimum number of characters to activate language check?
- Automatic approve text with less characters thatn the minimum stated above
- Do you want to check during logon yes/no?
- Do you want to check during signup?
- What is the contact e-mail (if any)?
- What is the minimum number of issues to allow approval always (language check)?
- What is the minimum number of notes to allow approval always  (language check)?


# Bulk upload ip-ranges

The directory doc contains a sample csv file.<br>
Be aware that the import will skip the first line, so please leave the header row in place.<br>
Also make sure that you choose the correct column separator while using that function.<br>
Default it is set to a comma but it just as well can be a semicolon.<br>
An error message will popup in case you use the wrong separator.

## License

Released under the [GPL v3 license](http://opensource.org/licenses/GPL-3.0).

## Todo

Allow for multiple languages.
Handling attachments of quarantained items

## Support

Please visit https://github.com/mantisbt-plugins/BanSpam

## Changes

Version 1.00	02-05-2024	Initial release<br>
Version 1.01	03-05-2024	Added sample import file and adjusted the readme<br>
Version 1.10	06-05-2024	Added quarantaining of new issues/notes for admin review<br>
							Added interface for management of quarantained items<br>
Version 1.11	13-05-2024	Fixed issue with curly brackets<br>
Version 1.20	06-06-2024	Added options to "always allow" after a set number of issues/notes (language check).
