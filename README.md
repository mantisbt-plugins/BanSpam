# BanSpam plugin for Mantisbt

Version 1.00
Copyright 2024 Cas Nuy

## Description

The BanSpam plugin tries to block spammers:
- Ensuring issues/notes can only be raisedin one(1) language
- Offering the option to block ip (ranges)

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

In order to make it work on notes, we need to make a change to core/commands/IssueNoteAddCommand.php.<br>
Just before the line:<br>
$this->user_id = auth_get_current_user_id();<br>
add the following line:<br>
event_signal( 'EVENT_BUGNOTE_CHECK', $this->text );
Hopefully this event will be added to Mantis standard.

## Configuration

- Set language to use for issues/notes (supported en-de-fr-es)

## License

Released under the [GPL v3 license](http://opensource.org/licenses/GPL-3.0).

## Todo

Allow for multiple languages.

## Support

Please visit https://github.com/mantisbt-plugins/BanSpam

## Changes

Version 1.00	01-05-2024	Initial release<br>
