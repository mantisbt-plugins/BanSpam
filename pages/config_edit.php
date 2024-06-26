<?php
// authenticate
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
// Read results
$f_language			= gpc_get_string( 'language','en' );
$f_default			= gpc_get_string( 'default','??' );
$f_check_login		= gpc_get_int( 'check_login',OFF );
$f_check_signup		= gpc_get_int( 'check_signup',OFF );
$f_contact_mail		= gpc_get_string( 'contact_mail','admin@yoursite.com' );
$f_min_chars		= gpc_get_int( 'min_chars', 25 );
$f_min_chars_ok		= gpc_get_int( 'min_chars_ok', OFF );
$f_min_issues		= gpc_get_int( 'min_issues', 5 );
$f_min_notes		= gpc_get_int( 'min_notes', 5 );

// update results
plugin_config_set( 'language', $f_language );
plugin_config_set( 'default', $f_default );
plugin_config_set( 'check_login', $f_check_login );
plugin_config_set( 'check_signup', $f_check_signup );
plugin_config_set( 'contact_mail', $f_contact_mail );
plugin_config_set( 'min_chars', $f_min_chars );
plugin_config_set( 'min_chars_ok', $f_min_chars_ok );
// redirect
print_header_redirect( "manage_plugin_page.php" );